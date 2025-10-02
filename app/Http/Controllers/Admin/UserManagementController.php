<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::where('role', '!=', 'customer')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        $roles = [
            'admin' => 'Administrator',
            'cashier' => 'Cashier',
        ];

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,cashier'],
        ]);

        // Ensure at least email or phone is provided
        if (empty($validated['email']) && empty($validated['phone'])) {
            return back()
                ->withErrors(['email' => 'Either email or phone number is required.'])
                ->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        // Prevent editing super admin
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot edit super admin account.');
        }

        $roles = [
            'admin' => 'Administrator',
            'cashier' => 'Cashier',
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        // Prevent editing super admin
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot edit super admin account.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $user->id],
            'role' => ['required', 'in:admin,cashier'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Ensure at least email or phone is provided
        if (empty($validated['email']) && empty($validated['phone'])) {
            return back()
                ->withErrors(['email' => 'Either email or phone number is required.'])
                ->withInput();
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request, User $user)
    {
        // Prevent editing super admin
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot edit super admin account.');
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        // Prevent disabling super admin
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot disable super admin account.');
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "User {$status} successfully!");
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting super admin
        if ($user->isSuperAdmin()) {
            abort(403, 'Cannot delete super admin account.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
