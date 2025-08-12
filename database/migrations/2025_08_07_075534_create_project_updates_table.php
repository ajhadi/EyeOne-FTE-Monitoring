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
        Schema::create('project_updates', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('project_id')->constrained();
            $table->smallInteger('job_status');
            $table->smallInteger('problem_status');
            $table->text('problem_details');
            $table->integer('estimated_pull');
            $table->integer('actual_pull');
            $table->integer('estimated_tracing');
            $table->integer('actual_tracing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_updates');
    }
};
