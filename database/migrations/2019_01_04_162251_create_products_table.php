<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            // Define Storage Engine & Charset & Collation
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->bigIncrements('id')
                ->comment('PK');

            $table->unsignedInteger('shop_idx')->length(10)
                ->comment('FK (shops)');

            $table->integer('product_no')
                ->comment('상품번호');
            $table->string('product_code', 10)
                ->comment('상품코드');

            $table->tinyInteger('is_display')
                ->comment('진열여부');

            $table->tinyInteger('is_selling')
                ->comment('판매여부');

            $table->string('eng_product_name', 255)
                ->comment('영문 상품명');

            $table->decimal('product_price', 16, 2)
                ->comment('상품가격');

            $table->softDeletes('deleted_at')
                ->comment('삭제일');

            $table->timestamp('updated_at')
                ->nullable()
                ->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))
                ->comment('최종 수정일');

            $table->timestamp('created_at')
                ->useCurrent()
                ->comment('최초 등록일');

            // Define Index
            $table->index(['deleted_at'], 'ixnn__products__deleted_at');
            $table->index(['created_at', 'updated_at'], 'ixnn__products__concat0');
            $table->unique(['shop_idx', 'product_no'], 'ixcu__products__concat1');
            $table->unique(['shop_idx', 'product_code'], 'ixcu__products__concat2');

            // Define Foreign Key
//            $table->foreign('shop_idx')->references('id')->on('shops');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('shop_idx')
                ->references('id')->on('shops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
