<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{
    public function returnAll()
    {
        return response()->json(Setting::where("service_id", 0)->get());
    }
}
