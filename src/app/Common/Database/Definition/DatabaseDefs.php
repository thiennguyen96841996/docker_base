<?php
namespace App\Common\Database\Definition;

/**
 * データベースに関連した定義を持つクラス。
 * @package \App\Common\Database
 */
class DatabaseDefs
{
    /**
     * データベースの書き込み用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_WRITE = 'mysql_write';

    /**
     * データベースの読み込み専用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_READ = 'mysql_read';

    /**
     * データベースのマイグレーション専用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_MIGRATION = 'mysql_migration';

    /**
     * Redisのデフォルトで使用する接続の定義名
     * @var string
     */
    const CONNECTION_NAME_REDIS_DEFAULT = 'redis_default';

    /**
     * Redisのセッションに使用する接続の定義名
     * @var string
     */
    const CONNECTION_NAME_REDIS_SESSION = 'redis_session';

    /**
     * Redisのキャッシュに使用する接続の定義名
     * @var string
     */
    const CONNECTION_NAME_REDIS_CACHE = 'redis_cache';

    /**
     * Redisのキューに使用する接続の定義名
     * @var string
     */
    const CONNECTION_NAME_REDIS_QUEUE = 'redis_queue';

    /**
     * Redisのブロードキャスティングに使用する接続の定義名
     * @var string
     */
    const CONNECTION_NAME_REDIS_BROADCASTING = 'redis_broadcasting';

    /**
     * Redisのデフォルトで使用するテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_DEFAULT = 1;

    /**
     * Redisのセッションに使用するテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_SESSION = 2;

    /**
     * Redisのキャッシュに使用するテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_CACHE = 3;

    /**
     * Redisのキューに使用するテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_QUEUE = 4;

    /**
     * Redisのブロードキャストに使用するテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_BROADCASTING = 5;

    /**
     * 最初ID
     * @var int
     */
    const ID_START_POSITION = 10001;
}
