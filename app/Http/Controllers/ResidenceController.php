<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;

class ResidenceController extends Controller
{
	public function index()
	{
		return null; 
	}

	public function getRegions()
	{
		$input = Request::all();

		if (isset($input['country_id'])) {
			$regions = DB::table('region')
                ->where('country_id', $input['country_id'])
                ->get();
			return array('regions'=>$regions);
		}
	}

	public function getCitys()
	{
		$input = Request::all();

		if (isset($input['region_id'])) {
			$citys = DB::table('city')
                ->where('region_id', $input['region_id'])
                ->get();

            return array('citys'=>$citys);  
		}
	}
}