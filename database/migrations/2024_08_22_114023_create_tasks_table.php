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
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('description');
        $table->string('status');
        $table->string('image_path')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('image_path'); // yeh wahi column type hona chahiye jo pehle tha
        });
    }
};
