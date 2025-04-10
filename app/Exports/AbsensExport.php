<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Carbon\Carbon;
use App\Models\Karyawan;
use App\Models\Absen;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AbsensExport implements FromArray, WithHeadings, WithEvents, WithTitle, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $month;
    protected $year;
    protected $userId;

    public function __construct($month = 3, $year = 2025, $userId = null)
    {

        $this->month = $month;
        $this->year = $year;
        $this->userId = $userId;
    }

    public function array(): array
    {
        $karyawans = Karyawan::with(['absen', 'ketidakhadiran'])->get();
        $totalDays = Carbon::createFromDate((int) $this->year, (int) $this->month, 1)->daysInMonth;
        $data = [];
        $index = 1;

        foreach ($karyawans as $karyawan) {
            $row = [
                'No' => $index++,
                'NIK' => '"' . $karyawan->nik . '"',
                'Nama' => $karyawan->nama,
            ];

            $izin = 0;
            $sakit = 0;
            $hadir = 0;
            $mangkir = 0;

            for ($day = 1; $day <= $totalDays; $day++) {
                $date = Carbon::createFromDate((int) $this->year, (int) $this->month, (int) $day);
                $dateString = $date->toDateString();

                // Detect weekend
                $isWeekend = $date->isSunday();

                $absen = $karyawan->absen->first(function ($a) use ($date) {
                    return Carbon::parse($a->waktu)->isSameDay($date);
                });

                $ketidakhadiran = $karyawan->ketidakhadiran->first(function ($item) use ($date) {
                    return Carbon::parse($item->tanggal_mulai)->lte($date)
                        && Carbon::parse($item->tanggal_berakhir)->gte($date);
                });

                if ($isWeekend) {
                    $row[$day] = ''; // Or 'W' or '-'
                } elseif ($absen) {
                    $row[$day] = 'H';
                    $hadir++;
                } elseif ($ketidakhadiran) {
                    if ($ketidakhadiran->jenis_ketidakhadiran === 'Cuti') {
                        $row[$day] = 'I';
                        $izin++;
                    } elseif ($ketidakhadiran->jenis_ketidakhadiran === 'Sakit') {
                        $row[$day] = 'S';
                        $sakit++;
                    } else {
                        $row[$day] = 'I';
                        $izin++;
                    }
                } else {
                    $row[$day] = 'A';
                    $mangkir++;
                }
            }

            $row['Izin'] = $izin;
            $row['Sakit'] = $sakit;
            $row['Mangkir'] = $mangkir;
            $row['Hadir'] = $hadir;
            $row['Persentase Kehadiran'] = round(($hadir / $totalDays) * 100, 2) . '%';

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        $headings = ['No', 'NIK', 'Nama'];
        $totalDays = Carbon::createFromDate((int) $this->year, (int) $this->month, 1)->daysInMonth;

        for ($i = 1; $i <= $totalDays; $i++) {
            $headings[] = $i;
        }

        return array_merge($headings, ['Izin', 'Sakit', 'Mangkir', 'Hadir', 'Persentase Kehadiran']);
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function (BeforeSheet $event) {
                $totalDays = Carbon::createFromDate($this->year, $this->month, 1)->daysInMonth;
                $columnCount = 3 + $totalDays + 5;
                $lastColumn = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnCount);

                $monthLabel = Carbon::createFromDate($this->year, $this->month, 1)->translatedFormat('F Y');
                $event->sheet->mergeCells("A1:{$lastColumn}1");
                $event->sheet->setCellValue("A1", $monthLabel);
                $event->sheet->getStyle("A1")->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle("A1")->getAlignment()->setHorizontal('center');
            },
        ];
    }

    public function title(): string
    {
        return Carbon::createFromDate($this->year, $this->month, 1)->format('F');
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
