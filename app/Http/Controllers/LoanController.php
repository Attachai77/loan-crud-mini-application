<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LoanCollection;
use App\Loan;
use App\RepaymentSchedule;

class LoanController extends Controller
{
    public function store(Request $request)
    {

        $loan = new Loan([
            'loan_amount' => $request->get('loan_amount'),
            'loan_term' => $request->get('loan_term'),
            'interest_rate' => $request->get('interest_rate'),
            'start_date' => $request->get('start_year').'-'.$request->get('start_month').'-01'
        ]);
        
        $request->request->set('start_date', $request->get('start_year').'-'.$request->get('start_month').'-01');

        $validatedData = $request->validate([
            'loan_amount' => 'required|integer|min:1000|max:100000000',
            'loan_term' => 'required|integer|min:1|max:50',
            'interest_rate' => 'required|integer|min:1|max:36',
            'start_date' => 'required',
        ]);

        $loan->save();
        $loan_id = $loan->id;

        $genaratePS = $this->genaratePaymentSchedule($request->all() , $loan_id);

        return response()->json('successfully added');
    }

    public function index()
    {
        return new LoanCollection(Loan::all());
    }

    public function edit($id)
    {
        $loan = Loan::find($id);

        $start_date = strtotime($loan->start_date);
        $loan->start_month = date('m',$start_date);
        $loan->start_year = date('Y',$start_date);
        return response()->json($loan);
    }

    public function update($id, Request $request)
    {
        $request->request->set('start_date', $request->get('start_year').'-'.$request->get('start_month').'-01');
        $validatedData = $request->validate([
            'loan_amount' => 'required|integer|min:1000|max:100000000',
            'loan_term' => 'required|integer|min:1|max:50',
            'interest_rate' => 'required|integer|min:1|max:36',
            'start_date' => 'required',
        ]);

        $loan = Loan::find($id);
        $input = $request->all();
        $input['start_date'] = $input['start_year'].'-'.$input['start_month'].'-01';

        $loan->update($input);

        RepaymentSchedule::where('loan_id', $id)->delete();

        $genaratePS = $this->genaratePaymentSchedule($input , $id);

        return response()->json('successfully updated');
    }

    public function view($id)
    {
        $loan = Loan::find($id);
        return response()->json($loan);
    }

    public function delete($id)
    {
        $loan = Loan::find($id);

        $loan->delete();

        return response()->json('successfully deleted');
    }

    public function genaratePaymentSchedule($loan = NULL , $loan_id = NULL){
        $interest_rate = $loan['interest_rate'];
        $loan_amount = $loan['loan_amount'];
        $loan_term = $loan['loan_term'];
        $start_month = $loan['start_month'];
        $start_year = $loan['start_year'];
        $date = $start_year.'-'.$start_month.'-01';
        $date = date("Y-m-d", strtotime("+1 month", strtotime($date) ));

        $r = $interest_rate/100;
        $PMT = $this->calPMT($interest_rate , $loan_term , $loan_amount);
        $prev_balance = $loan_amount;

        $loan_term_months = $loan_term * 12;
        for ($i=1; $i <= $loan_term_months; $i++) { 

            $interest = ($r/12) * $prev_balance;
            // $interest = number_format((float)$interest, 2, '.', '');

            $principal = $PMT - $interest;
            // $principal = number_format((float)$principal, 2, '.', '');

            $balance = $prev_balance - $principal;
            // $balance = number_format((float)$balance, 2, '.', '');
            
            $repaymentSchedule = new RepaymentSchedule([
            'loan_id' => $loan_id,
            'date' =>$date,
            'payment_amount' => $PMT,
            'principal' => $principal,
            'interest' => $interest,
            'balance' => $balance
            ]);

            $repaymentSchedule->save();

            $prev_balance = $balance;
            $date = date("Y-m-d", strtotime("+1 month", strtotime($date) ));
        }

        return true;
    }

    #param float $apr   Interest rate.
    #param integer $term  Loan length in years. 
    #param float $loan   The loan amount.
    public function calPMT($apr, $term, $loan)
    {
        $term = $term * 12;
        $apr = $apr / 1200;
        $amount = $apr * -$loan * pow((1 + $apr), $term) / (1 - pow((1 + $apr), $term));
        return $amount;
    }

    public function getPaymentSchedule($id)
    {
        return new LoanCollection(RepaymentSchedule::where('loan_id', $id)->get());
    }

}
