<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('font_family')->default('helvetica')->after('y_coord');
            $table->integer('font_size')->default(24)->after('font_family');
            $table->string('text_color')->default('#0d47a1')->after('font_size'); // Azul institucional por defecto
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['font_family', 'font_size', 'text_color']);
        });
    }
};