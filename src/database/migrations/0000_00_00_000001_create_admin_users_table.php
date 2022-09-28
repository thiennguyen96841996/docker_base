<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Common\Database\Definition\DatabaseDefs;

/**
 * admin_usersテーブルを作成するマイグレーションクラス。
 */
class CreateAdminUsersTable extends Migration
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
                ->create('admin_users', function (Blueprint $table) {
                    $table->engine = 'InnoDB';
                    $table->integer('id')->autoIncrement()->startingValue(DatabaseDefs::ID_START_POSITION);
                    $table->binary('name');
                    $table->string('email', 50);
                    $table->binary('tel');
                    $table->binary('avatar')->nullable();
                    $table->string('password', 100);
                    $table->rememberToken();
                    $table->char('is_available', 2);
                    $table->timestamp('email_verified_at')->nullable();
                    $table->timestamp('last_login_at')->nullable();
                    $table->timestamps();
                    $table->softDeletes();
                });

            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `admin_users` ROW_FORMAT=DYNAMIC;');
            DB::connection(DatabaseDefs::CONNECTION_NAME_MIGRATION)
                ->statement('ALTER TABLE `admin_users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;');
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
            ->dropIfExists('admin_users');
    }
}
