<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('ma_email')->nullable();
        });
        //        foreach(\App\Profile::all() as $profile){
        //            if ($profile->User() && !$profile->email){
        //                $profile->ma_email = $profile->user->email;
        //                $profile->save();
        //            }
        //        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('ma_email');
        });
    }
}
