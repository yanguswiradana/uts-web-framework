<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['key' => 'app_name', 'value' => 'KOMIKIN'],
            ['key' => 'app_description', 'value' => 'Baca Komik Online Bahasa Indonesia Terupdate'],
            ['key' => 'app_logo', 'value' => null], // Nanti diupload via admin
            ['key' => 'footer_text', 'value' => '© 2026 Komikin Project'],
        ];

        foreach ($data as $d) {
            Setting::updateOrCreate(['key' => $d['key']], ['value' => $d['value']]);
        }
    }
}