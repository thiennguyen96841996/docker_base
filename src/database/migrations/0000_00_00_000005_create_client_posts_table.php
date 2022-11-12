<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * client_postsテーブルを作成するマイグレーションクラス。
 */
class CreateClientPostsTable extends Migration
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
                ->create('client_posts', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->integer('id')->autoIncrement()->startingValue(DatabaseDefs::ID_START_POSITION);
                    $table->integer('client_id');
                    $table->string('title', 150);
                    $table->char('status', 2)->nullable();
                    $table->string('avatar', 50)->nullable();
                    $table->string('content', 5000)->nullable();
                    $table->string('city', 25)->nullable();
                    $table->string('district', 20)->nullable();
                    $table->string('address', 100)->nullable();
                    $table->unsignedDouble('price')->nullable();
                    $table->unsignedDouble('area')->nullable();
                    $table->unsignedBigInteger('view_counts')->nullable();
                    $table->string('closed_at', 20)->nullable();
                    $table->string('published_at', 20)->nullable();
                    $table->timestamps();
                    $table->softDeletes();
                });

            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `client_posts` ROW_FORMAT=DYNAMIC;');
            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `client_posts` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;');
        }
        catch (PDOException $e) {
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
            ->dropIfExists('client_posts');
    }
}
