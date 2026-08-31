<?php

namespace App\Exports;

use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\Pengaturan;
use Carbon\Carbon;

class LogActivityExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell
{

    public function collection()
    {
        return Activity::with('causer')->latest()->get();
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return [
            'NO',
            'PENGGUNA',
            'AKSI / AKTIVITAS',
            'MODUL / OBJEK DATA',
            'WAKTU KEJADIAN',
        ];
    }


    public function map($log): array
    {
        static $no = 1;


        $description = match($log->description) {
            'created' => 'TAMBAH DATA',
            'updated' => 'UBAH DATA',
            'deleted' => 'HAPUS DATA',
            'login'   => 'LOGIN SISTEM',
            default   => strtoupper($log->description)
        };

        return [
            $no++,
            $log->causer->name ?? 'Sistem',
            $description,
            class_basename($log->subject_type) . ' (ID: ' . ($log->subject_id ?? '-') . ')',
            $log->created_at->format('d/m/Y H:i:s'),
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [

            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E3A8A'] // Navy Blue
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $pengaturan = Pengaturan::first();
                $namaAplikasi = strtoupper($pengaturan->nama_aplikasi ?? 'SISTEM MONITORING KERJASAMA');
                $tanggalCetak = 'Tanggal Cetak: ' . Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB';

                $sheet = $event->sheet;

                // --- BARIS 1: JUDUL APLIKASI ---
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', $namaAplikasi);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
                ]);

                // --- BARIS 2: TANGGAL CETAK ---
                $sheet->mergeCells('A2:E2');
                $sheet->setCellValue('A2', $tanggalCetak);
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 11, 'color' => ['rgb' => '4B5563']],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
                ]);

                // --- STYLING DATA (Borders & Alignment) ---
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A4:E' . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'D1D5DB'],
                        ],
                    ],
                ]);

                // Center alignment untuk No dan Waktu
                $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E5:E' . $highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
