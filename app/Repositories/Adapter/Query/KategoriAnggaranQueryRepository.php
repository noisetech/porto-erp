<?php

namespace App\Repositories\Adapter\Query;
use App\Repositories\Interfaces\KategoriAnggaranQueryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriAnggaranQueryRepository implements KategoriAnggaranQueryRepositoryInterface
{
    public function customDataTable(Request $request): array
    {
        $start  = (int) $request->start;
        $length = (int) $request->length;
        $draw   = (int) $request->draw;
        $search = $request->search['value'] ?? null;

        $baseQuery = DB::table('kategori_anggaran')
            ->select('kategori_anggaran.*')
            ->where('kategori_anggaran.deleted_at', null);

        if ($search) {
            $baseQuery->where('kategori_anggaran.kode_kategori', 'ILIKE', "%$search%");
        }

        $recordsTotal = DB::table('kategori_anggaran')
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
        $query = DB::table('kategori_anggaran')
            ->whereNull('kategori_anggaran.deleted_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kategori_anggaran.kode_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('kategori_anggaran.nama_kategori', 'ILIKE', "%{$search}%");
            });
        }

        return $query->count('kategori_anggaran.id');
    }

    private function formated($rows, int $start): array
    {
        $result = [];
        $no = $start + 1;

        foreach ($rows as $row) {


            $result[] = [
                'no' => $no++,
                'id' => $row->id,
                'kode_kategori' => $row->kode_kategori,
                'nama_kategori' => $row->nama_kategori,
                'aktif' => $row->aktif,
                'keterangan' => $row->keterangan,
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
