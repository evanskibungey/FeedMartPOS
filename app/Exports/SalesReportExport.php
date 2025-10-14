<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $posSales;
    protected $customerOrders;
    protected $summary;

    public function __construct($posSales, $customerOrders, $summary)
    {
        $this->posSales = $posSales;
        $this->customerOrders = $customerOrders;
        $this->summary = $summary;
    }

    public function collection()
    {
        // Combine POS sales and customer orders
        $data = collect();

        // Add POS Sales
        foreach ($this->posSales as $sale) {
            $data->push([
                'type' => 'POS Sale',
                'reference' => $sale->receipt_number,
                'date' => $sale->sale_date,
                'customer' => 'Walk-in',
                'cashier' => $sale->user->name ?? 'N/A',
                'items' => $sale->saleItems->count(),
                'quantity' => $sale->saleItems->sum('quantity'),
                'subtotal' => $sale->subtotal,
                'tax' => $sale->tax_amount,
                'discount' => $sale->discount_amount,
                'total' => $sale->total_amount,
                'payment_method' => ucfirst($sale->payment_method),
                'status' => 'Completed',
            ]);
        }

        // Add Customer Orders
        foreach ($this->customerOrders as $order) {
            $data->push([
                'type' => 'Customer Order',
                'reference' => $order->order_number,
                'date' => $order->created_at,
                'customer' => $order->customer_name ?? 'N/A',
                'cashier' => $order->user->name ?? 'N/A',
                'items' => $order->orderItems->count(),
                'quantity' => $order->orderItems->sum('quantity'),
                'subtotal' => $order->subtotal,
                'tax' => $order->tax,
                'discount' => $order->discount,
                'total' => $order->total_amount,
                'payment_method' => ucfirst($order->payment_method ?? 'N/A'),
                'status' => ucfirst($order->status),
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Type',
            'Reference',
            'Date',
            'Customer',
            'Cashier',
            'Items',
            'Quantity',
            'Subtotal',
            'Tax',
            'Discount',
            'Total',
            'Payment Method',
            'Status',
        ];
    }

    public function map($row): array
    {
        return [
            $row['type'],
            $row['reference'],
            \Carbon\Carbon::parse($row['date'])->format('Y-m-d H:i'),
            $row['customer'],
            $row['cashier'],
            $row['items'],
            $row['quantity'],
            number_format($row['subtotal'], 2),
            number_format($row['tax'], 2),
            number_format($row['discount'], 2),
            number_format($row['total'], 2),
            $row['payment_method'],
            $row['status'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F59E0B']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Sales Report';
    }
}
