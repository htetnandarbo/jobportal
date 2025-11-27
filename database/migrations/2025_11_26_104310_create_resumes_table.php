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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('image');
            $table->string('name')->nullable();
            $table->string('title');
            $table->text('summary');
            $table->integer('experience_years')->nullable();
            $table->decimal('expected_salary', 15,2)->nullable();
            $table->enum('job_level', ['entry', 'junior', 'mid', 'senior', 'manager', 'director']);
            $table->enum('job_type', ['full-time', 'part-time', 'remote', 'internship', 'contract']);
            $table->string('location');
            $table->json('skills');
            $table->json('languages');
            $table->json('education');
            $table->json('certifications');
            $table->json('social');
            $table->enum('status', ['active', 'hidden'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('resumes');
        Schema::enableForeignKeyConstraints();
    }
};
