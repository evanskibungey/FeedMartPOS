<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PortalRedirectService
{
    /**
     * Get the appropriate dashboard route for the authenticated user
     */
    public static function getDashboardRoute(): string
    {
        if (!Auth::check()) {
            return route('home');
        }

        $user = Auth::user();

        // Super admin and admin can access admin portal
        if ($user->canAccessAdmin()) {
            return route('admin.dashboard');
        }

        // Cashiers go to POS
        if ($user->isCashier()) {
            return route('pos.dashboard');
        }

        // Customers go to customer dashboard
        if ($user->isCustomer()) {
            return route('dashboard');
        }

        // Fallback to home
        return route('home');
    }

    /**
     * Get a friendly message explaining the redirect
     */
    public static function getRedirectMessage(string $attemptedPortal): string
    {
        if (!Auth::check()) {
            return "Please login to access {$attemptedPortal}.";
        }

        $user = Auth::user();
        $role = str_replace('_', ' ', ucfirst($user->role));

        return "You are logged in as {$role}. You've been redirected to your dashboard.";
    }

    /**
     * Get portal name from route
     */
    public static function getPortalName(?string $route = null): string
    {
        $route = $route ?? request()->route()->getName();

        if (str_contains($route, 'admin.')) {
            return 'Admin Portal';
        }

        if (str_contains($route, 'pos.')) {
            return 'POS System';
        }

        return 'Customer Portal';
    }
}
