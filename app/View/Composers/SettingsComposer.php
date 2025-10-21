<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('appSettings', [
            'name' => Setting::systemName(),
            'logo' => Setting::logo(),
            'currency' => Setting::currency(),
            'currency_symbol' => Setting::currencySymbol(),
            'email' => Setting::email(),
            'phone' => Setting::phone(),
            'address' => Setting::address(),
            'tagline' => Setting::tagline(),
            'tax_rate' => Setting::taxRate(),
            'tax_enabled' => Setting::taxEnabled(),
        ]);
    }
}
