<?php

namespace App\Http\Controllers;

use App\Services\UpdateService;
use Illuminate\Http\Request;
use Log;

class UpdateController extends Controller
{

    public function index()
    {
        return view("update");
    }

    public function check(UpdateService $updateService)
    {
        if ($updateService->isThereAUpdate()) {
            return 1;
        }

        return 0;
    }

    public function update(UpdateService $updateService)
    {
        $updateService->update();

        if ($updateService->isThereAUpdate()) {
            return view('update')->with('success', 'Update Successful');
        }

        return view('update')->withErrors('Update Failed');
    }
}
