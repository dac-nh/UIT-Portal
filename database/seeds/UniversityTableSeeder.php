<?php

use Illuminate\Database\Seeder;
use App\Models\University;
class UniversityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        University::create([
            'name'=>'Đại học Công nghệ thông tin',
            'url'=>'uit',
            'address'=>'25 Hai bà Trưng - P.Bến Nghé - Q.1.'
        ]);
        University::create([
            'name'=>'Đại học Khoa học Tự nhiên',
            'url'=>'khtn',
            'address'=>'90A Lý Thường Kiệt P.14, Quận 10.'
        ]);
    }
}
