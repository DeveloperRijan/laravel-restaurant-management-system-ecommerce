<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostCode;
use Carbon\Carbon;

class PostCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PostCode::first();
        return view("backendViews.postcodes.index", compact('data'));
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
            "post_code"=>"required|string|max:99",
            "radius_distance_km"=>"required|numeric|min:1"
        ]);

        $data = PostCode::first();
        if ($data) {
            //update
            $data->update([
                "post_code"=>$request->post_code,
                "radius_distance_km"=>$request->radius_distance_km,
                "updated_at"=>Carbon::now()
            ]);
        }else{
            //insert
            PostCode::insert([
                "post_code"=>$request->post_code,
                "radius_distance_km"=>$request->radius_distance_km,
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ]);
        }
        
        return redirect()->back()->with("success", "Base PostCode & KM has been saved");
        
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
