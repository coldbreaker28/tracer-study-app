<?php

namespace App\Exports;

use App\Models\Alumni;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class AlumniExport implements FromCollection, WithHeadings, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public function boot()
    {
        Carbon::useClassName(\Carbon\CarbonImmutable::class);
    }
    public function collection()
    {
        $alumni = Siswa::with(['karirs', 'jurusans'])->get();

        $exportData = $alumni->map(function ($item) {
            $tanggalLulus  = $item->tanggal_lulus;
            if($tanggalLulus && Carbon::parse($tanggalLulus)->isValid()){
                $formattedTanggalLulus = Carbon::parse($tanggalLulus)->format('Y');
            }else{
                $formattedTanggalLulus = '';
            }
            return [
                $item -> id,
                $item -> jurusans -> kompetensi_keahlian,
                $item -> name,
                $item -> nis,
                $item -> nisn,
                $item -> tanggal_lahir,
                $item -> alamat,
                $item -> nama_orang_tua,
                $formattedTanggalLulus,
                $item -> karirs -> profesi,
                $item -> karirs -> bidang,
                $item -> karirs -> jenis_karir,
                $item -> karirs -> nama_tempat,
                $item -> karirs -> alamat_karir,
                $item -> karirs -> pendapatan,
            ];
        });

        return $exportData;
    }
    public function headings(): array
    {
        return [
            '#',
            'Kompetensi Keahlian',
            'Nama Lengkap',
            'NISN',
            'NIS',
            'Tanggal Lahir',
            'Alamat',
            'Orang Tua / Wali',
            'Tahun Lulus',
            'Profesi',
            'Bidang Profesi',
            'Jenis Profesi',
            'Tempat Profesi',
            'Alamat Karir',
            'Pendapatan',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
                $event->sheet->getDelegate()->getStyle('A1:N1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('A1:N1')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('FFFF00');
                $event->sheet->getDelegate()->getStyle('A1:N1' . ($event->sheet->getDelegate()->getHighestRow()))
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A2:N' . ($event->sheet->getDelegate()->getHighestRow()))
                    ->getAlignment()
                    ->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A2:N' . ($event->sheet->getDelegate()->getHighestRow()))
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                foreach(range('A', 'N') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}