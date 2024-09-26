<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUserStatus = UserStatus::whereIn('name', UserStatus::GROUP_DEFAULT)->get();
        if (! $defaultUserStatus->count() == count(UserStatus::GROUP_DEFAULT)) {
            DB::table("user_status")->insert([
                ["name" =>  UserStatus::ACTIVE],
                ["name" =>  UserStatus::DEACTIVE],
            ]);
        }
    }
}
