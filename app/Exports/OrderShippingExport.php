<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;

class OrderShippingExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = collect($data); // Konversi data ke collection
    }

    public function collection()
    {
        return $this->data; // Kembalikan koleksi Laravel
    }

    public function headings(): array
    {
        return [
            ['ORDER SHIPPING'], // Judul besar di A1
            ['TeckD\'or Ameublements'], // Subjudul di A2
            [], // Baris kosong
            ['Code Shipping', 'Order ID', 'Product Name', 'Customer', 'Quantity', 'Date'] // Header tabel
        ];
    }

    public function map($shipping): array
    {
        return [
            $shipping->code_shipping ?? 'N/A',
            optional($shipping->order)->code_order ?? 'N/A',
            optional(optional($shipping->order)->product)->name_product ?? 'N/A',
            optional(optional($shipping->order)->user)->name ?? 'No Customer',
            $shipping->order->qty ?? 0,
            $shipping->created_at ? $shipping->created_at->format('d-m-Y H:i:s') : 'N/A',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Code Shipping
            'B' => 15, // Order ID
            'C' => 30, // Product Name
            'D' => 25, // Customer
            'E' => 10, // Quantity
            'F' => 20, // Date
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16], 'alignment' => ['horizontal' => 'center']], // Judul besar
            2 => ['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => 'center']], // Subjudul
            4 => ['font' => ['bold' => true, 'size' => 12], 'alignment' => ['horizontal' => 'center']], // Header tabel
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $this->data->count() + 4;

                // Gabungkan sel untuk judul
                $sheet->mergeCells('A1:F1');
                $sheet->mergeCells('A2:F2');

                // Atur tinggi baris judul
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(2)->setRowHeight(20);

                // Border tabel
                $sheet->getStyle("A4:F{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
                ]);

                // Atur teks header
                $sheet->getStyle("A4:F4")->applyFromArray([
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);
            },
        ];
    }
}
