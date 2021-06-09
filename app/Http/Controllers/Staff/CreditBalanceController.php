<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffCredit;
use App\Models\Payment;
use Carbon\Carbon;
use Auth;

class CreditBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //topup balance
        $payment = new Payment([
            "paid_for"=>"CREDIT",
            "user_id"=>Auth::user()->id,
            "payment_method"=>"Paypal",
            "paid_amount"=>$request->p_paid_amount,
            "payer_name"=>$request->p_payer_name,
            "payer_email"=>$request->p_payer_email,
            "paypal_transaction_id"=>$request->p_transaction_id,
            "payer_country"=>$request->p_payer_country,
            "status"=>$request->p_status,
            "created_at"=>Carbon::now()
        ]);
        if (!$payment->save()) {
            return redirect("/staff/account?data=credit&type=balance")->with("error", "Internal error | payment data not saved, please contact administration for further help.");
        }

        $credit = StaffCredit::where("user_id", Auth::user()->id)->first();
        if ($credit) {
            //update
            $credit->update([
                "total_balance"=>($credit->total_balance + $request->p_paid_amount),
                "remaining_balance"=>($credit->remaining_balance + $request->p_paid_amount),
                "updated_at"=>Carbon::now()
            ]);
            return redirect("/staff/account?data=credit&type=balance")->with("success", "Credit Topup Success");
        }
        //insert
        $newCredit = new StaffCredit([
            "user_id"=>Auth::user()->id,
            "total_balance"=>$request->p_paid_amount,
            "remaining_balance"=>$request->p_paid_amount,
            "created_at"=>Carbon::now()
        ]);
        $newCredit->save();

        return redirect("/staff/account?data=credit&type=balance")->with("success", "Credit Topup Success");
    }

    public function testCreditBalance($amount){
        //topup balance
        $payment = new Payment([
            "paid_for"=>"CREDIT",
            "user_id"=>Auth::user()->id,
            "payment_method"=>"Paypal",
            "paid_amount"=>$amount,
            "payer_name"=>"Test",
            "payer_email"=>"test@credit.com",
            "paypal_transaction_id"=>"test-credit-trn-id".mt_rand(999, 9999),
            "payer_country"=>"USA",
            "status"=>"COMPLETED",
            "created_at"=>Carbon::now()
        ]);
        if (!$payment->save()) {
            return redirect("/staff/account?data=credit&type=balance")->with("error", "Internal error | payment data not saved, please contact administration for further help.");
        }

        $credit = StaffCredit::where("user_id", Auth::user()->id)->first();
        if ($credit) {
            //update
            $credit->update([
                "total_balance"=>($credit->total_balance + $amount),
                "remaining_balance"=>($credit->remaining_balance + $amount),
                "updated_at"=>Carbon::now()
            ]);
            return redirect("/staff/account?data=credit&type=balance")->with("success", "Credit Topup Success");
        }
        //insert
        $newCredit = new StaffCredit([
            "user_id"=>Auth::user()->id,
            "total_balance"=>$amount,
            "remaining_balance"=>$amount,
            "created_at"=>Carbon::now()
        ]);
        $newCredit->save();

        return redirect("/staff/account?data=credit&type=balance")->with("success", "Credit Topup Success");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
