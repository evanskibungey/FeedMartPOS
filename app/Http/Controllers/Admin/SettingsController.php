<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index()
    {
        $settings = [
            'system_name' => Setting::get('system_name', 'FeedMart POS'),
            'system_logo' => Setting::get('system_logo'),
            'system_currency' => Setting::get('system_currency', 'KES'),
        ];

        $currencies = [
            'KES' => 'Kenyan Shilling (KES)',
            'USD' => 'US Dollar ($)',
            'EUR' => 'Euro (€)',
            'GBP' => 'British Pound (£)',
            'UGX' => 'Ugandan Shilling (UGX)',
            'TZS' => 'Tanzanian Shilling (TZS)',
        ];

        return view('admin.settings.index', compact('settings', 'currencies'));
    }

    /**
     * Update system settings
     */
    public function updateSystem(Request $request)
    {
        $validated = $request->validate([
            'system_name' => 'required|string|max:255',
            'system_currency' => 'required|string|in:KES,USD,EUR,GBP,UGX,TZS',
            'system_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        // Update system name
        Setting::set('system_name', $validated['system_name'], 'string', 'System Name');

        // Update currency
        Setting::set('system_currency', $validated['system_currency'], 'string', 'System Currency');

        // Handle logo upload
        if ($request->hasFile('system_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::where('key', 'system_logo')->first();
            if ($oldLogo && $oldLogo->value) {
                Storage::disk('public')->delete($oldLogo->value);
            }

            // Store new logo
            $logoPath = $request->file('system_logo')->store('logos', 'public');
            Setting::set('system_logo', $logoPath, 'image', 'System Logo');
        }

        // Clear all settings cache
        Setting::clearCache();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'System settings updated successfully!');
    }

    /**
     * Update admin profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update admin password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);

        $user = Auth::user();

        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()
                ->route('admin.settings.index')
                ->with('error', 'Current password is incorrect!');
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Remove system logo
     */
    public function removeLogo()
    {
        $setting = Setting::where('key', 'system_logo')->first();

        if ($setting && $setting->value) {
            Storage::disk('public')->delete($setting->value);
            $setting->delete();
            Setting::clearCache();
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Logo removed successfully!');
    }
}
