<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserJoinProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_join_project', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('project_id');

            $table->unsignedInteger('student_id');

            $table->integer('start_at');
            $table->integer('end_at')->nullable();

            $table->text('body');
            $table->unsignedTinyInteger('rating');
            $table->boolean('has_extra_file');

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
        Schema::dropIfExists('user_join_project');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
