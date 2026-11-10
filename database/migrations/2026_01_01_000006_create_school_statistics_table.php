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
        Schema::create('school_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // e.g., 'Siswa Aktif', 'Guru & Tendik', 'Ruang Kelas', 'Akreditasi'
            $table->string('value'); // e.g., '1,240', '82', '36', 'A'
            $table->string('icon')->nullable(); // Heroicon / FontAwesome name e.g. 'users', 'academic-cap', 'building-library'
            $table->string('color', 30)->default('blue'); // color accent e.g. 'emerald', 'blue', 'amber', 'purple'
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_statistics');
    }
};

