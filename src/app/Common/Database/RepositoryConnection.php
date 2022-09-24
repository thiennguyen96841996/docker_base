<?php
namespace App\Common\Database;

use Exception;
use Illuminate\Support\Arr;

/**
 * リポジトリからデータベースに接続する際のコネクションを設定するトレイト。
 * @package \App\Common\Database
 */
trait RepositoryConnection
{
    /**
     * 接続に使用する定義名。
     * @var string|null
     */
    protected ?string $connection = null;

    /**
     * 接続定義を設定する。
     * @param  string $connection
     * @return void
     * @throws \Exception
     */
    public function setConnection(string $connection): void
    {
        if (!Arr::exists(config('database.connections'), $connection)) {
            throw new Exception('Connection is not defined. [connection]:' . $connection);
        }
        $this->connection = $connection;
    }

    /**
     * 接続定義を取得する。
     * @param  string $default
     * @return string
     */
    public function getConnection(string $default): string
    {
        return !is_null($this->connection) ? $this->connection: $default;
    }
}
