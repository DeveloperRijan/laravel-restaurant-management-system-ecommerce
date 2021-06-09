<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileHandler;
use Illuminate\Http\Request;
use App\Models\Slider;
use Carbon\Carbon;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy("created_at", "ASC")->get();
        return view("backendViews.sliders.index", compact('sliders'));
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
            "image"=>"required|image|mimes:jpeg,jpg,png,gif"
        ]);

        //check sliders limit
        $slidersCount = Slider::count();
        if ($slidersCount == 5) {
            return redirect()->back()->with("error", "You have reached the limit of 5 sliders");
        }

        $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.SLIDERS");
        $fileName = uniqid().mt_rand(100, 9999);
        
        $image = FileHandler::uploadFile($request->file("image"), $fileName, $location);

        $slider = new Slider([
            "image"=>$image,
            "created_at"=>Carbon::now()
        ]);

        if ($slider->save()) {
            return redirect()->back()->with("success", "Slider Added");
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
        $this->validate($request, [
            "image"=>"required|image|mimes:jpeg,jpg,png,gif"
        ]);

        //check sliders limit
        $currentSlider = Slider::where('id', $id)->first();
        if (!$currentSlider) {
            return redirect()->back()->with("error", "Slider Not Found");
        }

        $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.SLIDERS");
        $fileName = uniqid().mt_rand(100, 9999);
        
        //delete older one
        FileHandler::deleteFile($currentSlider->image, $location);
        //upload new one
        $image = FileHandler::uploadFile($request->file("image"), $fileName, $location);

        $currentSlider->update(['image'=>$image]);

        return redirect()->back()->with("success", "Slider Updated");
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
        $data = Slider::where('id', decrypt($id))->first();
        if (!$data) {
            return abort(404);
        }

        $location = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.SLIDERS");
        FileHandler::deleteFile($data->image, $location);
        $data->delete();
        return redirect()->back()->with("success", "Slider Deleted");
    }
}
