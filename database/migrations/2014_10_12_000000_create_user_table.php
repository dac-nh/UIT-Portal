<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 120);
            $table->string('email')->unique();
            $table->string('password', 60);
            // 11-18-2016: Dac: add avatar column
            $table->string('avatar')->default("");
            //Avatar dùng id của user luôn ko cần thêm cột
            $table->boolean('gender')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_superuser')->default(false);
            $table->unsignedSmallInteger('role_id')->default(5);
            $table->unsignedSmallInteger('university_id')->nullable(); // use for student and university
            // 10-1-2016: Dac: Google token and facebook token
            $table->string('google_id', 21)->default("");
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedSmallInteger('count_wrong')->default(0);
            $table->timestamp('log_in_timestamp')->default(date("Y-m-d H:i:s"));
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
        Schema::drop('user');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
