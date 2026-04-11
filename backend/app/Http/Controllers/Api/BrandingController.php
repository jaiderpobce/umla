<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BrandingController extends Controller
{
    public function show(): JsonResponse
    {
        $settings = AppSetting::query()
            ->whereIn('key', ['branding.institution_name', 'branding.subtitle', 'branding.brand_color', 'branding.logo_path'])
            ->pluck('value', 'key');

        return response()->json([
            'branding' => [
                'institution_name' => $settings->get('branding.institution_name', 'UMLA'),
                'subtitle' => $settings->get('branding.subtitle', 'Plataforma académica'),
                'brand_color' => $settings->get('branding.brand_color', '#d96c3f'),
                'logo_path' => $settings->get('branding.logo_path', ''),
            ],
        ]);
    }

    public function asset(string $fileName)
    {
        $safeFileName = basename($fileName);
        $relativePath = 'branding-assets/' . $safeFileName;

        if (!Storage::disk('public')->exists($relativePath)) {
            abort(404);
        }

        return response()->file(storage_path('app/public/' . $relativePath));
    }
}