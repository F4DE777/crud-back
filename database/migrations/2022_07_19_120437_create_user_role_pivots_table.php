<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolePivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        if (!Schema::hasTable('user_role_pivots')) {
            Schema::create('user_role_pivots', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('role_id');
                $table->integer('user_id');
                $table->string('role_name');
                $table->timestamps();
            });
        };

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_pivots');
    }
}
