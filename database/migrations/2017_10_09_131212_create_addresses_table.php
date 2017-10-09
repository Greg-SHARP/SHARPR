<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('streetAddress');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('country');
            $table->float('latitude');
            $table->float('longitude');
            $table->integer('addressable_id')->unsigned();
            $table->string('addressable_type');
            $table->enum('type', ['primary', 'secondary', 'work']);
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
        Schema::dropIfExists('addresses');
    }
}
