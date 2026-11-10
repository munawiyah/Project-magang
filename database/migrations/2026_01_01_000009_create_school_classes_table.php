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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // e.g. "X RPL 1", "XI MIPA 2"
            $table->unsignedTinyInteger('grade_level'); // 10, 11, 12 (or 7, 8, 9)
            $table->foreignId('major_id')->nullable()->constrained('majors')->nullOnDelete();
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->string('academic_year', 20)->default('2025/2026');
            $table->integer('capacity')->default(36);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['grade_level', 'academic_year', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_classes');
    }
};

