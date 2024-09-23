<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applications = [
            [
                'id' => Str::uuid(),
                'title' => 'SSO Sahara',
                'image' => 'sso_image.png',
                'icon' => 'shield-lock',  // Bootstrap Icon untuk SSO
                'use_icon' => 1,
                'description' => 'Single Sign-On for Sahara',
                'url' => 'http://sso.sahara.test',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Osano Sahara',
                'image' => 'osano_image.png',
                'icon' => 'person-badge',  // Bootstrap Icon untuk Osano
                'use_icon' => 1,
                'description' => 'Aplikasi Keuangan Project dan Accounting',
                'url' => 'http://osano.sahara.test',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Cloud Sahara',
                'image' => 'crm_image.png',
                'icon' => 'cloud-fill',  // Bootstrap Icon untuk CRM
                'use_icon' => 1,
                'description' => 'File Management berbasis internet',
                'url' => 'https://cloud.sahara.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Email',
                'image' => 'pm_image.png',
                'icon' => 'envelope',  // Bootstrap Icon untuk Project Management
                'use_icon' => 1,
                'description' => 'E Mail sahara dengan Yandex Mail',
                'url' => 'https://mail.sahara.co.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Mahika',
                'image' => 'hrm_image.png',
                'icon' => 'briefcase',  // Bootstrap Icon untuk HRM
                'use_icon' => 1,
                'description' => 'Human Resource Management System',
                'url' => 'http://mahika.sahara.test',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'title' => 'Support Sahara',
                'image' => 'support_image.png',
                'icon' => 'headset',  // Bootstrap Icon untuk Support
                'use_icon' => 1,
                'description' => 'Support and Ticketing System',
                'url' => 'http://support.sahara.test',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('applications')->insert($applications);
    }
}
