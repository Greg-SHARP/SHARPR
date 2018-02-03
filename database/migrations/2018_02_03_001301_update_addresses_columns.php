<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddressesColumns extends Migration
{
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function($table) {
            $table->string('name')
                ->default('')
                ->change();
            $table->string('country')
                ->default('')
                ->change();
            $table->float('latitude')
                ->nullable()
                ->change();
            $table->float('longitude')
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function($table) {
            $table->string('name')
                ->change();
            $table->string('country')
                ->change();
            $table->float('latitude')
                ->change();
            $table->float('longitude')
                ->change();
        });
    }
}
