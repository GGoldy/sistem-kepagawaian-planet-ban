<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class PenilaiansExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $penilaians =  Penilaian::with(['karyawan', 'penilai'])->get();

        return $penilaians->map(function ($penilaian, $index) {
            return [
                'No' => $index + 1,
                'Nama Karyawan' => optional($penilaian->karyawan)->nama ?? '-',
                'Nama Penilai' => optional($penilaian->penilai)->nama ?? '-',
                'Penilaian Periode Bulan' => $penilaian->bulan_penilaian,
                'Penilaian Periode Tahun' => $penilaian->tahun_penilaian,
                'Kinerja' => $penilaian->kinerja,
                'Kehadiran' => $penilaian->kehadiran,
                'Kerja Sama Tim' => $penilaian->kerjasama_tim,
                'Dibuat Pada' => $penilaian->created_at,
                'Diperbarui Pada' => $penilaian->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Karyawan',
            'Nama Penilai',
            'Penilaian Periode Bulan',
            'Penilaian Periode Tahun',
            'Kinerja',
            'Kehadiran',
            'Kerja Sama Tim',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
