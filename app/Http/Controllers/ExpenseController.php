<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('m');
        $year = $request->year ?? Carbon::now()->format('Y');

        $query = Expense::query();

        $query->whereYear('expense_at', $year);
        $query->whereMonth('expense_at', $month);

        $expenses = $query->orderBy('id', 'desc')->paginate(25);

        return Inertia::render('Expense/Index', [
            'expenses' => $expenses,
            'filter' => [
                'year' => $year,
                'month' => $month,
                'month_name' => getMonthName($month),
            ]
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->items as $key => $item) {
            $month_name = Carbon::create()->month($item['month'])->format('F');
            Expense::create([
                'year' => $item['year'],
                'month' => $item['month'],
                'month_name' => $month_name,
                'description' => $item['description'],
                'amount' => $item['amount'],
                'expense_at' => Carbon::create($item['year'], $item['month']),
            ]);
        }

        return redirect()->route('expense.index')->with('success', 'Expense Added.');
    }

    public function update(Request $request)
    {
        dd('s');
        // $this->save($request, true);
        return redirect()->back()->with('success', 'Record updated.');
    }
}
