<?php

namespace App\Exports;

use App\Models\Lembur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class LembursExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $userId;

    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        $query = Lembur::with(['karyawan', 'approvedBy', 'approvedByHcm', 'perintahatasan']);

        if ($this->userId) {
            $query->where('karyawan_id', $this->userId);
        }

        $data = $query->get([
            'karyawan_id',
            'approved_by',
            'approved_by_hcm',
            'atasan',
            'signature',
            'signature_hcm',
            'tanggal_pengajuan',
            'status_pengajuan',
            'tanggal_mulai',
            'tanggal_berakhir',
            'jam_lembur',
            'tanggal_sah',
            'tugas',
            'created_at',
            'updated_at'
        ]);

        return $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Karyawan' => $item->karyawan->nama,
                'Disetujui Oleh' => optional($item->approvedBy)->nama,
                'Disetujui HCM' => optional($item->approvedByHcm)->nama,
                'Perintah Atasan' => optional($item->perintahatasan)->nama,
                'Signature' => $item->signature,
                'Signature HCM' => $item->signature_hcm,
                'Tanggal Pengajuan' => $item->tanggal_pengajuan,
                'Status Pengajuan' => $item->status_pengajuan ? 'Disetujui' : 'Belum Disetujui',
                'Tanggal Mulai' => $item->tanggal_mulai,
                'Tanggal Berakhir' => $item->tanggal_berakhir,
                'Jam Lembur' => is_array($item->jam_lembur)
                    ? collect($item->jam_lembur)->map(fn($val, $key) => "$key: $val")->implode(', ')
                    : $item->jam_lembur,
                'Tanggal Sah' => $item->tanggal_sah,
                'Tugas' => $item->tugas,
                'Dibuat Pada' => $item->created_at,
                'Diperbarui Pada' => $item->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Karyawan',
            'Disetujui Oleh',
            'Disetujui HCM',
            'Perintah Atasan',
            'Signature',
            'Signature HCM',
            'Tanggal Pengajuan',
            'Status Pengajuan',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Jam Lembur',
            'Tanggal Sah',
            'Tugas',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
