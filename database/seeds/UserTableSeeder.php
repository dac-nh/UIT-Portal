<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Huỳnh Hữu Nghĩa',
            'email' => 'huynh_huunghia77@yahoo.com',
            'password' => bcrypt('huunghia'),
            'gender' => '0',
            'role_id' => '2',
            'university_id' => '2',
        ]);
        User::create([
            'name' => 'Nguyễn Hữu Danh',
            'email' => 'huyentk1296@gmail.com',
            'password' => bcrypt('huudanh'),
            'gender' => '0',
            'role_id' => '5',
            'university_id' => '1'
        ]);
        User::create([
            'name' => 'Nguyễn Hữu Đắc',
            'email' => 'dachuu25@gmail.com',
            'password' => bcrypt('huudac'),
            'gender' => '0',
            'role_id' => '5',
            'university_id' => '1'
        ]);
        User::create([
            'name' => 'Trần Khánh Huyền',
            'email' => '14520393@gm.uit.edu.vn',
            'password' => bcrypt('khanhhuyen'),
            'gender' => '1',
            'role_id' => '3',
            'university_id' => '1'
        ]);
        User::create([
            'name' => 'Nguyễn Văn Thành',
            'email' => 'thanh@gmail.com',
            'password' => bcrypt('vanthanh'),
            'gender' => '0',
            'role_id' => '4'
        ]);
    }
}
