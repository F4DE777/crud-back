<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = \App\User::where(['email'=> 'super-admin@yahoo.com'])->get();
        $users = \App\User::where('email','!=','super-admin@yahoo.com')->orderBy('id', 'asc')->limit(1000001)->get();
        $users_pr = \App\User::where('email','!=','super-admin@yahoo.com')->orderBy('id', 'asc')->offset(1000002)->limit(999998)->get();
        $super_admin_role = \App\Role::where(['name'=>'super_admin'])->first();
        $student_role = \App\Role::where(['name'=>'student'])->first();
        $parent_role = \App\Role::where(['name'=>'parent'])->first();

        foreach ($user as $u){
            \App\UserRolePivot::create([
                'role_id'=>$super_admin_role->id,
                'user_id'=>$u->id,
                'role_name'=>$super_admin_role->description,
            ]);
        }

        foreach ($users as $user){
            \App\UserRolePivot::create([
                'role_id'=>$student_role->id,
                'user_id'=>$user->id,
                'role_name'=>$student_role->description,
            ]);
        }
        foreach ($users_pr as $user){
            \App\UserRolePivot::create([
                'role_id'=>$parent_role->id,
                'user_id'=>$user->id,
                'role_name'=>$parent_role->description,
            ]);
        }
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
