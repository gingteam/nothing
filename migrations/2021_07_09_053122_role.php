<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

class Role extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema()->create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        $this->runSeed();
    }

    public function runSeed()
    {
        Capsule::table('roles')->insert(['name' => 'user']);
        Capsule::table('roles')->insert(['name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Capsule::schema()->dropIfExists('roles');
    }
}
