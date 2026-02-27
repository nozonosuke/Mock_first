<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            /** 出品者 */
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            /**商品名 */
            $table->string('name');
            /**ブランド名（任意） */
            $table->string('brand_name')->nullable();
            /** 商品説明 */
            $table->text('description');
            /**価格 */
            $table->integer('price');
            /**画像URL（任意） */
            $table->string('image_url')->nullable();
            /**商品状態 */
            $table->string('condition', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
