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
        Schema::create('coordinate_wearing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coordinate_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('worn_at')->nullable();
            $table->foreignId('weather_day_type_id')
                ->constrained('weather_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('weather_night_type_id')
                ->constrained('weather_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('min_temperature', 3, 1)->nullable();
            $table->decimal('max_temperature', 3, 1)->nullable();
            $table->foreignId('prefecture_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('memo', 100)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'worn_at']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coordinate_wearing_logs');
    }
};
