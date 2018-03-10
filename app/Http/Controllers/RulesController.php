<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rule;

class RulesController extends Controller
{
    public function returnAll()
    {
        return response()->json(Rule::orderBy('rule', 'desc')->get());
    }

    public function addRule(Request $request)
    {
        $rule = new Rule();
        $rule->rule = $request->rule;
        $rule->enabled = 1;
        $rule->save();
        return response()->json($rule);
    }

    public function updateRule($id, Request $request)
    {
        $rule = Rule::findORFail($id);
        $rule->enabled = ($request->enabled == "true") ? 1 : 0;
        $rule->save();
        return response()->json($rule);
    }

    public function deleteRule($id)
    {
        Rule::destroy($id);
        return response()->json('deleted');
    }
}
