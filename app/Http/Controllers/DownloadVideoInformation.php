<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DownloadVideoInformation extends Controller
{
    
	public function UpdateInformation()
	{
		$DVI = new \App\Services\DownloadVideoInformation;
		print_r($DVI->GetJSON('http://localhost/GB_Example_One.json'));
	}

}
