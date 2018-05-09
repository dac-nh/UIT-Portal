<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('role');
            $table->foreign('university_id')->references('id')->on('university');
        });

        Schema::table('student_profile', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('user');
        });

        Schema::table('cv', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('student_profile');
        });

        Schema::table('rating_student', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('user');
            $table->foreign('user_id')->references('id')->on('user');
        });
        Schema::table('student_skills', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('user');
            $table->foreign('skill_id')->references('id')->on('skill');
        });
        Schema::table('project_skills', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('skill_id')->references('id')->on('skill');
        });

        Schema::table('project', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('company');
        });
        Schema::table('project_university', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('university_id')->references('id')->on('university');
        });
        Schema::table('user_apply_project', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('student_id')->references('id')->on('user');
        });
        Schema::table('user_join_project', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('student_id')->references('id')->on('user');
        });
        Schema::table('user_manage_project', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('user_id')->references('id')->on('user');
        });
        Schema::table('company_user', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
