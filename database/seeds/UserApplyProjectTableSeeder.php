<?php

use Illuminate\Database\Seeder;
use App\Models\UserApplyProject;
class UserApplyProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserApplyProject::create([
            'project_id' => '4',
            'student_id' => '1',
            'student_name' => 'Huỳnh Hữu Nghĩa',
            'student_rating' => '1',
            'result' => '10',
            'cv_id' => '1'
        ]);
        UserApplyProject::create([
            'project_id' => '4',
            'student_id' => '2',
            'student_name' => 'Nguyễn Hữu Danh',
            'student_rating' => '4',
            'result' => '10',
            'cv_id' => '2'
        ]);

    }
}
