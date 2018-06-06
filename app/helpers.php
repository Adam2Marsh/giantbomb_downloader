<?php

/**
*       Return sizes readable by humans
*/
function humanFilesize($bytes, $decimals = 2)
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
        "'" => "",
        "," => "",
        "\\" => "",
        "-" => "",
        "?" => "",
        "." => "",
    ];

    return str_replace(array_keys($removeChars), array_values($removeChars), $string);
}

/**
 * Provides a name back in a format for local disk use
 *
 * @param $name
 * @return string
 */
function localFilename($name)
{
    return snake_case(removeSpecialCharactersFromString($name));
}

/**
 * How I perform all get requests and decode the json response
 *
 * @param $JSONUrl
 * @return mixed
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function getJSON($JSONUrl)
{

    Log::info(__METHOD__." Performing GET using Guzzle to ".$JSONUrl);

    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', $JSONUrl);

    if (checkHTTPCallSuccessful($res->getStatusCode())) {
        Log::info(__METHOD__." Guzzle Get Request responded with: ".$res->getBody());
        return json_decode($res->getBody(), true);
    } else {
        Log::critical(__METHOD__." HTTP Call to ".$JSONUrl." failed, recieved this back"
            .$res->getStatusCode().$res->getReasonPhrase());
    }
}

/**
 * Check http response code is successful
 *
 * @param $HttpStatusCode
 * @return bool
 */
function checkHTTPCallSuccessful($HttpStatusCode)
{
    if ($HttpStatusCode != 200) {
        return false;
    }
    return true;
}

/**
 * Return service id for a service name
 *
 * @param $service
 * @return mixed
 */
function returnServiceId($service)
{
    return \App\Service::where('name', '=', $service)->first()->id;
}