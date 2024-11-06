<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseItem;
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
        $expense = Expense::create([
            'year' => $request->year,
            'month' => $request->month,
            'month_name' => getMonthName($request->month),
            'expense_at' => Carbon::create($request->year, $request->month),
        ]);

        foreach ($request->items as $key => $item) {
            ExpenseItem::create([
                'expense_id' => $expense->id,
                'year' => $request->year,
                'month' => $request->month,
                'month_name' => getMonthName($request->month),
                'description' => $item['description'],
                'amount' => $item['amount'],
                'expense_at' => Carbon::create($request->year, $request->month),
            ]);
        }

        $expense_items = ExpenseItem::where('expense_id', $expense->id)->get();

        $expense->update([
            'total_amount' => $expense_items->sum('amount'),
            'items_count' => $expense_items->count()
        ]);

        return redirect()->route('expense.index')->with('success', 'Expense Added.');
    }

    public function update(Request $request)
    {
        dd('update');
        // $this->save($request, true);
        return redirect()->back()->with('success', 'Record updated.');
    }
}
