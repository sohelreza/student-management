<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
// use App\StudentPayment;
// use App\StudentPaymentInstallment;
use DB;
use PDF;

class ReportController extends Controller
{
    public function expenseReport()
    {
        return view('admin.report.balanceReport');
    }

    public function expenseSearch(Request $request)
    {
        $request_start_date=$request->start_date;
        $request_end_date=$request->end_date;
        
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $period = CarbonPeriod::create($start_date, $end_date);

        // all date found from date range input
        $dateArray = $period->toArray();
        $total_days = count($dateArray);

        // creating an array for all data in the date range
        $data = [];

        // variable for hold all income and expense in this date range
        $all_income = 0;
        $all_expense = 0;

        // getting data for all date in the date range
        foreach ($dateArray as $singleDate) {
            
            // get date only from carbon date and formati in d-m-Y format
            $date = $singleDate->toDateString();
            $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');

            // create an array for putting all individual income from different batch
            $income_array = [];

            // create an array for putting all individual expense for different date
            $expense_array = [];

            // get offline income for a single date
            $offline_income = DB::table('student_payment_installments as i')
                                ->join('student_payments as p', 'p.id', '=', 'i.student_payment_id')
                                ->join('batches as b', 'b.id', '=', 'p.batch_id')
                                ->where('i.payment_date', $date)
                                ->get();

            // formatting offline income data
            if (count($offline_income) > 0) {
                
                // getting unique offline batch id
                $offline_batch = [];
                foreach ($offline_income as $oi) {
                    if (!in_array($oi->name, $offline_batch)) {
                        array_push($offline_batch, $oi->name);
                    }
                }
    
                // getting data from offline income for a unique batch
                foreach ($offline_batch as $ob) {
                    $income_array[$ob] = 0;
                    foreach ($offline_income as $fi) {
                        if ($ob === $fi->name) {
                            $income_array[$ob] += $fi->amount;
                        }
                    }
                }
            }

            // get online income for a single date
            $online_income = DB::table('student_payments as p')
                               ->join('batches as b', 'b.id', '=', 'p.batch_id')
                               ->where('p.student_type', '=', 1)
                               ->where('payment_date', $date)
                               ->orderBy('p.id', 'DESC')
                               ->get();

            // formatting offline income data
            if (count($online_income) > 0) {
                // getting unique online batch id
                $online_batch = [];
                foreach ($online_income as $ni) {
                    if (!in_array($ni->name, $online_batch)) {
                        array_push($online_batch, $ni->name);
                    }
                }

                // getting data from online income for a unique batch
                foreach ($online_batch as $nb) {
                    $income_array[$nb] = 0;
                    foreach ($online_income as $income) {
                        if ($nb === $income->name) {
                            $income_array[$nb] += $income->paid_amount;
                        }
                    }
                }
            }

            // calculating total income for a fixed date
            $total_income = 0;
            foreach ($income_array as $batch => $batch_income) {
                $total_income += $batch_income;
            }

            // get expense for a single date
            $expense = Expense::where('date', $date)
                              ->orderBy('id', 'DESC')
                              ->get();

            // formatting expense data
            if (count($expense) > 0) {
                // getting unique expense name
                $expense_name_list = [];
                foreach ($expense as $e) {
                    if (!in_array($e->name, $expense_name_list)) {
                        array_push($expense_name_list, $e->name);
                    }
                }

                // getting data from expense for a unique expense name
                foreach ($expense_name_list as $en) {
                    $expense_array[$en] = 0;
                    foreach ($expense as $ed) {
                        if ($en === $ed->name) {
                            $expense_array[$en] += $ed->amount;
                        }
                    }
                }
            }

            // calculating total expense for a fixed date
            $total_expense = 0;
            foreach ($expense_array as $item => $item_expense) {
                $total_expense += $item_expense;
            }

            // calculating net income for a fixed date
            $net_income = $total_income - $total_expense;

            $data[$formattedDate] = [
                "income" => $income_array,
                "expense" => $expense_array,
                'total_income' => $total_income,
                'total_expense' => $total_expense,
                'net_income' => $net_income,
            ];

            $all_income += $total_income;
            $all_expense += $total_expense;
        }
        
        // dd($data);

        // creating an array for summary of the all data
        $summary = [];
        $summary['total_days'] = $total_days;
        $summary['all_income'] = $all_income;
        $summary['all_expense'] = $all_expense;
        $summary['all_net_income'] = $all_income - $all_expense;

        

        // return $data;

        $pdf = PDF::loadView('admin.report.balancePdf', compact('data', 'start_date', 'end_date', 'summary'));
        return $pdf->stream('Balance.pdf');
    }
}
