<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MSGSender extends Controller
{
    public static function send($phoneNumber, $message){
    	$api_key = 'XARBH5BkiD7zwA3xGdeY3bLrDfH9qLKDLbESXG47J2w52q';
    	$phoneNumber = \Config::get("constants.DEFAULT_COUNTRY_CODE").$phoneNumber;

		$msg = json_encode(
		    [
		        'to' => $phoneNumber,//447133875699
		        'from' => "VoodooSMS",
		        'msg' => $message,
		        'schedule' => "",
		        'external_reference' => "OrderNotification",
		        'sandbox' => true
		    ]
		);

		$ch = curl_init('https://api.voodoosms.com/sendsms');

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		    'Authorization: ' . $api_key
		]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
    }
}
