<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Company::query();
        $query->where('status', $request->status);
        $data = $query->orderBy("created_at", "DESC")->get();
        return view("backendViews.company.index", compact('data'));
        
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
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:99',
            'code'=>'required|string|max:99|unique:companies',
            'address_line_one'=>'required|string|max:150',
            'address_line_two'=>'nullable|string|max:150',
            'city'=>'required|string|max:50',
            'state'=>'required|string|max:50',
            'can_order_any_time'=>'required|string|in:Yes,No',
            'discount_percent'=>'required'
        ]);

        if ($validation->fails()) {
            return response()->json(["msg"=>$validation->errors()->first()], 422);
        }

        if ($request->can_order_any_time === "No") {
            $validation = Validator::make($request->all(), [
                'start_time'=>'required|date_format:H:i',
                'end_time'=>'required|date_format:H:i|after:start_time',
                'start_day'=>'required|string|in:'.implode(",", \Config::get("constants.WEEK_DAYS")),
                'end_day'=>'required|string|in:'.implode(",", \Config::get("constants.WEEK_DAYS")),
            ]);
            if ($validation->fails()) {
                return response()->json(["msg"=>$validation->errors()->first()], 422);
            }
        }


        $company = new Company([
            'name'=>$request->name,
            'code'=>$request->code,
            'address_line_one'=>$request->address_line_one,
            'address_line_two'=>$request->address_line_two,
            'city'=>$request->city,
            'state'=>$request->state,
            'can_order_any_time'=>$request->can_order_any_time,
            'start_time'=>($request->can_order_any_time === "No" ? $request->start_time : NULL),
            'end_time'=>($request->can_order_any_time === "No" ? $request->end_time : NULL),
            'start_day'=>($request->can_order_any_time === "No" ? $request->start_day : NULL),
            'end_day'=>($request->can_order_any_time === "No" ? $request->end_day : NULL),
            'discount_percent'=>$request->discount_percent,
            'created_at'=>\Carbon\Carbon::now()
        ]);

        if ($company->save()) {
            return response()->json([
                'success'=>true, 
                'msg'=>"Company Profile Created Successfully",
                'data'=>['html_content'=>false]
            ], 200);
        }
        return response()->json(["msg"=>"Internal Server Error || Please try again later."], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::where('id', decrypt($id))->first();
        if (!$company) {
            return abort(404);
        }
        return view("backendViews.company.show", compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::where('id', decrypt($id))->first();
        if (!$company) {
            return abort(404);
        }
        return view("backendViews.company.edit", compact('company'));
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
        $validation = Validator::make($request->all(), [
            'name'=>'required|string|max:99',
            'code'=>'required|string|max:99|unique:companies,code,'.decrypt($id),
            'address_line_one'=>'required|string|max:150',
            'address_line_two'=>'nullable|string|max:150',
            'city'=>'required|string|max:50',
            'state'=>'required|string|max:50',
            'can_order_any_time'=>'required|string|in:Yes,No',
            'discount_percent'=>'required'
        ]);

        if ($validation->fails()) {
            return response()->json(["msg"=>$validation->errors()->first()], 422);
        }

        if ($request->can_order_any_time === "No") {
            $validation = Validator::make($request->all(), [
                'start_time'=>'required|date_format:H:i',
                'end_time'=>'required|date_format:H:i|after:start_time',
                'start_day'=>'required|string|in:'.implode(",", \Config::get("constants.WEEK_DAYS")),
                'end_day'=>'required|string|in:'.implode(",", \Config::get("constants.WEEK_DAYS")),
            ]);
            if ($validation->fails()) {
                return response()->json(["msg"=>$validation->errors()->first()], 422);
            }
        }

        //check record
        $oldCompanyData = Company::where('id', decrypt($id))->first();
        if (!$oldCompanyData) {
            return response()->json(["msg"=>"Company Profile Not Found"], 422);
        }

        $company = Company::where('id', $oldCompanyData->id)->update([
            'name'=>$request->name,
            'code'=>$request->code,
            'address_line_one'=>$request->address_line_one,
            'address_line_two'=>$request->address_line_two,
            'city'=>$request->city,
            'state'=>$request->state,
            'can_order_any_time'=>$request->can_order_any_time,
            'start_time'=>($request->can_order_any_time === "No" ? $request->start_time : NULL),
            'end_time'=>($request->can_order_any_time === "No" ? $request->end_time : NULL),
            'start_day'=>($request->can_order_any_time === "No" ? $request->start_day : NULL),
            'end_day'=>($request->can_order_any_time === "No" ? $request->end_day : NULL),
            'discount_percent'=>$request->discount_percent,
            'updated_at'=>\Carbon\Carbon::now()
        ]);

        return response()->json([
            'success'=>true, 
            'msg'=>"Company Profile Updated Successfully",
            'data'=>['html_content'=>false]
        ], 200);
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



    public function actions($id, $actionType){
        $data = Company::where('id', decrypt($id))->first();
        if (!$data) {
            return abort(404);
        }
        $data->update([
            "status"=>decrypt($actionType)
        ]);
        return redirect()->back()->with("success", "The company is ".decrypt($actionType));
    }
}
