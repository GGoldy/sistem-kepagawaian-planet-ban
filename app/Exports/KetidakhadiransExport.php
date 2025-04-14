<?php

namespace App\Exports;

use App\Models\Ketidakhadiran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class KetidakhadiransExport implements FromCollection, WithHeadings
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
        $query = Ketidakhadiran::with(['karyawan', 'approvedBy', 'approvedByHcm']);

        if ($this->userId) {
            $query->where('karyawan_id', $this->userId);
        }

        $data = $query->get([
            'karyawan_id',
            'approved_by',
            'approved_by_hcm',
            'signature',
            'signature_hcm',
            'tanggal_pengajuan',
            'status_pengajuan',
            'jenis_ketidakhadiran',
            'tanggal_mulai',
            'tanggal_berakhir',
            'tanggal_pengganti',
            'tujuan',
            'tanggal_sah',
            'tanggal_aktif',
            'catatan',
            'created_at',
            'updated_at'
        ]);

        return $data->map(function ($item, $index) {
            return [
                'No' => $index + 1,
                'Karyawan' => $item->karyawan->nama,
                'Disetujui Oleh' => optional($item->approvedBy)->nama,
                'Disetujui HCM' => optional($item->approvedByHcm)->nama,
                'Signature' => $item->signature,
                'Signature HCM' => $item->signature_hcm,
                'Tanggal Pengajuan' => $item->tanggal_pengajuan,
                'Status Pengajuan' => $item->status_pengajuan ? 'Disetujui' : 'Belum Disetujui',
                'Jenis Ketidakhadiran' => $item->jenis_ketidakhadiran,
                'Tanggal Mulai' => $item->tanggal_mulai,
                'Tanggal Berakhir' => $item->tanggal_berakhir,
                'Tanggal Pengganti' => is_array($item->tanggal_pengganti) ? implode(', ', $item->tanggal_pengganti) : $item->tanggal_pengganti,
                'Tujuan' => $item->tujuan,
                'Tanggal Sah' => $item->tanggal_sah,
                'Tanggal Aktif' => $item->tanggal_aktif,
                'Catatan' => $item->catatan,
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
            'Signature',
            'Signature HCM',
            'Tanggal Pengajuan',
            'Status Pengajuan',
            'Jenis Ketidakhadiran',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Tanggal Pengganti',
            'Tujuan',
            'Tanggal Sah',
            'Tanggal Aktif',
            'Catatan',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
