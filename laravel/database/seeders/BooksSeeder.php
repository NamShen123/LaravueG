<?php

namespace Database\Seeders;

use App\Models\Books;
use App\Models\BookStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultBookStatus = BookStatus::whereIn('name', BookStatus::GROUP_DEFAULT)->get();
        $activeStatus = $defaultBookStatus->where('name', BookStatus::ACTIVE)->first();
        $deactiveStatus = $defaultBookStatus->where('name', BookStatus::DEACTIVE)->first();


        Books::factory()->setStatusId($activeStatus->id)->count(10)->create();
        Books::factory()->setStatusId($activeStatus->id)->setQuantity(0)->count(3)->create();

        Books::factory()->setStatusId($deactiveStatus->id)->count(2)->create();
        Books::factory()->setStatusId($deactiveStatus->id)->setQuantity(0)->count(2)->create();

    }
}
