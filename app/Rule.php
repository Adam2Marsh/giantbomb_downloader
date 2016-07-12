<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
  /**
  * The attributes that are mass assignable.
  *
  * @var array
  */
  protected $fillable = ['regex', 'enabled'];


}
