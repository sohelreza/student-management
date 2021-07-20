<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\ExpenseHead;
use App\Expense;
use Auth;
use PDF;
use Illuminate\Support\Carbon;
use App\Branch;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses=Expense::all();
        return view('admin.expense.expenseList', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches=Branch::all();
        $expense_heads=ExpenseHead::all();
        return view('admin.expense.addExpense', compact('expense_heads','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            
            'name' => 'required',
            'branch_id'=>'required',
            'date' => 'required|date',
            'amount' => 'required'
            
        ]);

        $admin=Auth::guard('admin')->user();

        $expense=new Expense;

        $expense->expense_head_id=$admin->id;
        $expense->branch_id=$request->branch_id;
        $expense->name=$request->name;
        $expense->date=$request->date;
        $expense->amount=$request->amount;
        $expense->save();

        $request->session()->flash('success', 'Expense Added Successfully');
        return redirect('admin/expenses/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branches=Branch::all();
        $expense=Expense::find($id);
        $expense_heads=ExpenseHead::all();
        return view('admin.expense.editExpense', compact('expense', 'expense_heads','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            
            // 'expense_head_id' => 'required',
            'name' => 'required',
            'branch_id'=>'required',
            'date' => 'required|date',
            'amount' => 'required'
            
        ]);

        $expense=Expense::find($id);

        $expense->branch_id=$request->branch_id;
        $expense->name=$request->name;
        $expense->date=$request->date;
        $expense->amount=$request->amount;
        $expense->save();

        $request->session()->flash('success', 'Expense Updated Successfully');
        return redirect('admin/expenses/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense=Expense::find($id);
        $expense->delete();
        Session::flash('success', 'Expense Deleted Successfully');
        return redirect('admin/expenses/');
    }

    public function expensePdf()
    {
        $expenses=Expense::all();

        $total_expense=0;
        foreach ($expenses as $expense) {
            
            $total_expense=$total_expense+$expense->amount;

        }


        

        $pdf = PDF::loadView('admin.expense.expensePdf', compact('expenses','total_expense'));
        return $pdf->stream('Expense.pdf');
    }

    public function expenseSearch(Request $request)
    {
        $request_start_date=$request->start_date;
        $request_end_date=$request->end_date;
        
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $expenses= Expense::whereBetween('date', [$start_date,$end_date])
                    ->orderBy('id', 'DESC')
                    ->get() ;


        return view('admin.expense.expenseSearch', compact('expenses', 'request_start_date', 'request_end_date'));
    }

    public function expensePdfSearch(Request $request)
    {
        $start_date = Carbon::parse($request->request_start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->request_end_date)->format('Y-m-d');

        // return $request->all();

        $expenses= Expense::whereBetween('date', [$start_date,$end_date])
                    ->orderBy('id', 'DESC')
                    ->get() ;

        $total_expense=0;
        foreach ($expenses as $expense) {
            
            $total_expense=$total_expense+$expense->amount;

        }            
        

        $pdf = PDF::loadView('admin.expense.expensePdf', compact('expenses','start_date','end_date','total_expense'));
        return $pdf->stream('Expense.pdf');
    }
}
