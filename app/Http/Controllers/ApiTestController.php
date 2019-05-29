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
}	