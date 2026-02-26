<?php

namespace App\Repositories\Query;

use App\Models\KategoriAnggaran;
use App\Models\LogSubKategoriAnggaran;
use App\Models\ModelCoa;
use App\Models\SubKategoriAnggaran;
use App\Repositories\Interfaces\SubKategoriAnggaranRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuerySubKategoriAnggaranRepository implements SubKategoriAnggaranRepositoryInterface
{

    public function simpanLog(array $data): LogSubKategoriAnggaran
    {
        return  LogSubKategoriAnggaran::create($data);
    }

    public function simpanSubKategoriAnggaran(array $data): SubKategoriAnggaran
    {
        return DB::transaction(function () use ($data) {
            return tap(
                SubKategoriAnggaran::create([
                    'kategori_anggaran_id' => $data['kategori_anggaran'],
                    'kode_sub_kategori'    => $data['kode'],
                    'nama_sub_kategori'    => $data['nama'],
                    'keterangan'           => $data['keterangan'],
                ]),
                function (SubKategoriAnggaran $subKategori) use ($data) {
                    $this->simpanLog([
                        'user_id' => Auth::id(),
                        'sub_kategori_anggaran_id' => $subKategori->id,
                        'keterangan' => 'menambahkan data',
                    ]);
                    if (!empty($data['coa'])) {
                        $subKategori->coa()->attach($data['coa']);
                    }
                    $subKategori->load(['coa', 'kategoriAnggaran']);
                }
            );
        });
    }

    public function update(int $id, array $data): SubKategoriAnggaran
    {
        return DB::transaction(function () use ($id, $data) {

            return tap(
                SubKategoriAnggaran::findOrFail($id),
                function (SubKategoriAnggaran $subKategori) use ($data) {
                    $subKategori->update([
                        'kategori_anggaran_id' => $data['kategori_anggaran'],
                        'kode_sub_kategori'    => $data['kode'],
                        'nama_sub_kategori'    => $data['nama'],
                        'keterangan'           => $data['keterangan'],
                    ]);
                    if (isset($data['coa'])) {
                        $subKategori->coa()->sync($data['coa']);
                    }
                    $this->simpanLog([
                        'user_id' => Auth::id(),
                        'sub_kategori_anggaran_id' => $subKategori->id,
                        'keterangan' => 'mengubah data',
                    ]);
                    $subKategori->load(['coa', 'kategoriAnggaran']);
                }
            );
        });
    }


    public function listKategoriAnggaran(?string $search = null): array
    {
        $query = KategoriAnggaran::query()
            ->select('id', 'kode_kategori', 'nama_kategori')
            ->whereNull('deleted_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_kategori', 'LIKE', "%{$search}%")
                    ->orWhere('nama_kategori', 'LIKE', "%{$search}%");
            });
        }

        return $query->get()->map(function ($kategori_anggaran) {
            return [
                'id' => $kategori_anggaran->id,
                'text' => $kategori_anggaran->kode_kategori . ' | ' . $kategori_anggaran->nama_kategori
            ];
        })->toArray();
    }

    public function listCoa(?string $search = null): array
    {
        $query = ModelCoa::query()
            ->select('id', 'kode_akun', 'nama_akun')
            ->whereNull('deleted_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_akun', 'LIKE', "%{$search}%")
                    ->orWhere('nama_akun', 'LIKE', "%{$search}%");
            });
        }

        return $query->get()->map(function ($kategori_anggaran) {
            return [
                'id' => $kategori_anggaran->id,
                'text' => $kategori_anggaran->kode_akun . ' | ' . $kategori_anggaran->nama_akun
            ];
        })->toArray();
    }

    public function queryBedasarkanId(int $id): ?SubKategoriAnggaran
    {
        return SubKategoriAnggaran::with([
            'coa',
            'kategoriAnggaran'
        ])
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
    }

    public function hapus(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $subKategori = SubKategoriAnggaran::with('coa')->findOrFail($id);

            $subKategori->coa()->detach();
            $subKategori->delete();

            $this->simpanLog([
                'sub_kategori_anggaran_id' => $subKategori->id,
                'user_id'                  =>  Auth::user()->id,
                'keterangan'               => 'menghapus data'
            ]);

            return true;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Bagian Khusus Custom Datatable Tanpa Library
    |--------------------------------------------------------------------------
    */

    public function customDataTable(Request $request): array
    {
        $start  = (int) $request->start;
        $length = (int) $request->length;
        $draw   = (int) $request->draw;
        $search = $request->search['value'] ?? null;

        $baseQuery = DB::table('sub_kategori_anggaran')
            ->join('kategori_anggaran', 'kategori_anggaran.id', '=', 'sub_kategori_anggaran.kategori_anggaran_id')
            ->leftJoin('mapping_sub_kategori_coa', 'sub_kategori_anggaran.id', '=', 'mapping_sub_kategori_coa.sub_kategori_anggaran_id')
            ->leftJoin('coa', 'coa.id', '=', 'mapping_sub_kategori_coa.coa_id')
            ->select(
                'sub_kategori_anggaran.id',
                'sub_kategori_anggaran.kode_sub_kategori',
                'sub_kategori_anggaran.nama_sub_kategori',
                'sub_kategori_anggaran.keterangan',
                'kategori_anggaran.kode_kategori as kode_kategori_anggaran',
                DB::raw("STRING_AGG(coa.kode_akun || ' | ' || coa.nama_akun, ',') as kode_akun_coa")
            )
            ->whereNull('sub_kategori_anggaran.deleted_at')
            ->groupBy(
                'sub_kategori_anggaran.id',
                'sub_kategori_anggaran.kode_sub_kategori',
                'sub_kategori_anggaran.nama_sub_kategori',
                'sub_kategori_anggaran.keterangan',
                'kategori_anggaran.kode_kategori'
            );

        if ($search) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('sub_kategori_anggaran.nama_sub_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.nama_akun', 'ILIKE', "%{$search}%");
            });
        }

        $recordsTotal = DB::table('sub_kategori_anggaran')
            ->whereNull('deleted_at')
            ->count();

        $recordsFiltered = $this->countFiltered($search);

        $data = $baseQuery
            ->offset($start)
            ->limit($length)
            ->get();

        return [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $this->formated($data, $start)
        ];
    }

    private function countFiltered(?string $search): int
    {
        $query = DB::table('sub_kategori_anggaran')
            ->leftJoin('mapping_sub_kategori_coa', 'sub_kategori_anggaran.id', '=', 'mapping_sub_kategori_coa.sub_kategori_anggaran_id')
            ->leftJoin('coa', 'coa.id', '=', 'mapping_sub_kategori_coa.coa_id')
            ->whereNull('sub_kategori_anggaran.deleted_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sub_kategori_anggaran.nama_sub_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.nama_akun', 'ILIKE', "%{$search}%");
            });
        }

        return $query->distinct('sub_kategori_anggaran.id')
            ->count('sub_kategori_anggaran.id');
    }

    private function formated($rows, int $start): array
    {
        $result = [];
        $no = $start + 1;

        foreach ($rows as $row) {
            $coaHtml = '-';
            if ($row->kode_akun_coa) {
                $coaHtml = '<div class="d-flex flex-wrap">';
                foreach (explode(',', $row->kode_akun_coa) as $item) {
                    $coaHtml .= '<span class="badge bg-primary text-white m-1">' . e($item) . '</span>';
                }
                $coaHtml .= '</div>';
            }

            $result[] = [
                'no' => $no++,
                'id' => $row->id,
                'kode' => $row->kode_sub_kategori,
                'nama' => $row->nama_sub_kategori,
                'keterangan' => $row->keterangan,
                'kode_kategori_anggaran' => $row->kode_kategori_anggaran,
                'coa' => $coaHtml,
                'action' => $this->actionButton($row->id)
            ];
        }

        return $result;
    }

    private function actionButton(int $id): string
    {
        return '
            <a class="badge bg-secondary text-white" data-id="' . $id . '" id="edit">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a class="badge bg-secondary text-white" data-id="' . $id . '" id="hapus">
                <i class="bi bi-trash2"></i> Hapus
            </a>
        ';
    }
}
