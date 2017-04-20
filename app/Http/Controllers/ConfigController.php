<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigUpdateRequest;
use App\Http\Requests\CreateConfigRequest;
use App\Repositories\ConfigRepository;
use Illuminate\Http\Request;
use App\Config;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apiKey = Config::where('name', '=', 'API_KEY')->first();
        $slackHookUrl = Config::where('name', '=', 'SLACK_HOOK_URL')->first();

        return view('configs', ['apiKey' => $apiKey, 'slackHookUrl' => $slackHookUrl]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateConfigRequest $request, ConfigRepository $configRepository)
    {
        $configRepository->UpdateConfig($request->name, $request->value);
        return redirect('configs')->with('success', 'Config Added Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigUpdateRequest $request, $id)
    {
//        dd($request->all());
        $config = Config::findOrFail($id);
        $config->value = $request->{$config->name};
        $config->save();
        return redirect('configs')->with('success', 'Config Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Config::destroy($id);
        return redirect('configs')->with('success', 'Config Deleted Successfully');
    }
}
