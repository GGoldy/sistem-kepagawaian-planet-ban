<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class KaryawansExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Karyawan::with(['statuspegawai', 'penugasan', 'gaji']);

        $data = $query->get();

        return $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Nama' => $item->nama,
                'NIK' => $item->nik,
                'Jabatan' => $item->jabatan,
                'Tanggal Lahir' => $item->tanggal_lahir,
                'Tempat Lahir' => $item->tempat_lahir,
                'Jenis Kelamin' => $item->jenis_kelamin,
                'Status Pernikahan' => $item->status_pernikahan,
                'Agama' => $item->agama,
                'Pendidikan Terakhir' => $item->pendidikan_terakhir,
                'Alamat' => $item->alamat,
                'Kota' => $item->kota,
                'Provinsi' => $item->provinsi,
                'Negara' => $item->negara,
                'Kode Pos' => $item->kode_pos,
                'No. Telepon Rumah' => $item->no_telepon_rumah,
                'No. HP' => $item->no_telepon_handphone,
                'Email' => $item->email,
                'Status Kerja' => optional($item->statuspegawai)->status_kerja ?? '-',
                'Mulai Kerja' => optional($item->statuspegawai)->mulai_kerja ?? '-',
                'Akhir Kerja' => optional($item->statuspegawai)->akhir_kerja ?? '-',
                'Alasan Berhenti' => optional($item->statuspegawai)->alasan_berhenti ?? '-',
                'Perusahaan' => optional($item->penugasan)->perusahaan ?? '-',
                'Area' => optional($item->penugasan)->area ?? '-',
                'Unit' => optional($item->penugasan)->unit ?? '-',
                'Level' => optional($item->penugasan)->level ?? '-',
                'Grade' => optional($item->penugasan)->grade ?? '-',
                'Gaji Pokok' => optional($item->gaji)->gaji_pokok ?? '-',
                'Tunjangan BPJS' => optional($item->gaji)->tunjangan_bpjs ?? '-',
                'Uang Makan' => optional($item->gaji)->uang_makan ?? '-',
                'Dibuat Pada' => $item->created_at,
                'Diperbarui Pada' => $item->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIK',
            'Jabatan',
            'Tanggal Lahir',
            'Tempat Lahir',
            'Jenis Kelamin',
            'Status Pernikahan',
            'Agama',
            'Pendidikan Terakhir',
            'Alamat',
            'Kota',
            'Provinsi',
            'Negara',
            'Kode Pos',
            'No. Telepon Rumah',
            'No. HP',
            'Email',
            'Status Kerja',
            'Mulai Kerja',
            'Akhir Kerja',
            'Alasan Berhenti',
            'Perusahaan',
            'Area',
            'Unit',
            'Level',
            'Grade',
            'Gaji Pokok',
            'Tunjangan BPJS',
            'Uang Makan',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
