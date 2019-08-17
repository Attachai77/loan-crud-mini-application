<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\LoanCollection;
use App\Loan;

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
}
