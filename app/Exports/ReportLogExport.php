<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class ReportLogExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    protected $reportLog;
    protected $start_date;
    protected $end_date;

    public function __construct($reportLog, $start_date, $end_date)
    {
        $this->reportLog = $reportLog;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return $this->reportLog;
    }

    public function headings(): array
    {
        return [
            ["REPORT ORDER {$this->start_date} - {$this->end_date}"],
            ['TeckD\'or Ameublements'],
            [],
            ['Tgl. Order', 'Code Order', 'Code Product', 'Category', 'Product Name', 'Supplier', 'Length', 'Width', 'Height', 'Customer', 'Quantity', 'Unit Price', 'Total Payment', 'Transaction', 'Status Payment', 'Finishing', 'Progress']
        ];
    }

    public function map($order): array
    {
        return [
            $order->created_at ?? 'N/A',
            $order->code_order ?? 'N/A',
            optional($order->product)->code_product ?? 'N/A',
            optional($order->product->category)->name_category ?? 'No Category',
            optional($order->product)->name_product ?? 'No Product',
            optional($order->product->supplier)->name_supplier ?? 'No Supplier',
            optional($order->product)->length ?? 'N/A',
            optional($order->product)->width ?? 'N/A',
            optional($order->product)->height ?? 'N/A',
            optional($order->user)->name ?? 'No Customer',
            $order->qty ?? 0,
            number_format($order->total_payment, 2) ?? '0.00',
            number_format($order->qty * $order->total_payment, 2) ?? '0.00',
            number_format($order->finance()->sum('total_payment'), 2) ?? '0.00',
            $order->payment_status ?? 'Unpaid',
            optional($order->orderProgress()->latest()->first())->finishing ?? 'N/A',
            optional($order->orderProgress()->latest()->first())->name_progress ?? 'N/A'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Code Order
            'B' => 20, // Code Produk
            'C' => 20, // Category
            'D' => 30, // Product Name
            'E' => 25, // Customer
            'F' => 10, // Quantity
            'G' => 15, // Unit Price
            'H' => 20, // Total Payment
            'I' => 15, // Status Payment
            'J' => 15, // Finishing
            'K' => 15, // Progress
            'L' => 15, // Progress
            'M' => 15, // Progress
            'N' => 15, // Progress
            'O' => 15, // Progress
            'P' => 15, // Progress
            'Q' => 15, // Progress
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => 'center']],
            2 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']],
            4 => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => 'center']],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $this->reportLog->count() + 4;

                // Gabungkan sel untuk judul
                $sheet->mergeCells('A1:Q1');
                $sheet->mergeCells('A2:Q2');

                // Atur tinggi baris judul
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Border tabel
                $sheet->getStyle("A4:Q{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                ]);

                // Atur teks header
                $sheet->getStyle("A4:P4")->applyFromArray([
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);
            },
        ];
    }
}
