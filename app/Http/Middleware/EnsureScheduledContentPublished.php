<?php

namespace App\Http\Middleware;

use App\Console\Commands\PublishScheduledContent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Self-healing companion to `php artisan content:publish-scheduled`. On a
 * dev machine with no cron/scheduler running, scheduled publishing would
 * silently never happen. This runs the same check at most once every 5
 * minutes (cache-locked so it's cheap on every other request) so scheduled
 * content and agreement expiry stay correct without extra setup. Safe to
 * remove once a real scheduler (cron / Task Scheduler) is confirmed running.
 */
class EnsureScheduledContentPublished
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Cache::add('scheduled-content-check-lock', true, 300)) {
            Artisan::call('content:publish-scheduled');
        }

        return $next($request);
    }
}