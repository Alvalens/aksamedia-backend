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
        $weights = [
            44 => 41.67,
            45 => 29.67,
            46 => 100,
            47 => 23.81,
        ];

        $nilais = DB::table('nilai')
        ->where('materi_uji_id', 4)
            ->get();

        $grouped = $nilais->groupBy(function ($item) {
            return $item->nama . '|' . $item->nisn;
        });

        $result = [];

        foreach ($grouped as $group) {
            list($nama, $nisn) = explode('|', $group->first()->nama . '|' . $group->first()->nisn);
            $listnilai = [];
            $total_nilai = 0;

            foreach ($group as $item) {
                if (isset($weights[$item->pelajaran_id])) {
                    $nilai = $item->skor * $weights[$item->pelajaran_id];
                    $listnilai[$item->nama_pelajaran] = round($nilai, 2);

                    $total_nilai += $nilai;
                }
            }

            $result[] = [
                'listnilai' => $listnilai,
                'nama' => $nama,
                'nisn' => $nisn,
                'total_nilai' => round($total_nilai, 2),
            ];
        }
        
        dd($result);

        return response()->json($result);
    }

}
