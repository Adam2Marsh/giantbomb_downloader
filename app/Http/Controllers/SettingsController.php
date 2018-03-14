<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;

class SettingsController extends Controller
{
    public function returnServices()
    {
        return response()->json(Service::all());
    }

    public function updateService($id, Request $request)
    {
        $rule = Service::findORFail($id);
        $rule->enabled = ($request->enabled == "true") ? 1 : 0;
        $rule->save();
        return response()->json($rule);
    }
}
