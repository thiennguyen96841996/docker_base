<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * customer_usersテーブルを作成するマイグレーションクラス。
 */
class CreateCustomerUsersTable extends Migration
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
                ->create('customer_users', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->integer('id')->autoIncrement()->startingValue(DatabaseDefs::ID_START_POSITION);
                    $table->string('email', 50)->unique();
                    $table->string('password', 100);
                    $table->binary('name');
                    $table->binary('tel');    //validate max string: 10
                    $table->binary('birthday')->nullable();  //datetime
                    $table->binary('gender')->nullable();  //char. 01: Nam, 02: Nu, 03: Other
                    $table->binary('avatar')->nullable();
                    $table->binary('address');
                    $table->timestamp('email_verified_at')->nullable();
                    $table->timestamp('last_login_at')->nullable();
                    $table->binary('status'); //char. 01: active, 02: inactive (default)
                    $table->rememberToken();
                    $table->timestamps();
                    $table->softDeletes();
                });

            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `customer_users` ROW_FORMAT=DYNAMIC;');
            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `customer_users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;');
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
            ->dropIfExists('customer_users');
    }
}
