<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create([
             'id'        => 1,
             'user_type' => User::SUPER_ADMIN
         ]);

         $users = User::factory(20)->create(['user_type' => User::USER]);

         Activity::factory(20)
             ->create(['is_global' => true])
             ->each(function ($activity) use ($users) {
                 $users->each(function ($user) use ($activity) {
                     Revision::factory()->create([
                         'user_id'     => $user->id,
                         'activity_id' => $activity->id,
                         'title'       => $activity->title,
                         'description' => $activity->description,
                         'image'       => $activity->image
                     ]);
                 });
             });

    }
}
