<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // GET /api/settings/{key}
    public function show(string $key)
    {
        $setting = Setting::find($key);
        return response()->json($setting ? $setting->value : null);
    }

    // PUT /api/settings/{key}
    public function update(Request $request, string $key)
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $request->all()]
        );
        return response()->json($setting->value);
    }
}
