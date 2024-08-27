<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn('image_path'); // Replace 'image_path' with the actual column name you want to drop
    });
}

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->string('image_path'); // Add this line if you want to rollback the migration
    });
}

};
