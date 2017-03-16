<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Rule;

use Log;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Rule::all();
        return view('rules', ['rules' => $rules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info(__METHOD__ . " Creating a new rule");

        try {
            $rules = new Rule();

            $rules->fill($request->all());

            $rules->save();

            return redirect('rules')->with('success', 'Rule Added Successfully');
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " Something went wrong!");
            Log::error(__METHOD__ . $e->getMessage());
            return redirect('rules')->with('errors', 'Rule Already Exists');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Log::info(__METHOD__." Updating Rule $id to Enabled Status of " . $request->enabled);

        $rule = Rule::find($id);

        // dd($request->enabled);

        $rule->enabled = $request->enabled;
        $rule->save();

        return response()->json(['status' => $rule->enabled]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info(__METHOD__ . "Deleting a rule");

        $rule = Rule::findOrFail($id);

        $rule->delete();

        return redirect('rules')->with('success', 'Rule Deleted Successfully');
    }
}
