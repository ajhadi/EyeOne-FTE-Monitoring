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
            $table->string('pa_number');
            $table->string('contract_number');
            $table->string('customer_name');
            $table->string('customer_address')->nullable();
            $table->string('ptl');
            $table->date('disposition_date');
            $table->date('target_date');
            $table->smallInteger('duration');
            $table->smallInteger('type');
            $table->foreignId('vendor_id')->constrained();
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
