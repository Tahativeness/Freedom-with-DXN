<?php

namespace App\Http\Controllers;

use App\Models\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    // GET /api/site-settings
    public function show()
    {
        return response()->json(SiteSettings::global());
    }

    // PUT /api/site-settings (admin)
    public function update(Request $request)
    {
        $settings = SiteSettings::global();
        $settings->update($request->all());
        return response()->json($settings->fresh());
    }
}
