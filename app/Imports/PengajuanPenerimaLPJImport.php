<?php

namespace App\Imports;

use App\Models\PengajuanPenerimaLPJ;
use Maatwebsite\Excel\Concerns\ToModel;


use App\Models\ArsipDigital;
use Illuminate\Support\Str;

use App\Models\Siswa;
use App\Models\TableArsip;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;


class PengajuanPenerimaLPJImport implements ToCollection, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            PengajuanPenerimaLPJ::create([
                'id_pengajuan_penerima' => Str::uuid()->toString(),
                'tgl_bantuan' => $row[0],
                'nama' => $row[1],
                'nik' => $row[2],
                'nokk' => $row[3],
                'nohp' => $row[4],
                'nominal_bantuan' => $row[5],
                'jenis_bantuan' => $row[6],
                'alamat' => $row[7],
                'keterangan' => $row[8],
            ]);
        }
    }

    public function startRow(): int
    {
        return 7;
    }
}

