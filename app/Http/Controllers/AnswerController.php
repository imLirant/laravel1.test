<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnswerController extends Controller
{
	public function index() 
	{
		return view('Answer');
	}

	public function getYesNo() 
	{
		return file_get_contents("https://yesno.wtf/api");
	}
}