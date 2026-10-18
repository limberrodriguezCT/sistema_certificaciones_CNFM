<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->enum('document_type', ['certificacion', 'reconocimiento', 'participacion']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('template_path')->nullable();
            $table->float('x_coord')->nullable();
            $table->float('y_coord')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};