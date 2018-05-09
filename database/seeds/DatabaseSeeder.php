<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UniversityTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(StudentProfileTableSeeder::class);
        $this->call(UserApplyProjectTableSeeder::class);
        $this->call(CvTableSeeder::class);
        $this->call(SkillTableSeeder::class);
    }
}
