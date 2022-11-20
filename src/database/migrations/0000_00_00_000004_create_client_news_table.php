<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * client_newsテーブルを作成するマイグレーションクラス。
 */
class CreateClientNewsTable extends Migration
{
    /**
     * マイグレーションを実行する。
     * @return void
     * @throws Exception
     */
    public function up(): void
    {
        try {
            Schema::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->create('client_news', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->integer('id')->autoIncrement()->startingValue(DatabaseDefs::ID_START_POSITION);
                    $table->integer('client_id');
                    $table->string('title', 150);
                    $table->char('status', 2)->default('02');    //01: public, 02: private
                    $table->string('avatar', 50);
                    $table->longText('content');
                    $table->timestamps();
                    $table->softDeletes();
                });

            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `client_news` ROW_FORMAT=DYNAMIC;');
            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `client_news` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;');
        } catch (PDOException $e) {
            $this->down();
            throw $e;
        }
    }

    /**
     * マイグレーションをロールバックする。
     * @return void
     */
    public function down(): void
    {
        Schema::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
            ->dropIfExists('client_news');
    }
}
