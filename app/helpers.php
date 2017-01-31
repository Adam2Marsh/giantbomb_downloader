<?php

/**
*       Return sizes readable by humans
*/
function human_filesize($bytes, $decimals  = 2)
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
        // " " => "_",
        // "/" => "-",
        ":" => "",
        "!" => "",
    ];

    return str_replace(array_keys($removeChars), array_values($removeChars), $string);
}
