<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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
            'role' => 'customer',
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified customer
     */
    public function show(User $customer)
    {
        // Ensure the user is a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        // Load customer orders with items
        $customer->load(['orders' => function($query) {
            $query->latest()->with('items.product');
        }]);

        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing a customer
     */
    public function edit(User $customer)
    {
        // Ensure the user is a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, User $customer)
    {
        // Ensure the user is a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $customer->id],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $customer->id],
            'is_active' => ['required', 'boolean'],
        ]);

        // Ensure at least email or phone is provided
        if (empty($validated['email']) && empty($validated['phone'])) {
            return back()
                ->withErrors(['email' => 'Either email or phone number is required.'])
                ->withInput();
        }

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Update customer password
     */
    public function updatePassword(Request $request, User $customer)
    {
        // Ensure the user is a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Toggle customer active status
     */
    public function toggleStatus(User $customer)
    {
        // Ensure the user is a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        $customer->update([
            'is_active' => !$customer->is_active,
        ]);

        $status = $customer->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Customer {$status} successfully!");
    }

    /**
     * Remove the specified customer
     */
    public function destroy(User $customer)
    {
        // Ensure the user is a customer
        if ($customer->role !== 'customer') {
            abort(404);
        }

        // Check if customer has orders
        if ($customer->orders()->count() > 0) {
            return back()->with('error', 'Cannot delete customer with existing orders.');
        }

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }
}
