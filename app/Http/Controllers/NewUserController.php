<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class NewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('first-time');
    }

    public function validateApiKey(Request $request)
    {
        dd($request->apiKey);
         return getJSON("https://www.giantbomb.com/api/validate?link_code=KEY_HERE".str_replace("KEY_HERE", $request->apiKey));

        // $requestURL = "https://www.giantbomb.com/api/video/2300-8685/?api_key=KEY_HERE&field_list=hd_url".str_replace("KEY_HERE", $request->apiKey, $query);
    }

    public function addApiKey(Request $request)
    {

    }
}
