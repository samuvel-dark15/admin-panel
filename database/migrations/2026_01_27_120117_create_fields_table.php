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
    Schema::create('fields', function (Blueprint $table) {
        $table->id();

        $table->string('name', 255);               // emp_name
        $table->string('label', 255);              // Employee Name
        $table->string('type', 50);                // text, number, select
        $table->integer('length')->nullable();     // 255
        $table->string('default_value')->nullable();
        $table->boolean('nullable')->default(0);   // 0 = required
        $table->string('placeholder')->nullable();
        $table->text('options')->nullable();       // Male,Female
        $table->integer('sort_order')->default(0);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
