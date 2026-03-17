<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_values', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('blog_field_id');

            $table->longText('value')->nullable();
            $table->timestamps();

            $table->foreign('blog_id')
                ->references('id')
                ->on('blogs')
                ->cascadeOnDelete();

            $table->foreign('blog_field_id')
                ->references('id')
                ->on('blog_fields')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_values');
    }
};
