<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        \App\Role::create([
            'name'=> 'super_admin',
            'description'=> 'Administrator',
        ]);
        \App\Role::create([
            'name'=> 'student',
            'description'=> 'Student',
        ]);
        \App\Role::create([
            'name'=> 'parent',
            'description'=> 'Parent',
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
