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
        $query = Invoice::query();

        if (!empty($this->filter['carrier_id'])) {
            $query->where('carrier_id', $this->filter['carrier_id']);
        }

        if (!empty($this->filter['from'])) {
            $query->whereDate('invoice_at', '>=', $this->filter['from']);
        }

        if (!empty($this->filter['to'])) {
            $query->whereDate('invoice_at', '<=', $this->filter['to']);
        }

        return view('exports.sale-report-export', [
            'invoices' => $query->get(),
            'filter' =>$this->filter,
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
