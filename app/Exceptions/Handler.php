<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() : void
    {
        $this->reportable(function(Throwable $e) {
            if ($this->shouldReport($e) && app()->environment('production') && app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }
}
