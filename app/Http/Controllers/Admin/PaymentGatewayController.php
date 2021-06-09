<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use Carbon\Carbon;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PaymentGateway::first();
        return view("backendViews.payments.gatewayConfig", compact('data'));
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
        $this->validate($request, [
            'client_id'=>'required|string'
        ]);


        $data = PaymentGateway::first();
        if ($data) {
            //update
            $updated = $data->update([
                'client_id'=>$request->client_id,
                'updated_at'=>Carbon::now()
            ]);

            if ($updated == true) {
                return redirect()->back()->with('success', "Data Update");
            }
            return redirect()->back()->with('error', "Internal Server Error | Please try again later.");
        }

        //else insert
        $insert = new PaymentGateway([
            'client_id'=>$request->client_id,
            'created_at'=>Carbon::now()
        ]);

        if ($insert->save()) {
            return redirect()->back()->with('success', "Gateway Key Set Successfully");
        }
        return redirect()->back()->with('error', "Internal Server Error | Please try again later.");
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
