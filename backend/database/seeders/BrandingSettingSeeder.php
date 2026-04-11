<?php

namespace Database\Seeders;

use App\Models\AppSetting;
use Illuminate\Database\Seeder;

class BrandingSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'branding.institution_name' => 'UMLA',
            'branding.subtitle' => 'Plataforma académica',
            'branding.brand_color' => '#d96c3f',
            'branding.logo_path' => '',
        ];

        foreach ($settings as $key => $value) {
            AppSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}