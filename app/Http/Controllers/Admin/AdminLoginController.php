<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    /**
     * Display admin login form
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login request
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if login is by email or phone
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        
        $credentials = [
            $loginField => $request->email,
            'password' => $request->password,
            'is_active' => true,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user has admin access
            if (!$user->canAccessAdmin()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'You do not have permission to access the admin portal.',
                ]);
            }

            $request->session()->regenerate();
            
            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log out the admin user
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
