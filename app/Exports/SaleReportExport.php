<?php

namespace App\Exports;

use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;

class SaleReportExport implements FromView
{
    protected $filter;

    public function __construct(array $filter)
    {
        $this->filter = $filter;
    }


    public function view(): View
    {
        $query = Invoice::select('*');
        $query->selectRaw('(total - net_payable) as net_total');

        $query->when($this->filter['from'] && $this->filter['to'], function ($q) {
            $q->whereDate('invoice_at', '>=', $this->filter['from']);
            $q->whereDate('invoice_at', '<=', $this->filter['to']);
        });

        $query->when($this->filter['carrier_id'], function ($q) {
            $q->where('carrier_id', $this->filter['carrier_id']);
        });

        $query->when($this->filter['company_id'], function ($q) {
            $q->where('company_id', $this->filter['company_id']);
        });

        $grand_total = [
            'invoice_amount_sum' => $query->sum('total'),
            'due_carrier_sum' => $query->sum('due_carrier'),
            'net_rate_sum' => $query->sum('net_rate'),
            'net_payable_sum' => $query->sum('net_payable'),
            'gross_profit_sum' => $query->sum('total') - $query->sum('net_payable'),
            'expense_sum' => 0,
            'net_profit_sum' => $query->sum('total') - $query->sum('net_payable'),
        ];

        return view('exports.sales-report-export-v2', [
            'invoices' => $query->get(),
            'filter' => $this->filter,
            'grand_total' => $grand_total,
        ]); 
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                // Repeat for other columns as needed
            },
        ];
    }
}
