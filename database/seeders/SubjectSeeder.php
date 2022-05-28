<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    
    public function run()
    {
        Subject::insert([
            [
                'subject_name' => 'engilsh'
            ],
            [
                'subject_name' => 'bangla'
            ]
        ]);
    }
}
