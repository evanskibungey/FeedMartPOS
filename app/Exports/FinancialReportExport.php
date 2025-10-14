<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class FinancialReportExport implements WithMultipleSheets
{
    protected $summary;
    protected $dailyRevenue;
    protected $fromDate;
    protected $toDate;

    public function __construct($summary, $dailyRevenue, $fromDate, $toDate)
    {
        $this->summary = $summary;
        $this->dailyRevenue = $dailyRevenue;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function sheets(): array
    {
        return [
            new FinancialSummarySheet($this->summary, $this->fromDate, $this->toDate),
            new DailyRevenueSheet($this->dailyRevenue),
        ];
    }
}

class FinancialSummarySheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $summary;
    protected $fromDate;
    protected $toDate;

    public function __construct($summary, $fromDate, $toDate)
    {
        $this->summary = $summary;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        return collect([
            ['Period', \Carbon\Carbon::parse($this->fromDate)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($this->toDate)->format('M d, Y')],
            ['', ''],
            ['REVENUE', ''],
            ['POS Sales', number_format($this->summary['posRevenue'], 2)],
            ['Customer Orders', number_format($this->summary['orderRevenue'], 2)],
            ['Total Revenue', number_format($this->summary['totalRevenue'], 2)],
            ['', ''],
            ['COST OF GOODS SOLD', number_format($this->summary['totalCOGS'], 2)],
            ['', ''],
            ['GROSS PROFIT', number_format($this->summary['grossProfit'], 2)],
            ['Gross Profit Margin', number_format($this->summary['grossProfitMargin'], 2) . '%'],
            ['', ''],
            ['TAX COLLECTED', number_format($this->summary['totalTax'], 2)],
        ]);
    }

    public function headings(): array
    {
        return ['Description', 'Amount (KES)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '10B981']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            3 => ['font' => ['bold' => true]],
            8 => ['font' => ['bold' => true]],
            10 => ['font' => ['bold' => true]],
            13 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Financial Summary';
    }
}

class DailyRevenueSheet implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $dailyRevenue;

    public function __construct($dailyRevenue)
    {
        $this->dailyRevenue = $dailyRevenue;
    }

    public function collection()
    {
        return collect($this->dailyRevenue)->map(function($day) {
            return [
                'date' => $day['date'],
                'revenue' => number_format($day['amount'], 2),
            ];
        });
    }

    public function headings(): array
    {
        return ['Date', 'Revenue (KES)'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '10B981']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Daily Revenue';
    }
}
