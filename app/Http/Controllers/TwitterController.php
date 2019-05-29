<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Twitter;

class TwitterController extends Controller
{
	public function getUserTimeline(Request $request)
	{
		$items = $request -> all(); 

		if (isset($items['username']) and isset($items['count'])) {
			return Twitter::getUserTimeline(['screen_name' => $items['username'], 'count' => $items['count'], 'format' => 'json']);	
		}
		return [];
	}
}	