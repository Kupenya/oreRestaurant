<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckOperationalHours
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Define the operational hours directly in the middleware
        $startHour = 10; // Start hour (10 AM)
        $endHour = 18;   // End hour (6 PM)

        // Get the current time in the application's time zone
        $currentTime = Carbon::now()->setTimezone(config('app.timezone'));

        // Check if the current time is within the operational hours
        if ($currentTime->hour < $startHour || $currentTime->hour >= $endHour) {
            return response()->json(['error' => 'Orders can only be placed between 10 AM and 6 PM.'], 403);
        }

        return $next($request); // Allow request to proceed if within operational hours
    }
}