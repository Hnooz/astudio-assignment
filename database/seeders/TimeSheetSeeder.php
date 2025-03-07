<?php

namespace Database\Seeders;

use App\Models\TimeSheet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimeSheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeSheet::factory(100)->create();
    }
}
