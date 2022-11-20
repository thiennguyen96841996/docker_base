<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * client_usersテーブルを作成するマイグレーションクラス。
 */
class CreateClientUsersTable extends Migration
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
                ->create('client_users', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->integer('id')->autoIncrement()->startingValue(DatabaseDefs::ID_START_POSITION);
                    $table->string('email', 50)->unique();
                    $table->string('password', 100);
                    $table->binary('name');
                    $table->binary('tel');    // validate max string: 10
                    $table->timestamp('email_verified_at')->nullable();
                    $table->timestamp('last_login_at')->nullable();
                    $table->integer('agency_id');
                    $table->char('status', 2)->default('02');  //01: active, 02:inactive
                    $table->integer('region_code');
                    $table->binary('hotline');   // validate max string: 10
                    $table->binary('avatar')->nullable();
                    $table->rememberToken();
                    $table->timestamps();
                    $table->softDeletes();
                });

            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `client_users` ROW_FORMAT=DYNAMIC;');
            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `client_users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;');
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
            ->dropIfExists('client_users');
    }
}
