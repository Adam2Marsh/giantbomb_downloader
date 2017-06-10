<?php

/**
*       Return sizes readable by humans
*/
function human_filesize($bytes, $decimals = 2)
{
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

/**
* Remove Special Characters for filename
* @return string
*/
function removeSpecialCharactersFromString($string)
{
    $removeChars = [
        "/" => "",
        ":" => "",
        "!" => "",
        "&" => "",
        "(" => "",
        ")" => "",
    ];

    return str_replace(array_keys($removeChars), array_values($removeChars), $string);
}

function getJSON($JSONUrl)
{

    Log::info(__METHOD__." Performing GET using Guzzle to ".$JSONUrl);

    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', $JSONUrl);

    if (CheckHTTPCallSucessful($res->getStatusCode())) {
        Log::info(__METHOD__." Guzzle Get Request responded with: ".$res->getBody());
        return json_decode($res->getBody());
    } else {
        Log::critical(__METHOD__." HTTP Call to ".$JSONUrl." failed, recieved this back"
            .$res->getStatusCode().$res->getReasonPhrase());
    }
}

function checkHTTPCallSucessful($HttpStatusCode)
{
    if ($HttpStatusCode != 200) {
        return false;
    }
    return true;
}
