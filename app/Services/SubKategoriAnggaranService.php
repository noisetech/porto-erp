<?php

namespace App\Services;

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubKategoriAnggaranService
{
    public function datatable(Request $request): array
    {
        $start  = (int) $request->start;
        $length = (int) $request->length;
        $draw   = (int) $request->draw;
        $search = $request->search['value'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */
        $baseQuery = DB::table('sub_kategori_anggaran')
            ->join(
                'kategori_anggaran',
                'kategori_anggaran.id',
                '=',
                'sub_kategori_anggaran.kategori_anggaran_id'
            )
            ->leftJoin(
                'mapping_sub_kategori_coa',
                'sub_kategori_anggaran.id',
                '=',
                'mapping_sub_kategori_coa.sub_kategori_anggaran_id'
            )
            ->leftJoin(
                'coa',
                'coa.id',
                '=',
                'mapping_sub_kategori_coa.coa_id'
            )
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

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */
        if ($search) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('sub_kategori_anggaran.nama_sub_kategori', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.kode_akun', 'ILIKE', "%{$search}%")
                    ->orWhere('coa.nama_akun', 'ILIKE', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | RECORDS TOTAL
        |--------------------------------------------------------------------------
        */
        $recordsTotal = DB::table('sub_kategori_anggaran')
            ->whereNull('deleted_at')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RECORDS FILTERED
        |--------------------------------------------------------------------------
        */
        $recordsFiltered = $this->countFiltered($search);

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $data = $baseQuery
            ->offset($start)
            ->limit($length)
            ->get();

        return [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $this->formatData($data, $start)
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER: COUNT FILTERED
    |--------------------------------------------------------------------------
    */
    private function countFiltered(?string $search): int
    {
        $query = DB::table('sub_kategori_anggaran')
            ->leftJoin(
                'mapping_sub_kategori_coa',
                'sub_kategori_anggaran.id',
                '=',
                'mapping_sub_kategori_coa.sub_kategori_anggaran_id'
            )
            ->leftJoin(
                'coa',
                'coa.id',
                '=',
                'mapping_sub_kategori_coa.coa_id'
            )
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

    /*
    |--------------------------------------------------------------------------
    | HELPER: FORMAT DATA
    |--------------------------------------------------------------------------
    */
    private function formatData($rows, int $start): array
    {
        $result = [];
        $no = $start + 1;

        foreach ($rows as $row) {

            $coaHtml = '-';

            if ($row->kode_akun_coa) {
                $coaHtml = '<div class="d-flex flex-wrap">';
                foreach (explode(',', $row->kode_akun_coa) as $item) {
                    $coaHtml .= '<span class="badge bg-primary text-white m-1">'
                        . e($item) .
                        '</span>';
                }
                $coaHtml .= '</div>';
            }

            $result[] = [
                'no'     => $no++,
                'id'     => $row->id,
                'kode'   => $row->kode_sub_kategori,
                'nama'   => $row->nama_sub_kategori,
                'keterangan' => $row->keterangan,
                'kode_kategori_anggaran' => $row->kode_kategori_anggaran,
                'coa'    => $coaHtml,
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
