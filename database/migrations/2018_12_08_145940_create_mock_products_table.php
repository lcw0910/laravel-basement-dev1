<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMockProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('mock_products', function (Blueprint $table) {

            // Define Storage Engine & Charset & Collation
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            // Define Columns
            $table->bigIncrements('id')
                ->comment('PK');

            $table->string('product_name', 255)
                ->comment('상품명');

            $table->softDeletes('deleted_at')
                ->comment('삭제일');

            $table->timestamp('updated_at')
                ->nullable()
                ->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))
                ->comment('최종 수정일');

            $table->timestamp('created_at')
                ->useCurrent()
                ->comment('최초 등록일');

//            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mock_products');
    }
}
