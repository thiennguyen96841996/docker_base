<?php
namespace GLC\Platform\Database\Definitions;

/**
 * テータベースに関連した定義を持つクラス。
 *
 * @package GLC\Platform\Database\Definitions
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class DatabaseDefs
{
    /**
     * 通常データベースの読み込み専用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_READ = 'mysql_read';

    /**
     * 通常データベースの書き込み用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_WRITE = 'mysql_write';

    /**
     * セキュアデータベースの読み込み専用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_READ_SECURE = 'mysql_read_sec';

    /**
     * セキュアデータベースの書き込み用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_WRITE_SECURE = 'mysql_write_sec';

    /**
     * 駅・路線データベースの読み込み用接続の定義名
     * @var string
     */
    const CONNECTION_NAME_READ_TRANSIT = 'mysql_read_transit';

    /**
     * Redisのデフォルトのテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_DEFAULT = 1;

    /**
     * Redisのセッションキャッシュのテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_SESSION = 2;

    /**
     * Redisのアプリケーションキャッシュのテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_CACHE = 3;

    /**
     * Redisのキュー管理のテーブル番号
     * @var int
     */
    const REDIS_DB_NUMBER_QUEUE = 4;
}