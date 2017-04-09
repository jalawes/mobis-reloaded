<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $user = User::create([
            'first_name' => 'Jamal',
            'last_name' => 'Alawes',
            'email' => 'jamal@jamal.com',
            'password' => bcrypt('jamal'),
            'bio' => 'Creator of The Mobis: Reloaded',

            'points' => 0,
            'wpm' => 102,
            'share_stats' => true,
        ]);

        $users = factory(App\User::class, 10)->create();
    }
}
