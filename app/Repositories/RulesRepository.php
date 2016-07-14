<?php

namespace App\Repositories;

use Log;
use App\Rule;

class RulesRepository
{

  public function VideoMatchRules($videoName)
  {
    Log::info(__METHOD__ . " Checking if $videoName matches any rules");
    foreach (Rule::where('enabled', '=', '1')->get() as $rule) {
      if(preg_match("/$rule->regex/", $videoName)) {
        return true;
      }
    }

    return false;
  }


}
