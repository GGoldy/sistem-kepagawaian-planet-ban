<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::with(['karyawan', 'roles'])->get();

        return $users->map(function ($user, $index) {
            return [
                'No' => $index + 1,
                'NIK' => $user->name,
                'Nama Karyawan' => optional($user->karyawan)->nama ?? '-',
                'Peran' => $user->roles->pluck('title')->implode(', '),
                'Dibuat Pada' => $user->created_at,
                'Diperbarui Pada' => $user->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Nama Karyawan',
            'Peran',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
