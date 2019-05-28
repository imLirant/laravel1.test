<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Region;
use App\City;

class ResidenceController extends Controller
{
	public function getRegions(Request $request)
	{
		$input = $request -> all();

		if (isset($input['country_id'])) {
			$regions = Region::where('country_id', $input['country_id'])
                ->get();
			return array('regions'=>$regions);
		}
	}

	public function getCities(Request $request)
	{
		$input = $request -> all();

		if (isset($input['region_id'])) {
			$cities = City::where('region_id', $input['region_id'])
                ->get();

            return array('cities'=>$cities);
		}
	}
}