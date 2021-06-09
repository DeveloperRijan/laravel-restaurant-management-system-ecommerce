<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileHandler extends Controller
{
    /*
    ==========================================================
    | Upload File
    | $file should be the file
    | $fileName should be the fileName that will be used to save as
    | $location the location or directory name where you would like to save under public folder
    ==========================================================
    */
    public static function uploadFile($file, $fileName, $location){
        $current_wd = getcwd();
        $name = $fileName.".".$file->getClientOriginalExtension();
        $file->move($current_wd.$location, $name);
        return $name;
    }


    /*
    ==========================================================
    | Delete File
    | $fileName the file name
    | $location where the exists, the directory name under the public folder
    ==========================================================
    */
    public static function deleteFile($fileName, $location){
        $file__ = $location.$fileName;
        $current_wd = getcwd();

        if (file_exists($current_wd.$file__)) {
            unlink($current_wd.$file__);
        }
        
    }
}
