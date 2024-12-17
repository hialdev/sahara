<?php

namespace Database\Seeders;

use App\Models\GroupSetting;
use App\Models\Setting as ModelsSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class Setting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get GroupSetting ids
        $siteGroup = GroupSetting::where('name', 'Site')->first();
        $contentGroup = GroupSetting::where('name', 'Content')->first();

        // Insert dummy settings for both groups
        $settings = [
            // Settings under 'Site' group
            [
                'id' => Str::uuid(),
                'name' => 'Site Logo',
                'description' => 'Logo for the website',
                'the_key' => 'site_logo',
                'type_form' => 'image',
                'the_value' => '',
                'group_id' => $siteGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Site Title',
                'description' => 'The title of the website',
                'the_key' => 'site_title',
                'type_form' => 'text',
                'the_value' => 'My Awesome Site',
                'group_id' => $siteGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Site Description',
                'description' => 'Description of the website',
                'the_key' => 'site_description',
                'type_form' => 'textarea',
                'the_value' => 'This is a sample site description.',
                'group_id' => $siteGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Maintenance Mode',
                'description' => 'Enable or disable site maintenance mode',
                'the_key' => 'maintenance_mode',
                'type_form' => 'checkbox',
                'the_value' => '0', // 0 for disabled, 1 for enabled
                'group_id' => $siteGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'File Input',
                'description' => 'Testing for file input',
                'the_key' => 'compro',
                'type_form' => 'file',
                'the_value' => '', // 0 for disabled, 1 for enabled
                'group_id' => $siteGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Multiple Dropdown Input',
                'description' => 'Testing for Multiple Dropdown input',
                'the_key' => 'branch_priority',
                'type_form' => 'multiple_dropdown',
                'the_value' => '', // 0 for disabled, 1 for enabled
                'options' => json_encode(['Depok', 'Denpasar', 'Jakarta', 'Aceh']),
                'group_id' => $siteGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Dropdown Input',
                'description' => 'Testing for Dropdown input',
                'the_key' => 'main_office',
                'type_form' => 'dropdown',
                'the_value' => '', // 0 for disabled, 1 for enabled
                'options' => json_encode(['Depok', 'Denpasar', 'Jakarta', 'Aceh']),
                'group_id' => $siteGroup->id
            ],

            // Settings under 'Content' group
            [
                'id' => Str::uuid(),
                'name' => 'Homepage Banner Image',
                'description' => 'Banner image displayed on the homepage',
                'the_key' => 'homepage_banner_image',
                'type_form' => 'image',
                'the_value' => '',
                'group_id' => $contentGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Max Number of Articles',
                'description' => 'Maximum number of articles to display on the homepage',
                'the_key' => 'max_articles',
                'type_form' => 'number',
                'the_value' => '10',
                'group_id' => $contentGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Currency Format',
                'description' => 'Currency format for displaying prices',
                'the_key' => 'currency_format',
                'type_form' => 'currency',
                'the_value' => '24000',
                'group_id' => $contentGroup->id
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Content Categories',
                'description' => 'Categories for organizing content',
                'the_key' => 'content_categories',
                'type_form' => 'multiple_dropdown',
                'the_value' => json_encode(['News', 'Events', 'Blog']),
                'options' => json_encode(['News', 'Events', 'Blog', 'Contact', 'About']),
                'group_id' => $contentGroup->id
            ]
        ];

        foreach ($settings as $setting) {
            ModelsSetting::create($setting);
        }
    }
}
