<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rule;

class RulesController extends Controller
{
    /**
     * Return all rules
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function returnAll()
    {
        return response()->json(Rule::orderBy('rule', 'desc')->get());
    }

    /**
     * Add a new rule
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRule(Request $request)
    {
        $rule = new Rule();
        $rule->rule = $request->rule;
        $rule->enabled = 1;
        $rule->save();
        return response()->json($rule);
    }

    /**
     * Toggle a rule
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRule($id, Request $request)
    {
        $rule = Rule::findORFail($id);
        $rule->enabled = ($request->enabled == "true") ? 1 : 0;
        $rule->save();
        return response()->json($rule);
    }

    /**
     * Delete a rule
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRule($id)
    {
        Rule::destroy($id);
        return response()->json('deleted');
    }
}
