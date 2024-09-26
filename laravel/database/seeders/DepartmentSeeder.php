<?php

namespace Database\Seeders;

use App\Models\Departments;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultDepartments = Departments::whereIn('name', Departments::GROUP_DEFAULT)->get();
        if (! $defaultDepartments->count() == count(Departments::GROUP_DEFAULT)) {
            DB::table("departments")->insert([
                ["name" => Departments::ADMIN],
                ["name" => Departments::USER],
                ["name" => Departments::STAFF],
            ]);            
        }
    }
}
