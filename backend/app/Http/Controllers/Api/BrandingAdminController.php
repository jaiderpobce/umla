<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Services\RbacService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandingAdminController extends Controller
{
    protected $rbacService;

    public function __construct(RbacService $rbacService)
    {
        $this->rbacService = $rbacService;
    }

    public function show(Request $request): JsonResponse
    {
        if (!$this->canManageBranding($request)) {
            return response()->json(['message' => 'No tienes permisos para gestionar la configuración institucional.'], 403);
        }

        return response()->json([
            'branding' => $this->brandingPayload(),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        if (!$this->canManageBranding($request)) {
            return response()->json(['message' => 'No tienes permisos para gestionar la configuración institucional.'], 403);
        }

        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'brand_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048'],
            'remove_logo' => ['nullable', 'boolean'],
        ]);

        $logoPath = AppSetting::query()->where('key', 'branding.logo_path')->value('value') ?: '';

        if ($request->boolean('remove_logo')) {
            $this->deleteManagedLogo($logoPath);
            $logoPath = '';
        }

        if ($request->hasFile('logo')) {
            $this->deleteManagedLogo($logoPath);
            $extension = strtolower($request->file('logo')->getClientOriginalExtension() ?: 'png');
            $fileName = 'institution-logo-' . Str::uuid() . '.' . $extension;
            $storedPath = $request->file('logo')->storeAs('branding-assets', $fileName, 'public');
            $logoPath = '/umla-api/branding-assets/' . basename($storedPath);
        }

        $this->storeSetting('branding.institution_name', $validated['institution_name']);
        $this->storeSetting('branding.subtitle', $validated['subtitle'] ?? '');
        $this->storeSetting('branding.brand_color', $validated['brand_color'] ?? '#d96c3f');
        $this->storeSetting('branding.logo_path', $logoPath);

        return response()->json([
            'message' => 'Configuración institucional actualizada.',
            'branding' => $this->brandingPayload(),
        ]);
    }

    protected function brandingPayload(): array
    {
        $settings = AppSetting::query()
            ->whereIn('key', ['branding.institution_name', 'branding.subtitle', 'branding.brand_color', 'branding.logo_path'])
            ->pluck('value', 'key');

        return [
            'institution_name' => $settings->get('branding.institution_name', 'UMLA'),
            'subtitle' => $settings->get('branding.subtitle', 'Plataforma académica'),
            'brand_color' => $settings->get('branding.brand_color', '#d96c3f'),
            'logo_path' => $settings->get('branding.logo_path', ''),
        ];
    }

    protected function storeSetting(string $key, ?string $value): void
    {
        AppSetting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    protected function canManageBranding(Request $request): bool
    {
        $payload = $this->rbacService->moduleViewFor($request->user(), 'institucion', 'branding');

        return $payload && in_array('edit', $payload['view']['permissions'], true);
    }

    protected function deleteManagedLogo(?string $logoPath): void
    {
        if (!$logoPath || strpos($logoPath, '/umla-api/branding-assets/') !== 0) {
            return;
        }

        $fileName = basename($logoPath);

        if ($fileName !== '') {
            Storage::disk('public')->delete('branding-assets/' . $fileName);
        }
    }
}