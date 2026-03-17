<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // varchar, int, text, select, file
            $table->integer('length')->nullable();
            $table->string('default')->nullable();
            $table->boolean('nullable')->default(true);
            $table->boolean('ai')->default(false);
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->text('options')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
