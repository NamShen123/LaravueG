<?php

namespace Database\Seeders;

use App\Models\BookStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultBookStatus = BookStatus::whereIn('name', BookStatus::GROUP_DEFAULT)->get();
        if (! $defaultBookStatus->count() == count(BookStatus::GROUP_DEFAULT)) {
            DB::table("book_status")->insert([
                ["name" =>  BookStatus::ACTIVE],
                ["name" =>  BookStatus::DEACTIVE],
            ]);
        }
    }
}
