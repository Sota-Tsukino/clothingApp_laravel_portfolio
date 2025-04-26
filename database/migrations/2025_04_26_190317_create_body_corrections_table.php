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
        Schema::create('body_corrections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('head_circumference', 2, 1)->default(2.0)->unsigned()->nullable();
            $table->decimal('neck_circumference', 2, 1)->default(2.0)->unsigned()->nullable();
            $table->decimal('shoulder_width', 2, 1)->default(2.0)->unsigned()->nullable();
            $table->decimal('chest_circumference', 2, 1)->default(3.0)->unsigned()->nullable();
            $table->decimal('waist', 2, 1)->default(2.0)->unsigned()->nullable();
            $table->decimal('hip', 2, 1)->default(2.0)->unsigned()->nullable();
            $table->decimal('sleeve_length', 2, 1)->default(0.0)->unsigned()->nullable();
            $table->decimal('yuki_length', 2, 1)->default(0.0)->unsigned()->nullable();
            $table->decimal('inseam', 2, 1)->default(0.0)->unsigned()->nullable();
            $table->decimal('foot_length', 2, 1)->default(1.0)->unsigned()->nullable();
            $table->decimal('foot_circumference', 2, 1)->default(0.0)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_corrections');
    }
};
