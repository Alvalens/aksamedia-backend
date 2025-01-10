<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    public function getNilaiRT()
    {
        $pelajarnas = DB::table('nilai')
            ->where('materi_uji_id', 7)
            ->where('nama_pelajaran', '!=', 'Pelajaran Khusus')
            ->distinct()
            ->pluck('nama_pelajaran')
            ->toArray();

        $select = ['nama', 'nisn'];

        foreach ($pelajarnas as $pelajaran) {
            $select[] = DB::raw("SUM(CASE WHEN nama_pelajaran = '{$pelajaran}' THEN skor ELSE 0 END) as `{$pelajaran}`");
        }

        $nilaiRT = DB::table('nilai')
            ->select($select) // select nama, nisn, sum(case when nama_pelajaran = 'nama_pelajaran' then skor else 0 end) as `nama_pelajaran` ...
            ->where('materi_uji_id', 7)
            ->where('nama_pelajaran', '!=', 'Pelajaran Khusus')
            ->groupBy('nama', 'nisn')
            ->get();

        dd($nilaiRT);

        return response()->json($nilaiRT);
    }

    public function getNilaiST()
    {
        $select = [
            'nama',
            'nisn',
            DB::raw("
            SUM(
                CASE
                    WHEN pelajaran_id = 44 THEN skor * 41.67
                    WHEN pelajaran_id = 45 THEN skor * 29.67
                    WHEN pelajaran_id = 46 THEN skor * 100
                    WHEN pelajaran_id = 47 THEN skor * 23.81
                    ELSE 0
                END
            ) as total_nilai
        ")
        ];

        $nilaiST = DB::table('nilai')
            ->select($select)
            ->where('materi_uji_id', 4)
            ->groupBy('nama', 'nisn')
            ->orderByDesc('total_nilai')
            ->get();

        dd($nilaiST);

        return response()->json($nilaiST);
    }

    // public function getNilaiST()
    // {
    //     $weights = [
    //         44 => 41.67,
    //         45 => 29.67,
    //         46 => 100,
    //         47 => 23.81,
    //     ];

    //     $nilaiRecords = DB::table('nilai')
    //     ->where('materi_uji_id', 4)
    //     ->get();

    //     $grouped = $nilaiRecords->groupBy('nisn');
    //     $result = [];

    //     foreach ($grouped as $nisn => $group) {
    //         $nama = $group->first()->nama;

    //         $listnilai = [];
    //         $total_nilai = 0;

    //         foreach ($group as $item) {
    //             if (isset($weights[$item->pelajaran_id])) {
    //                 $nilai = round($item->skor * $weights[$item->pelajaran_id], 2);
    //                 $listnilai[$item->nama_pelajaran] = $nilai;
    //                 $total_nilai += $nilai;
    //             }
    //         }

    //         $result[] = [
    //             'nama' => $nama,
    //             'nisn' => $nisn,
    //             'listnilai' => $listnilai,
    //             'total_nilai' => round($total_nilai, 2),
    //         ];
    //     }
    //     dd($result);

    //     return response()->json($result);
    // }

}
