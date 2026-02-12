<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            // 購入者
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // 購入された商品
            $table->foreignId('item_id')
            ->constrained()
            ->cascadeOnDelete()
            ->unique();

            // 購入時の価格
            $table->integer('price_at_purchase');
            // 配送先住所
            $table->foreignId('shipping_address_id')->constrained('addresses')->cascadeOnDelete();
            // 購入状態
            $table->string('status', 20);
            // 購入日時
            $table->dateTime('purchased_at');
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
        Schema::dropIfExists('purchases');
    }
}
