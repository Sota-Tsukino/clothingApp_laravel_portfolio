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
        Schema::create('fitting_tolerances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('body_part', ['yuki_length', 'neck_circumference', 'chest_circumference', 'waist', 'inseam', 'hip']);
            $table->enum('tolerance_level', ['just', 'slight', 'long_or_short']);
            $table->decimal('min_value', 3, 1);
            $table->decimal('max_value', 3, 1);
            $table->timestamps();
            // 複合ユニーク制約：ユーザー内で部位＋評価レベルの重複を禁止
            $table->unique(['user_id', 'body_part', 'tolerance_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitting_tolerances');
    }
};
