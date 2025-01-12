<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscription::create([
            'name' => 'Basic',
            'description' => 'Basic sub for users',
            'Price' => 100
        ]);
        Subscription::create([
            'name' => 'Advanced',
            'description' => 'Advanced sub for users',
            'Price' => 199
        ]);
        Subscription::create([
            'name' => 'Full',
            'description' => 'Full sub for users',
            'Price' => 299
        ]);
    }
}
