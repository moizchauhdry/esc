<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $from_date = !empty($request->from_date) ? Carbon::parse($request->from_date)->format('Y-m-d') : Carbon::now()->startOfMonth()->format('Y-m-d');
        $to_date = !empty($request->to_date) ? Carbon::parse($request->to_date)->format('Y-m-d') : Carbon::now()->endOfMonth()->format('Y-m-d');

        $query = Expense::with(['expenseItems']);

        $query->whereDate('expense_at', '>=', $from_date);
        $query->whereDate('expense_at', '<=', $to_date);

        // dd($query->get());

        $expenses = $query->orderBy('expense_at', 'desc')->paginate(25)->withQueryString();

        return Inertia::render('Expense/Index', [
            'expenses' => $expenses,
            'filter' => [
                'from_date' => $from_date,
                'to_date' => $to_date,
            ]
        ]);
    }

    private function save($request)
    {
        $rules = [
            'expense_at' => 'required|date_format:Y-m-d',
        ];

        $messages = [
            'required' => 'The field is required.',
        ];

        $request->validate($rules, $messages);

        $expense_at = Carbon::parse($request->expense_at)->format('Y-m-d');
        $year = Carbon::parse($expense_at)->format('Y');
        $month = Carbon::parse($expense_at)->format('m');
        $month_name = Carbon::parse($expense_at)->format('F');

        $expense_data = [
            'year' => $year,
            'month' => $month,
            'month_name' => $month_name,
            'expense_at' => $expense_at,
        ];

        $expense = Expense::find($request->expense_id);

        if ($expense) {
            $expense->update($expense_data);
            $expense_items = ExpenseItem::where('expense_id', $expense->id)->delete();
        } else {
            $expense = Expense::create($expense_data);
        }

        foreach ($request->items as $key => $item) {
            ExpenseItem::create([
                'expense_id' => $expense->id,
                'year' => $year,
                'month' => $month,
                'month_name' => $month_name,
                'expense_at' => $expense_at,
                'description' => $item['description'],
                'amount' => $item['amount'],
            ]);
        }

        $expense_items = ExpenseItem::where('expense_id', $expense->id)->get();

        $expense->update([
            'total_amount' => $expense_items->sum('amount'),
            'items_count' => $expense_items->count()
        ]);
    }

    public function store(Request $request)
    {
        $this->save($request);
        return redirect()->route('expense.index')->with('success', 'Expense Added.');
    }

    public function update(Request $request)
    {
        $this->save($request);
        return redirect()->back()->with('success', 'Record updated.');
    }

    public function delete(Request $request)
    {
        ExpenseItem::where('expense_id', $request->expense_id)->delete();
        Expense::find($request->expense_id)->delete();

        return Redirect::back()->with('success', 'Ledger deleted.');
    }

    public function fetchExpenseItems($id)
    {
        $expense = Expense::find($id);
        $expense_items = ExpenseItem::where('expense_id', $id)->get();

        $data = [
            'expense' => $expense,
            'expense_items' => $expense_items,
        ];

        return response()->json($data);
    }
}
