<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExpenseHead;
use Session;

class ExpenseHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expense_heads=ExpenseHead::all();
        return view('admin.expenseHead.expenseHeadList',compact('expense_heads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.expenseHead.addExpenseHead');
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
        ]);

        ExpenseHead::create($request->all());
        $request->session()->flash('success', 'Expense Head Added Successfully');
        return redirect('admin/expense_heads/');
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
        $expense_head=ExpenseHead::find($id);
        return view('admin.expenseHead.editExpenseHead',compact('expense_head'));
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
            'name' => 'required',
        ]);

        $expense_head=ExpenseHead::find($id);
        $expense_head->name=$request->name;
        $expense_head->save();
        
        $request->session()->flash('success', 'Expense Head Updated Successfully');
        return redirect('admin/expense_heads/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense_head=ExpenseHead::find($id);
        $expense_head->delete();
        Session::flash('success', 'Expense Head Deleted Successfully');
        return redirect('admin/expense_heads/');
    }
}
