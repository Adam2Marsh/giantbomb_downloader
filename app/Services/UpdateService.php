<?php

namespace App\Services;

use Log;

class UpdateService
{

    public function isThereAUpdate()
    {
        Log::info(__METHOD__ . "Checking for updates");

        $output = exec('cd /opt/giantbomb_downloader | git fetch && git status');

        Log::info(__METHOD__ . "Raw Output from check is: " . $output);

        if (str_contains($output, 'Your branch is up-to-date')) {
            return false;
        }

        return true;
    }

    public function update()
    {
        Log::info(__METHOD__ . "I've been asked to update, let's do this");

        exec('cd /opt/giantbomb_downloader | git pull');
    }
}
