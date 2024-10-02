<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
   /**
     * Run the migrations.
    */
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('unit_number', 255)->unique(); // Unique unit_number
            $table->integer('year'); // Column for year
            $table->text('notes')->nullable(); // Column for notes, optional
            $table->timestamps(); // Timestamps for created_at and updated_at
        });

        // Add a check constraint for the year column
        DB::statement('ALTER TABLE trucks ADD CONSTRAINT chk_year CHECK (year >= 1900 AND year <= ' . (date('Y') + 5) . ')');
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
