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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('image_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('category_id')
                ->constrained('categories')//引数でテーブル指定
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('sub_category_id')
                ->constrained('sub_categories')//引数でテーブル指定
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('brand_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('status', ['owned', 'cleaning', 'discarded']);//DB保存英語保存＋日本語幼児推奨（将来的な国際化(i18n))
            // $table->tinyInteger('is_public');
            $table->tinyInteger('is_item_suggest');
            $table->foreignId('main_material_id')->nullable()
                ->constrained('materials')//引数でテーブル指定
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('sub_material_id')->nullable()
                ->constrained('materials')//引数でテーブル指定
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('washability_option', ['washable_machine', 'washable_hand', 'not_washable'])->nullable();// 洗濯可能区分：machine=洗濯機OK, hand=手洗いOK, not=不可
            $table->date('purchased_date')->nullable();
            $table->integer('price')->unsigned()->nullable();
            $table->string('purchased_at')->nullable();
            $table->string('memo', 100)->nullable();//最大100文字に制限
            $table->decimal('total_length', 4, 1)->unsigned()->nullable();
            $table->decimal('kitake_length', 4, 1)->unsigned()->nullable();
            $table->decimal('neck_circumference', 4, 1)->unsigned()->nullable();
            $table->decimal('shoulder_width', 4, 1)->unsigned()->nullable();
            $table->decimal('yuki_length', 4, 1)->unsigned()->nullable();
            $table->decimal('sleeve_length', 4, 1)->unsigned()->nullable();
            $table->decimal('armpit_to_armpit_width', 4, 1)->unsigned()->nullable();
            $table->decimal('chest_circumference', 4, 1)->unsigned()->nullable();
            $table->decimal('waist', 4, 1)->unsigned()->nullable();
            $table->decimal('inseam', 4, 1)->unsigned()->nullable();
            $table->decimal('hip', 4, 1)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
