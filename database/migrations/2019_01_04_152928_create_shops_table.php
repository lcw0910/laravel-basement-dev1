<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            // Define Storage Engine & Charset & Collation
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id')->comment('PK');

            $table->string('mall_id', 30)
                ->comment('상점ID');

            $table->tinyInteger('shop_no', false, true)
                ->comment('상점번호');

            $table->tinyInteger('is_default')
                ->comment('기본몰 여부');

            $table->char('locale', 5)
                ->comment('언어권');

            $table->string('locale_name', 10)
                ->comment('언어권명');

            $table->char('currency', 3)
                ->comment('통화');

            $table->string('currency_name', 25)
                ->comment('통화명');

            $table->char('sub_currency', 3)->nullable()
                ->comment('(Sub)통화');

            $table->string('sub_currency_name', 25)->nullable()
                ->comment('(Sub)통화명');

            $table->integer('timezone')
                ->nullable()
                ->comment('타임존');

            $table->integer('default_skin_no')
                ->comment('기본스킨번호');

            $table->integer('default_mobile_skin_no')
                ->comment('모바일 기본스킨번호');

            $table->tinyInteger('is_active')
                ->comment('상점 활성화 여부');

//            $table->timestamps();

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
            $table->unique(['mall_id', 'shop_no'], 'ixnu__shops__concat1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
