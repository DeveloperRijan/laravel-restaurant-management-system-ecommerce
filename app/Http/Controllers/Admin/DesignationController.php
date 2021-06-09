<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use Carbon\Carbon;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Designation::orderBy("created_at", "DESC")->get();
        return view("backendViews.designations.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backendViews.designations.create");
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
            "title"=>"required|string|max:99|unique:designations"
        ]);

        $designation = new Designation([
            "title"=>$request->title,
            "created_at"=>Carbon::now()
        ]);

        if ($designation->save()) {
            return redirect()->back()->with("success", "Created Successfully");
        }
        return redirect()->back()->with("error", "Internal server error | please try again later.");
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
        $data = Designation::where('id', decrypt($id))->first();
        if (!$data) {
            return abort(404);
        }
        return view("backendViews.designations.edit", compact('data'));
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
            "title"=>"required|string|max:99|unique:designations,title,".decrypt($id)
        ]);

        $data = Designation::where('id', decrypt($id))->first();
        if (!$data) {
            return abort(404, "Designation Not Found");
        }

        $data->update([
            "title"=>$request->title,
            "updated_at"=>Carbon::now()
        ]);

        return redirect()->back()->with("success", "Updated Successfully");
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
        $data = Designation::where('id', decrypt($id))->first();
        if (!$data) {
            return abort(404);
        }
        $data->delete();
        return redirect()->back()->with("success", "Data Soft Deleted");
    }
}
