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
}
