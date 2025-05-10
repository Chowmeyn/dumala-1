<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Illuminate\Support\Collection;

class PriestReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return collect($this->reports)
            ->sortByDesc(function ($item) {
                return $item->date . ' ' . $item->time_from;
            })
            ->map(function ($item) {
                return [
                    'priest_name' => $item->assign_to_name ?? 'N/A',
                    'requester_name' => $item->created_by_name ?? 'N/A',
                    'purpose' => $item->purpose ?? 'N/A',
                    'date' => $item->date ?? 'N/A',
                    'time' => ($item->time_from && $item->time_to) ? $item->time_from . ' - ' . $item->time_to : 'N/A',
                    'venue' => $item->venue ?? 'N/A',
                    'address' => $item->address ?? 'N/A',
                    'status' => $this->getStatusText($item->status)
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Priest Name',
            'Requester Name',
            'Purpose',
            'Date',
            'Time',
            'Venue',
            'Address',
            'Status'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set default font
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(12);

        // Get the last row number
        $lastRow = $sheet->getHighestRow();

        // Style for headers - green background and bold text
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'name' => 'Arial',
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '28A745']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Add borders to all populated cells
        $sheet->getStyle('A1:H' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Set row height for all rows including header
        for ($i = 1; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(20);
        }

        // Set column widths (in characters)
        $sheet->getColumnDimension('A')->setWidth(25); // Priest Name
        $sheet->getColumnDimension('B')->setWidth(25); // Requester Name
        $sheet->getColumnDimension('C')->setWidth(20); // Purpose
        $sheet->getColumnDimension('D')->setWidth(15); // Date
        $sheet->getColumnDimension('E')->setWidth(20); // Time
        $sheet->getColumnDimension('F')->setWidth(25); // Venue
        $sheet->getColumnDimension('G')->setWidth(30); // Address
        $sheet->getColumnDimension('H')->setWidth(15); // Status

        return [
            1 => ['font' => ['bold' => true],
            'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center'
                ]
            ]
        ];
    }

    private function getStatusText($status)
    {
        switch ($status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Accepted';
            case 3:
                return 'Declined';
            case 4:
                return 'Completed';
            case 5:
                return 'Archived';
            default:
                return 'Accepted by priest';
        }
    }
}