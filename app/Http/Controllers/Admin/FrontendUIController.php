<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileHandler;
use Illuminate\Http\Request;
use App\Models\FrontendUI;
use Carbon\Carbon;

class FrontendUIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FrontendUI::first();
        return view("backendViews.frontendUI.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            "app_logo"=>"nullable|image|mimes:png",
            "app_title"=>"required|string|max:100",

            "home_banner_title"=>"nullable|string|max:100",
            "home_banner_title_color"=>"nullable|string",
            "home_banner_description"=>"nullable|string|max:200",
            "home_banner_description_color"=>"nullable|string",

            "search_box_bg_color"=>"required|string",
            "search_box_text"=>"required|string|max:50",
            "search_box_text_color"=>"required|string",
            "search_button_text"=>"required|string|max:25",
            "search_button_text_color"=>"required|string",
            "search_button_bg_color"=>"required|string",

            "easy_2_step_left_title"=>"required|string|max:50",
            "easy_2_step_left_title_color"=>"required|string",
            "easy_2_step_left_description"=>"required|string|max:100",
            "easy_2_step_left_description_color"=>"required|string",
            "easy_2_step_right_title"=>"required|string|max:50",
            "easy_2_step_right_title_color"=>"required|string",
            "easy_2_step_right_description"=>"required|string|max:100",
            "easy_2_step_right_description_color"=>"required|string",
            "easy_2_step_small_text"=>"required|string|max:70",

            "app_section_bg_color"=>"required|string",
            "app_section_title"=>"required|string|max:60",
            "app_section_title_color"=>"required|string",
            "app_section_description"=>"required|string|max:150",
            "app_section_description_color"=>"required|string",
            "play_store_app_link"=>"nullable|string|max:250|url",
            "apple_app_link"=>"nullable|string|max:250|url",

            "footer_bg_color"=>"required|string",
            "facebook_url"=>"nullable|string|max:250|url",
            "twitter_url"=>"nullable|string|max:250|url",
            "linkedIn_url"=>"nullable|string|max:250|url",
            "youtube_url"=>"nullable|string|max:250|url",
            "instagram_url"=>"nullable|string|max:250|url",

            "singin_image"=>"nullable|image|mimes:png",
            "signup_image"=>"nullable|image|mimes:png",
            "reservation_image"=>"nullable|image|mimes:png",

            "contact_email"=>"required|string|email|max:99",
            "contact_phone"=>"required|string|max:20",
            "contact_address"=>"required|string|max:200"

        ]);

        $currentData = FrontendUI::first();

        //Upload Images
        $logoLocation = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.LOGO");
        $iconLocation = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.ICON");
        $bannerLocation = \Config::get("constants.PUBLIC.ASSETS_START_PATH").\Config::get("constants.FILE_PATH.BANNER");
        
        $app_logo = NULL;
        $singin_image = NULL;
        $signup_image = NULL;
        $reservation_image = NULL;

        //app_logo
        if ($request->hasFile("app_logo")) {
            $fileName = "app_logo";
            $app_logo = FileHandler::uploadFile($request->file("app_logo"), $fileName, $logoLocation);
        }

        //singin_image
        if ($request->hasFile("singin_image")) {
            $fileName = "singin_image";
            $singin_image = FileHandler::uploadFile($request->file("singin_image"), $fileName, $iconLocation);
        }

        //signup_image
        if ($request->hasFile("signup_image")) {
            $fileName = "signup_image";
            $signup_image = FileHandler::uploadFile($request->file("signup_image"), $fileName, $iconLocation);
        }

        //reservation_image
        if ($request->hasFile("reservation_image")) {
            $fileName = "reservation_image";
            $reservation_image = FileHandler::uploadFile($request->file("reservation_image"), $fileName, $iconLocation);
        }

        if ($currentData) {
            //update
            FrontendUI::where('id', $currentData->id)->update([
                "app_logo"=>($app_logo === NULL ? $currentData->app_logo : $app_logo),
                "app_title"=>$request->app_title,
                "home_banner_title"=>$request->home_banner_title,
                "home_banner_title_color"=>$request->home_banner_title_color,
                "home_banner_description"=>$request->home_banner_description,
                "home_banner_description_color"=>$request->home_banner_description_color,

                "search_box_bg_color"=>$request->search_box_bg_color,
                "search_box_text"=>$request->search_box_text,
                "search_box_text_color"=>$request->search_box_text_color,
                "search_button_text"=>$request->search_button_text,
                "search_button_text_color"=>$request->search_button_text_color,
                "search_button_bg_color"=>$request->search_button_bg_color,

                "easy_2_step_left_title"=>$request->easy_2_step_left_title,
                "easy_2_step_left_title_color"=>$request->easy_2_step_left_title_color,
                "easy_2_step_left_description"=>$request->easy_2_step_left_description,
                "easy_2_step_left_description_color"=>$request->easy_2_step_left_description_color,
                "easy_2_step_right_title"=>$request->easy_2_step_right_title,
                "easy_2_step_right_title_color"=>$request->easy_2_step_right_title_color,
                "easy_2_step_right_description"=>$request->easy_2_step_right_description,
                "easy_2_step_right_description_color"=>$request->easy_2_step_right_description_color,
                "easy_2_step_small_text"=>$request->easy_2_step_small_text,

                "app_section_bg_color"=>$request->app_section_bg_color,
                "app_section_title"=>$request->app_section_title,
                "app_section_title_color"=>$request->app_section_title_color,
                "app_section_description"=>$request->app_section_description,
                "app_section_description_color"=>$request->app_section_description_color,
                "play_store_app_link"=>$request->play_store_app_link,
                "apple_app_link"=>$request->apple_app_link,

                "footer_bg_color"=>$request->footer_bg_color,
                "facebook_url"=>$request->facebook_url,
                "twitter_url"=>$request->twitter_url,
                "linkedIn_url"=>$request->linkedIn_url,
                "youtube_url"=>$request->youtube_url,
                "instagram_url"=>$request->instagram_url,

                "singin_image"=>($singin_image === NULL ? $currentData->singin_image : $singin_image),
                "signup_image"=>($signup_image === NULL ? $currentData->signup_image : $signup_image),
                "reservation_image"=>($reservation_image === NULL ? $currentData->reservation_image : $reservation_image),

                "contact_email"=>$request->contact_email,
                "contact_phone"=>$request->contact_phone,
                "contact_address"=>$request->contact_address,
                "updated_at"=>Carbon::now()
            ]);
            return redirect()->back()->with('success', "Data Updated");
        }

        //else insert
        $uiData = New FrontendUI([
            "app_logo"=>($app_logo === NULL ? 'init' : $app_logo),
            "app_title"=>$request->app_title,
            "home_banner_title"=>$request->home_banner_title,
            "home_banner_title_color"=>$request->home_banner_title_color,
            "home_banner_description"=>$request->home_banner_description,
            "home_banner_description_color"=>$request->home_banner_description_color,

            "search_box_bg_color"=>$request->search_box_bg_color,
            "search_box_text"=>$request->search_box_text,
            "search_box_text_color"=>$request->search_box_text_color,
            "search_button_text"=>$request->search_button_text,
            "search_button_text_color"=>$request->search_button_text_color,
            "search_button_bg_color"=>$request->search_button_bg_color,

            "easy_2_step_left_title"=>$request->easy_2_step_left_title,
            "easy_2_step_left_title_color"=>$request->easy_2_step_left_title_color,
            "easy_2_step_left_description"=>$request->easy_2_step_left_description,
            "easy_2_step_left_description_color"=>$request->easy_2_step_left_description_color,
            "easy_2_step_right_title"=>$request->easy_2_step_right_title,
            "easy_2_step_right_title_color"=>$request->easy_2_step_right_title_color,
            "easy_2_step_right_description"=>$request->easy_2_step_right_description,
            "easy_2_step_right_description_color"=>$request->easy_2_step_right_description_color,
            "easy_2_step_small_text"=>$request->easy_2_step_small_text,

            "app_section_bg_color"=>$request->app_section_bg_color,
            "app_section_title"=>$request->app_section_title,
            "app_section_title_color"=>$request->app_section_title_color,
            "app_section_description"=>$request->app_section_description,
            "app_section_description_color"=>$request->app_section_description_color,
            "play_store_app_link"=>$request->play_store_app_link,
            "apple_app_link"=>$request->apple_app_link,

            "footer_bg_color"=>$request->footer_bg_color,
            "facebook_url"=>$request->facebook_url,
            "twitter_url"=>$request->twitter_url,
            "linkedIn_url"=>$request->linkedIn_url,
            "youtube_url"=>$request->youtube_url,
            "instagram_url"=>$request->instagram_url,

            "singin_image"=>($singin_image === NULL ? 'init' : $singin_image),
            "signup_image"=>($signup_image === NULL ? 'init' : $signup_image),
            "reservation_image"=>($reservation_image === NULL ? 'init' : $reservation_image),

            "contact_email"=>$request->contact_email,
            "contact_phone"=>$request->contact_phone,
            "contact_address"=>$request->contact_address,
            "created_at"=>Carbon::now()
        ]);
        if ($uiData->save()) {
            return redirect()->back()->with('success', "Data Saved");
        }
        return redirect()->back()->with('error', "Internal server error | Please try again later.");
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
