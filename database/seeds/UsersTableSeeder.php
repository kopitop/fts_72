<?php

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
        //Seed Member
        factory(App\Models\User::class, 10)->create();

        //Seed Superadmin
        factory(App\Models\User::class)->states('admin')->create([
            'email' => 'nguyen.minh.hiep@framgia.com',
            'name' => 'Nguyen Minh Hiep',
        ]);
    }
}
