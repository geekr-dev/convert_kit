<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Seeder;
use stdClass;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'email' => 'test@test.com',
        ]);

        Form::factory()->count(10)->create();
        Tag::factory()->count(100)->create();

        Subscriber::factory()->count(500)->create([
            'user_id' => 1
        ]);
        Broadcast::factory()->count(100)->create([
            'user_id' => 1,
        ]);
    }
}
