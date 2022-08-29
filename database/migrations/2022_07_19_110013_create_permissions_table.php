<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        $super_admin_role_id = 1;
        $student_role_id = 3;
        $parent_role_id = 2;
        $data = [
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'create_user',
                'description' => 'Can create user'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'view_user',
                'description' => 'Can view user'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'edit_user',
                'description' => 'Can edit user'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'delete_user',
                'description' => 'Can delete user'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'create_permission',
                'description' => 'Can create permission'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'view_permission',
                'description' => 'Can view permission'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'edit_permission',
                'description' => 'Can edit permission'

            ],[
                'role_id'=>$super_admin_role_id,
                'name' => 'delete_permission',
                'description' => 'Can delete permission'

            ],
        ];

        $parent = [
            [
                'role_id'=>$parent_role_id,
                'name' => 'view_user',
                'description' => 'Can view user'

            ],
            [
                'role_id'=>$super_admin_role_id,
                'name' => 'view_permission',
                'description' => 'Can view permission'

            ],
        ];
        $student = [
            [
                'role_id'=>$student_role_id,
                'name' => 'view_user',
                'description' => 'Can view user'

            ],
            [
                'role_id'=>$student_role_id,
                'name' => 'view_permission',
                'description' => 'Can view permission'

            ],
        ];


        \App\Permission::insert($data);
        \App\Permission::insert($parent);
        \App\Permission::insert($student);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
