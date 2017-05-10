<?php

namespace App\Services;

use Log;
use Symfony\Component\Process\Process;

class UpdateService
{

    public function isThereAUpdate()
    {
        Log::info(__METHOD__ . " - Checking for updates");

        $process = new Process('cd /opt/giantbomb_downloader | git fetch && git status');

        $process->run();

        if ($process->isSuccessful()) {
            Log::info(__METHOD__ . " - Raw Output from check is: " . $process->getOutput());

            if (str_contains($process->getOutput(), 'Your branch is up-to-date')) {
                return false;
            }
        } else {
            Log::info(__METHOD__ . " - Something failed when checking for update " . $process->getErrorOutput());

            return false;
        }

        return true;
    }

    public function update()
    {
        Log::info(__METHOD__ . - "I've been asked to update, let's do this");

//        exec('cd /opt/giantbomb_downloader | git pull');

        $process = new Process('cd /opt/giantbomb_downloader | git pull');

        $process->run();
    }
}
