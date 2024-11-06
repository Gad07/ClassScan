<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('groups', function (Blueprint $table) {
        $table->dropColumn('subject'); // Elimina la columna 'subject'
    });
}

public function down()
{
    Schema::table('groups', function (Blueprint $table) {
        $table->string('subject')->nullable(); // Agrega la columna nuevamente si se hace un rollback
    });
}

};
