<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Services\GiantBombApiService;
use App\Repositories\ConfigRepository;

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

    public function getApiKeyAndSave(
        Request $request,
        GiantBombApiService $giantBombApiService,
        ConfigRepository $configRepository)
    {
        // $apiKey = $giantBombApiService->getApiKey($request->linkCode);

        if(!isset($apiKey->api_key)) {
            return response()->json([
                "message" => "Link Code Not Valid"
            ], 500);
        }

        if($giantBombApiService->checkApiKeyIsPremium($apiKey->api_key)) {
            $configRepository->UpdateConfig("API_KEY", $apiKey->api_key);
            return response()->json([
                "message" => "Api Key Retrieved and Premium"
            ], 200);
        }

        return response()->json([
            "message" => "User not Premium Member"
        ], 500);

    }

}
