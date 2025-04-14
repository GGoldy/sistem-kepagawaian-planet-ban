<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class RekapPenilaianExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Karyawan::select('nik', 'nama')->get()->map(function ($karyawan) {
            return [
                'NIK' => '"' . $karyawan->nik . '"',
                'Nama' => $karyawan->nama,
                'SKOR PA' => null,
                'KATEGORI' => null,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['NIK', 'Nama', 'SKOR PA', 'KATEGORI'];
    }
}
