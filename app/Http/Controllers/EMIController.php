<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\EMIServiceInterface;
use App\Models\LoanDetails;
use Illuminate\Support\Facades\DB;
class EMIController extends Controller
{
     protected $emiService;

     public function __construct(EMIServiceInterface $emiService){
        $this->emiService = $emiService;
    }

    public function showLoanDetails(){
        $loanDetails = $this->emiService->all();
       // $loanDetails = LoanDetails::all();
        return view('loan_details', compact('loanDetails'));
    }

    public function processEMIData(Request $request){
        // $this->emiService->processEMIData();
        // return redirect()->route('emi_details');
        $this->emiService->processEMIData();

       return response()->json(['success' => true, 'redirect_url' => route('emi-data')]);
        //return redirect()->route('emi-data');
    }

    public function showEMIPage(){
        $emiDetails = DB::table('emi_details')->get();
        return view('emi_page', compact('emiDetails'));
    }
}
