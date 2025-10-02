<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\PortalRedirectService;

class CustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to continue');
        }

        if (!auth()->user()->isCustomer()) {
            // Instead of 403, redirect to appropriate dashboard with message
            $redirectRoute = PortalRedirectService::getDashboardRoute();
            $message = PortalRedirectService::getRedirectMessage('Customer Portal');
            
            return redirect($redirectRoute)->with('info', $message);
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated');
        }

        return $next($request);
    }
}
