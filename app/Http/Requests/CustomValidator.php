<?php

namespace App\Http\Requests;

use Storage;

class CustomValidator
{

    public function validateDirectoryExists($attribute, $value, $parameters, $validator)
    {
        return Storage::disk('root')->has($value);
    }

    public function validatePermissionsInDirectory($attribute, $value, $parameters, $validator)
    {
        try {
            Storage::disk('root')->makeDirectory("$value/test");
            Storage::disk('root')->deleteDirectory("$value/test");
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
