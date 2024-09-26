<?php

namespace Database\Seeders;

use App\Models\Departments;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultDepartments = Departments::whereIn('name', Departments::GROUP_DEFAULT)->get();
        $defaultUserStatus = UserStatus::whereIn('name', UserStatus::GROUP_DEFAULT)->get();

        $adminRole = $defaultDepartments->where('name', Departments::ADMIN)->first();
        $staffRole = $defaultDepartments->where('name', Departments::STAFF)->first();
        $userRole = $defaultDepartments->where('name', Departments::USER)->first();

        $activeStatus = $defaultUserStatus->where('name', UserStatus::ACTIVE)->first();
        $deactiveStatus = $defaultUserStatus->where('name', UserStatus::DEACTIVE)->first();

        $adminUser = User::where('username', User::DEFAULT_ADMIN)->first();
        if (!$adminUser) {
            DB::table("users")->insert([
                "username" => "admin",
                "name" => "admin",
                "email" => "admin@adminer.com",
                "password" => Hash::make(User::DEFAULT_PASSWORD),
                "departments_id" => $adminRole->id,
                "status_id" => $activeStatus->id
            ]);
        }

        User::factory()->setStatusId($activeStatus->id)->setDepartmentId($staffRole->id)->count(5)->create();
        User::factory()->setStatusId($deactiveStatus->id)->setDepartmentId($staffRole->id)->count(1)->create();
        User::factory()->setStatusId($activeStatus->id)->setDepartmentId($userRole->id)->count(10)->create();
        User::factory()->setStatusId($deactiveStatus->id)->setDepartmentId($userRole->id)->count(2)->create();

    }
}
