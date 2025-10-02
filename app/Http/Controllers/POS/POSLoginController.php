<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class POSLoginController extends Controller
{
    /**
     * Display POS login form
     */
    public function create()
    {
        return view('pos.auth.login');
    }

    /**
     * Handle POS login request
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
            
            // Check if user has POS access
            if (!$user->canAccessPOS()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'You do not have permission to access the POS system.',
                ]);
            }

            $request->session()->regenerate();
            
            return redirect()->intended(route('pos.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log out the POS user
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('pos.login');
    }
}
