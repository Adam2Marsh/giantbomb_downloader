<?php

namespace App\Http\Requests;

use Storage;

class CustomValidator
{

    public function validateDirectoryExists($attribute, $value, $parameters, $validator) {
        Storage::disk('root')->
    }

}