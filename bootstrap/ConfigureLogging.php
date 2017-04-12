<?php namespace Bootstrap;

use Illuminate\Log\Writer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger as Monolog;

class ConfigureLogging extends BaseConfigureLogging {

    /**
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureDailyHandler(Application $app, Writer $log)
    {
        // Stream handlers
        $logPath = $app->storagePath().'/logs/gb-downloader-' . php_sapi_name() . '.log';

        $logStreamHandler = new RotatingFileHandler(
            $logPath,
            $app->make('config')->get('app.log_max_files', 5));

        // Formatting
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $logFormat = "%datetime% [%level_name%] (%channel%) %extra%: %message% %context%\n";
        $formatter = new LineFormatter($logFormat, null, true, true);
        $logStreamHandler->setFormatter($formatter);

        // push handlers
        $logger = $log->getMonolog();

        $logger->pushHandler($logStreamHandler);
    }
}