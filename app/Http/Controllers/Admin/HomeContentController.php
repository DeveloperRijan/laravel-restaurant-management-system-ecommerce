<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeContent;
use App\Models\Category;
use Carbon\Carbon;

class HomeContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where("type", "Main")->orderBy("name", "ASC")->get();
        $dataPos1 = HomeContent::where("position_no", 1)->first();
        $dataPos2 = HomeContent::where("position_no", 2)->first();
        $dataPos3 = HomeContent::where("position_no", 3)->first();
        return view("backendViews.homeContent.index", compact('dataPos1', 'dataPos2', 'dataPos3', 'categories'));
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
            "positions"=>"required|array|min:3|max:3",
            "positions.*"=>"required|in:1,2,3",

            "category"=>"required|array|min:3|max:3",
            "category.*"=>"required|numeric",

            "order_by"=>"required|array|min:3|max:3",
            "order_by.*"=>"required|string|in:Latest,Oldest,Random"
        ]);

        //validate category is valid
        foreach ($request->positions as $key => $pos) {
            if (!Category::where('id', $request->category[$key])->exists()) {
                $rowNumber = ($key+1);
                return redirect()->back()->with('error', "Invalid Category at row number : ".$rowNumber);
            }
        }
        //validate positions
        $unique_positions = array_unique($request->positions);
        if (count($unique_positions) != count($request->positions)) {
            return redirect()->back()->with('error', "Duplicate position value detected!");
        }

        //validate categories
        $unique_categories = array_unique($request->category);
        if (count($unique_categories) != count($request->category)) {
            return redirect()->back()->with('error', "Duplicate category value detected!");
        }

        $data = HomeContent::orderBy("position_no", 'ASC')->get();

        //insert data
        if (!$data->isEmpty()) {
            //update
            foreach ($request->positions as $key => $position) {
                HomeContent::where('position_no', $position)->update([
                    "category_id"=>$request->category[$key],
                    "order_by"=>$request->order_by[$key],
                    //"position_no"=>$position,
                    "updated_at"=>Carbon::now()
                ]);
            }
            return redirect()->back()->with('success', "Data Updated");
        }

        //else insert

        foreach ($request->positions as $key => $position) {
            HomeContent::insert([
                "category_id"=>$request->category[$key],
                "order_by"=>$request->order_by[$key],
                "position_no"=>$position,
                "created_at"=>Carbon::now()
            ]);
        }
        return redirect()->back()->with('success', "Data Saved");
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
