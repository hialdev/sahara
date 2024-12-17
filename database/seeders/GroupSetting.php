<?php

namespace Database\Seeders;

use App\Models\GroupSetting as ModelsGroupSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GroupSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data group settings
        $groups = [
            ['id' => Str::uuid(), 'name' => 'Site'],
            ['id' => Str::uuid(), 'name' => 'Content']
        ];

        foreach ($groups as $group) {
            ModelsGroupSetting::create($group);
        }
    }
}
