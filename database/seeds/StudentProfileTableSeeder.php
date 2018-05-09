<?php

use Illuminate\Database\Seeder;
use App\Models\StudentProfile;

class StudentProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentProfile::create([
            'id' => 1,
            'full_name' => 'Huỳnh Hữu Nghĩa',
            'birthday' => '1995-07-15',
            'rating' => '0',
            'university_name' => 'Đại học Khoa học Tự nhiên',
            'faculty_name' => 'Information Technology',
            'major_name' => 'Software Programing',
            'academic_year' => '2013',
            'gpa' => '8',
            'intro' => 'good at coding',
            'address' => '41 ThânNhân Trung, P.13, Q.Tân Bình, 32/5 Ngô Bệ, P.13, Q. Tân Bình',
            'phone' => '01228718705',
            'skype_id' => 'ff7huunghia2',
            'total_rate' => '0',
            'num_rate' => '0'
        ]);
        StudentProfile::create([
            'id' => 2,
            'full_name' => 'Nguyễn Hữu Danh',
            'birthday' => '1996-02-14',
            'rating' => '0',
            'university_name' => 'Đại học Công nghệ thông tin',
            'faculty_name' => 'Information Technology',
            'major_name' => 'Software Programing',
            'academic_year' => '2014',
            'gpa' => '8',
            'intro' => 'good at coding',
            'address' => '16/16, Kỳ Đồng, Phường 9, Quận 3.',
            'phone' => '01228718705',
            'skype_id' => 'ff7huunghia2',
            'total_rate' => '0',
            'num_rate' => '0'
        ]);
        StudentProfile::create([
            'id' => 3,
            'full_name' => 'Nguyễn Hữu Đắc',
            'birthday' => '1996-02-14',
            'rating' => '0',
            'university_name' => 'Đại học Công nghệ thông tin',
            'faculty_name' => 'Information Technology',
            'major_name' => 'Software Programing',
            'academic_year' => '2014',
            'gpa' => '8',
            'intro' => 'good at coding',
            'address' => '16/16, Kỳ Đồng, Phường 9, Quận 3.',
            'phone' => '01228718705',
            'skype_id' => 'ff7huunghia2',
            'total_rate' => '0',
            'num_rate' => '0'
        ]);
    }
}
