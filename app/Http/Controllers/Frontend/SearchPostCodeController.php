<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchPostCodeController extends Controller
{
    public function search_post_code(Request $request){
    	if ($request->post_code == '') {
    		return redirect()->back()->with("sw_alert_session_error", "Please enter your postcode");
    	}

    	return redirect()->back()->with("sw_alert_session_error", "We are currently provisioning API, please wait until we live - thanks");
    	
    	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=144216,india&destinations=160017,india&mode=driving&language=en-EN&sensor=false";
           $data   = @file_get_contents($url);
           $result = json_decode($data, true); //print_r($result);  

           print_r($result);

           //outputs the array    $distances = array( // converts the units
           //"meters" => $result["rows"][0]["elements"][0]["distance"]["value"],
           //"kilometers" => $result["rows"][0]["elements"][0]["distance"]["value"] / 1000,
           //"yards" => $result["rows"][0]["elements"][0]["distance"]["value"] * 1.0936133,
           //"miles" => $result["rows"][0]["elements"][0]["distance"]["value"] * 0.000621371    );        
            //print_r($distances);
    }
}
