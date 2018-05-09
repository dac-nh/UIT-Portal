<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_profile', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->primary('id');
            $table->string('full_name');
            $table->date('birthday')->default(date("Y-m-d H:i:s"));
            $table->unsignedTinyInteger('rating')->default(0);  // denormalization - use for student
            $table->string('university_name')->default('');
            $table->string('faculty_name')->default('');
            $table->string('major_name')->default('');
            $table->smallInteger('academic_year')->default(2016);
            $table->unsignedTinyInteger('gpa')->default(0);

            $table->text('intro');

            $table->string('address',255)->default('');
            $table->string('intro')->default('');
            $table->string('address', 255)->default('');
            $table->char('phone', 20)->default('');
            $table->string('skype_id')->default('');
            $table->unsignedInteger('total_rate')->default(0);
            $table->unsignedInteger('num_rate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('student_profile');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
