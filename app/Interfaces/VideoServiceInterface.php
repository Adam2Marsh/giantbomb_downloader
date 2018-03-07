<?php
/**
 * Created by PhpStorm.
 * User: adam2marsh
 * Date: 15/02/2018
 * Time: 07:17
 */

namespace App\Interfaces;


interface VideoServiceInterface
{

    public function register($key);
    public function fetchLatestVideosFromApi();
    public function returnVideoToDatabaseMappings();
    public function buildUrl($video);

}