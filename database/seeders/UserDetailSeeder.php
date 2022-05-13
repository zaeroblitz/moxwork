<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_details = [
            [
                'users_id'          => 1,
                'photo'             => '',
                'role'              => 'Website Developer',
                'contact_number'    => '',
                'biography'         => '',
                'created_at'        => date('Y-m-d h:i:s'),
                'updated_at'        => date('Y-m-d h:i:s'),
            ],
            [
                'users_id'          => 2,
                'photo'             => '',
                'role'              => 'UI Designer',
                'contact_number'    => '',
                'biography'         => '',
                'created_at'        => date('Y-m-d h:i:s'),
                'updated_at'        => date('Y-m-d h:i:s'),
            ],
        ];

        UserDetail::insert($user_details);
    }
}