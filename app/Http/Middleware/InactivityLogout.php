<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class InactivityLogout
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $timeoutMinutes = (int) env('INACTIVITY_TIMEOUT_MINUTES', 30);

        if ($timeoutMinutes > 0) {
            $lastActivity = (int) ($request->session()->get('last_activity', 0));
            $now = now()->timestamp;

            if ($lastActivity > 0 && ($now - $lastActivity) > ($timeoutMinutes * 60)) {
                // Logout user and invalidate session
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Proactively clear session and remember-me cookies
                Cookie::queue(Cookie::forget(config('session.cookie')));
                try {
                    $recaller = Auth::guard()->getRecallerName();
                    if (!empty($recaller)) {
                        Cookie::queue(Cookie::forget($recaller));
                    }
                } catch (\Throwable $e) {
                    // ignore if guard not available here
                }

                return redirect()->route('login')
                    ->with('status', 'Sesi berakhir karena tidak ada aktivitas. Silakan login kembali.');
            }
        }

        $response = $next($request);

        // Update last activity timestamp on successful request
        if ($request->hasSession()) {
            $request->session()->put('last_activity', now()->timestamp);
        }

        return $response;
    }
}


