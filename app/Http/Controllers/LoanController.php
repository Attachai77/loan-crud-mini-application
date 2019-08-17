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
      $loan = Loan::find($id);
      $input = $request->all();
      $input['start_date'] = $input['start_year'].'-'.$input['start_month'].'-01';

      $loan->update($input);

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
      $PMI = $loan_amount * ($r/12) / 1 -  (1 + ($r/12)) ^ (-12 * $loan_term );

      $loan_term_months = $loan_term * 12;
      for ($i=1; $i <= $loan_term_months; $i++) { 

        $interest = ($r/12) * $loan_amount;
        $principal = $PMI - $interest;
        $balance = $loan_amount - $principal;
        
        $repaymentSchedule = new RepaymentSchedule([
          'loan_id' => $loan_id,
          'date' =>$date,
          'payment_amount' => $PMI,
          'principal' => $principal,
          'interest' => $interest,
          'balance' => $balance
        ]);

        $repaymentSchedule->save();

        $date = date("Y-m-d", strtotime("+1 month", strtotime($date) ));
      }

      return true;
    }

    public function getPaymentSchedule($id)
    {
      #$paymentSchedule = RepaymentSchedule::where('loan_id',$id)->get();
      // $paymentSchedule = RepaymentSchedule::all();
      return new LoanCollection(RepaymentSchedule::all());
      // return response()->json($paymentSchedule);
      // return $paymentSchedule;
    }

}
