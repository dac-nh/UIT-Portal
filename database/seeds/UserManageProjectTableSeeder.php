<?php

use Illuminate\Database\Seeder;
use App\UserManageProject;
class UserManageProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserManageProject::create([
            'user_id' => '4',
            'project_id' => '1'
        ]);
    }
}
