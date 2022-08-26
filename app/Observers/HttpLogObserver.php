<?php

declare(strict_types=1);

namespace App\Observers;

use DragonCode\LaravelHttpLogger\Models\HttpLog;

class HttpLogObserver
{
    public function saving(HttpLog $httpLog) : void
    {
        $httpLog->user_id = auth()->id();
    }
}
