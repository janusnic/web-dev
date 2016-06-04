<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('role', 60)->default('author')->after('password');
            
            $table->boolean('active')->default(0)->after('role');
        });

        $user = new \App\User();
        $user->name = 'janus';
        $user->email = 'janus@example.com';
        $user->password = 'ghbdtn';
        $user->role = 'admin';
        $user->active = '1';
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('role'); 
            $table->dropColumn('active'); 
        });
    }
}
