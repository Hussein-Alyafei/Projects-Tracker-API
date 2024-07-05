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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('status', ['complete', 'in-progress', 'stopped', 'planned', 'on hold', 'cancelled']);
            $table->enum('year', ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh']);
            $table->enum('term', ['first', 'second']);
            $table->date('deadline');
            $table->string('gitHub_url')->nullable();
            $table->string('documentation');
            $table->longText('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
