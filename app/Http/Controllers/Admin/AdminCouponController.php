<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
use Carbon\Carbon;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Coupon::orderBy("created_at", "DESC")->get();
        return view("backendViews.coupons.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where([
            "status"=>"Active"
        ])
        ->orderBy("created_at", 'DESC')
        ->get();
        return view("backendViews.coupons.create", compact('products'));
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
            "coupon_code"=>"required|string|max:99|unique:coupons,coupon_code",
            "coupon_discount"=>"required",
            "number_of_coupon"=>"nullable|numeric",
            "expire_date"=>"required|date"
        ]);

        //validate expire date
        $today = date("Y-m-d");
        $expireDate = date("Y-m-d", strtotime($request->expire_date));

        if ($expireDate <= $today) {
            return redirect()->back()->with('error', "Expire date can't be equal or less of today!")->withInput();
        }


        $coupon = new Coupon([
            "coupon_code"=>$request->coupon_code,
            "coupon_discount"=>$request->coupon_discount,
            "expire_date"=>$expireDate,
            "number_of_coupon"=>$request->number_of_coupon,
            "created_at"=>Carbon::now()
        ]);

        if ($coupon->save()) {
            return redirect()->back()->with('success', "Coupon Created");
        }

        return redirect()->back()->with('error', "SORRY - Internal server error | Please try again later.");

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
        $data = Coupon::where([
            ['id', '=', decrypt($id)],
            ['status', '!=', "Expired"]
        ])->first();

        if (!$data) {
            return abort(404);
        }
        $products = Product::where([
            "status"=>"Active"
        ])
        ->orderBy("created_at", 'DESC')
        ->get();
        return view("backendViews.coupons.edit", compact('data', 'products'));
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
        $this->validate($request, [
            "coupon_code"=>"required|string|max:99|unique:coupons,coupon_code,".decrypt($id),
            "coupon_discount"=>"required",
            "number_of_coupon"=>"nullable|numeric",
            "expire_date"=>"required|date",
            "status"=>"required|string|in:Active,Inactive"
        ]);

        $currentData = Coupon::where('id', decrypt($id))->first();
        if (!$currentData) {
            return abort(404);
        }
        if ($currentData->status === "Expired") {
            return redirect()->route("admin.coupons.index")->with("error", "The coupon is already expired, you can not update anymore.");
        }


        //validate expire date
        $today = date("Y-m-d");
        $expireDate = date("Y-m-d", strtotime($request->expire_date));

        if ($today > $expireDate) {
            return redirect()->back()->with("error", "The coupon expire date looks like expired already!");
        }

        //validate number of coupons
        if ($request->number_of_coupon != '') {
            if ($currentData->coupon_used >= $request->number_of_coupon) {
                return redirect()->back()->with("error", "Coupon already used (".$currentData->coupon_used.") but your update (".$request->number_of_coupon."). You should enter coupon number more than used.");
            }
        }

        Coupon::where('id', $currentData->id)->update([
            "coupon_code"=>$request->coupon_code,
            "coupon_discount"=>$request->coupon_discount,
            "expire_date"=>$expireDate,
            "number_of_coupon"=>$request->number_of_coupon,
            "status"=>$request->status,
            "updated_at"=>Carbon::now()
        ]);

        return redirect()->back()->with('success', "Coupon Updated");
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

    public function actions($couponID, $actionType){
        $data = Coupon::where('id', decrypt($couponID))->first();
        if (!$data) {
            return abort(404);
        }
        if (decrypt($actionType) === "Delete") {
            $data->delete();
            return redirect()->route("admin.coupons.index")->with("success", "Coupon (".$data->coupon_code.") deleted");
        }
        return abort(403);
    }
}
