<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Twitter;

class ApiTestController extends Controller
{
	public function getResponse(Request $request)
	{
		$input = $request -> all();

		if (isset($input['url'])) {
			return file_get_contents($request['url']);
		}
	}

	public function sandPost(Request $request)
	{
		$input = $request -> all();

		$myCurl = curl_init();

		header('Authorization: ');
		header('OAuth oauth_consumer_key="VQP3CebsNut67aDMmhFpTWtpX"');
		header('oauth_version="1.0"');

		curl_setopt_array($myCurl, array(
	    	CURLOPT_URL => $input['url'],
	    	CURLOPT_RETURNTRANSFER => true,
	    	CURLOPT_POST => true,
	    	// CURLOPT_POSTFIELDS => http_build_query(array($input['params']))
		));

		$response = curl_exec($myCurl);
		curl_close($myCurl);

		return $response;
	}

	public function test()
	{
		return Twitter::getUserTimeline(['screen_name' => 'elonmusk', 'count' => 20, 'format' => 'json']);
	}
}	