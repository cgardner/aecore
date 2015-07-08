<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Fenos\Notifynder\Models\NotificationCategory as NotificationCategory;

class NotificationCategorySeeder extends Seeder {

    public function run()
    {
        $categories = [
            [
                'name' => 'tasks.assign',
                'text' => '{from.name} assigned you to a task.'
            ],
            [
                'name' => 'collaborators.add',
                'text' => '{from.name} added you to a project.'
            ],
        ];
        
        // Load categories into database
        foreach($categories as $category) {
            NotificationCategory::updateOrCreate(['name' => $category['name']], [
                'name' => $category['name'],
                'text' => $category['text']
            ]);
        }
    }
}