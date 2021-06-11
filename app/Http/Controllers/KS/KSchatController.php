<?php

namespace App\Http\Controllers\KS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KSchatController extends Controller
{
    public function chat_page(){
    	return view("ks_panel.chat.chat");
    }
}
