<?php

use Illuminate\Database\Seeder;
use App\Models\Skill;
class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Skill::create([
            'name' => 'Python'
        ]);
        Skill::create([
            'name' => 'C++'
        ]);
        Skill::create([
            'name' => 'C#'
        ]);
        Skill::create([
            'name' => 'Java'
        ]);
        Skill::create([
            'name' => 'ASP.NET'
        ]);
        Skill::create([
            'name' => 'Ruby'
        ]);
        Skill::create([
            'name' => 'SQL'
        ]);
        Skill::create([
            'name' => 'OOP'
        ]);
        Skill::create([
            'name' => 'Javascript'
        ]);
    }
}
