<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class InventoryReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function collection()
    {
        return $this->products;
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Product Name',
            'Category',
            'Brand',
            'Stock Quantity',
            'Reorder Level',
            'Cost Price',
            'Selling Price',
            'Inventory Value',
            'Status',
        ];
    }

    public function map($product): array
    {
        $status = 'Good';
        if ($product->quantity_in_stock == 0) {
            $status = 'Out of Stock';
        } elseif ($product->quantity_in_stock <= $product->reorder_level) {
            $status = 'Low Stock';
        } elseif ($product->quantity_in_stock > ($product->reorder_level * 3)) {
            $status = 'Overstocked';
        }

        return [
            $product->sku,
            $product->name,
            $product->category->name ?? 'N/A',
            $product->brand->name ?? 'N/A',
            $product->quantity_in_stock,
            $product->reorder_level,
            number_format($product->cost_price, 2),
            number_format($product->selling_price, 2),
            number_format($product->quantity_in_stock * $product->cost_price, 2),
            $status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3B82F6']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Inventory Report';
    }
}
