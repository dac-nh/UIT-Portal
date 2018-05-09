<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar')->default("");
            $table->string('name', 100)->default("");
            $table->unsignedSmallInteger('company_id');
            $table->unsignedSmallInteger('status')->default(0);
            $table->boolean('is_fulltime')->default(false);
            $table->string('address')->default("");
            $table->unsignedTinyInteger('length'); //weeks
            $table->unsignedTinyInteger('need_min')->default(0);
            $table->unsignedTinyInteger('need_max')->default(0);
            $table->integer('start_date');
            $table->text('intro');
            $table->text('requirement');
            $table->text('plus_point');
            $table->string('extra_file')->default("");
            $table->unsignedSmallInteger('num_of_applied')->default(0);
            $table->unsignedSmallInteger('num_of_joined')->default(0);
            $table->integer('publish_date')->default(0);
            $table->unsignedInteger('created_by_agent_id');
            $table->string('contact_email')->default("");
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
        Schema::dropIfExists('project');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
