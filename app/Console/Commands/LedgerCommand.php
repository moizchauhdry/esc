<?php

namespace App\Console\Commands;

use App\Models\Ledger;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LedgerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ledger-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dump('ledger-command running ...');
        Log::info("ledger command start");

        $month = Carbon::now()->subMonth()->format('m');
        $year = Carbon::now()->subMonth()->format('Y');

        $current_date = Carbon::create($year, $month, 1);

        $current_month = $current_date->format('m');
        $current_year = $current_date->format('Y');
        $next_month_start_date = $current_date->addMonth()->startOfMonth();

        // *********** LEDGER MANAGEMENT *******************

        $companies = User::role('company')->get();

        foreach ($companies as $key => $company) {

            $query = Ledger::query()->where('company_id', $company->id);

            $query->whereYear('ledger_at', $current_year);
            $query->whereMonth('ledger_at', $current_month);

            $ledgers = $query->orderBy('ledger_at', 'asc')->get();

            $debit_total = $ledgers->sum('debit_amount');
            $credit_total = $ledgers->sum('credit_amount');
            $balance_total = $ledgers->sum('debit_amount');

            $balance = [
                'debit_total' => $debit_total,
                'credit_total' => $credit_total,
                'balance_total' => $balance_total - $credit_total,
            ];

            Ledger::updateOrCreate(
                [
                    'company_id' => $company->id,
                    'ledger_at' => $next_month_start_date,
                    'amount_type' => 3,
                ],
                [
                    'company_id' => $company->id,
                    'ledger_at' => $next_month_start_date,
                    'debit_amount' => $balance['balance_total'],
                    'credit_amount' => 0,
                    'balance_amount' => $balance['balance_total'],
                    'comments' => 'SYSTEM GENERATED OPENING BALANCE at ' . Carbon::now()->format('d-m-Y h:i A'),
                    'amount_type' => 3, // OB
                ]
            );

            dump('Iteration ...' . $key);
        }

        Log::info("ledger command complete");
        dd('DONE');
    }
}
