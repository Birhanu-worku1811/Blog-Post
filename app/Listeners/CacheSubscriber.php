<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handleCacheHit(CacheHit $event): void
    {
        Log::info("{$event->key} cache hit");
    }

    public function handleCacheMissed(CacheMissed $event): void
    {
        Log::info("{$event->key} cache missed");
    }

    public function subscribe($events)
    {
        $events->listen(
            CacheHit::class,
            'App\Listeners\CacheSubscriber@handleCacheHit'
        );

        $events->listen(
            CacheMissed::class,
            'App\Listeners\CacheSubscriber@handleCacheMissed'
        );
    }
}
