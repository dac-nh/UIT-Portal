<?php

use Illuminate\Database\Seeder;
use App\Models\Cv;

class CvTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cv::create([
            'name'=>'Web',
            'student_id'=>'1'
        ]);
        Cv::create([
            'name'=>'Design',
            'student_id'=>'1'
        ]);
        Cv::create([
            'name'=>'PHP',
            'student_id'=>'1'
        ]);
        Cv::create([
            'name'=>'HTML/CSS',
            'student_id'=>'2'
        ]);
        Cv::create([
            'name'=>'Laravel',
            'student_id'=>'2'
        ]);
        Cv::create([
            'name'=>'PHP',
            'student_id'=>'2'
        ]);
        Cv::create([
            'name'=>'Web',
            'student_id'=>'1'
        ]);
        Cv::create([
            'name'=>'C/C++',
            'student_id'=>'3'
        ]);
        Cv::create([
            'name'=>'C#',
            'student_id'=>'3'
        ]);

    }
}
