<?php
use GLC\Platform\Database\Definitions\DatabaseDefs;
use Illuminate\Support\Str;

return [
    /*
    |--------------------------------------------------------------------------
    | Debugging executed query.
    |--------------------------------------------------------------------------
    */
    'debug' => env('DB_DEBUG_SQL'),

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */
    'default' => env('DB_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */
    'connections' => [
        // 通常データベース
        DatabaseDefs::CONNECTION_NAME_WRITE => [
            'driver'         => 'mysql',
            'url'            => env('MYSQL_WRITE_DATABASE_URL'),
            'host'           => env('MYSQL_WRITE_DATABASE_HOST'),
            'port'           => env('MYSQL_WRITE_DATABASE_PORT'),
            'database'       => env('MYSQL_DATABASE_NAME'),
            'username'       => env('MYSQL_WRITE_DATABASE_USERNAME'),
            'password'       => env('MYSQL_WRITE_DATABASE_PASSWORD'),
            'unix_socket'    => env('MYSQL_WRITE_DATABASE_SOCKET'),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => [
                PDO::ATTR_EMULATE_PREPARES => true,
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            ],
//            'options' => extension_loaded('pdo_mysql') ? array_filter([
//                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
//            ]): [],
        ],
        // 通常データベース (読み込み専用)
        DatabaseDefs::CONNECTION_NAME_READ => [
            'driver'         => 'mysql',
            'url'            => env('MYSQL_READ_DATABASE_URL'),
            'host'           => env('MYSQL_READ_DATABASE_HOST'),
            'port'           => env('MYSQL_READ_DATABASE_PORT'),
            'database'       => env('MYSQL_DATABASE_NAME'),
            'username'       => env('MYSQL_READ_DATABASE_USERNAME'),
            'password'       => env('MYSQL_READ_DATABASE_PASSWORD'),
            'unix_socket'    => env('MYSQL_READ_DATABASE_SOCKET'),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]): [],
        ],
        // セキュアデータベース
        DatabaseDefs::CONNECTION_NAME_WRITE_SECURE => [
            'driver'         => 'mysql',
            'url'            => env('MYSQL_WRITE_SECURE_DATABASE_URL'),
            'host'           => env('MYSQL_WRITE_SECURE_DATABASE_HOST'),
            'port'           => env('MYSQL_WRITE_SECURE_DATABASE_PORT'),
            'database'       => env('MYSQL_SECURE_DATABASE_NAME'),
            'username'       => env('MYSQL_WRITE_SECURE_DATABASE_USERNAME'),
            'password'       => env('MYSQL_WRITE_SECURE_DATABASE_PASSWORD'),
            'unix_socket'    => env('MYSQL_WRITE_SECURE_DATABASE_SOCKET'),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]): [],
        ],
        // セキュアデータベース (読み込み専用)
        DatabaseDefs::CONNECTION_NAME_READ_SECURE => [
            'driver'         => 'mysql',
            'url'            => env('MYSQL_READ_SECURE_DATABASE_URL'),
            'host'           => env('MYSQL_READ_SECURE_DATABASE_HOST'),
            'port'           => env('MYSQL_READ_SECURE_DATABASE_PORT'),
            'database'       => env('MYSQL_SECURE_DATABASE_NAME'),
            'username'       => env('MYSQL_READ_SECURE_DATABASE_USERNAME'),
            'password'       => env('MYSQL_READ_SECURE_DATABASE_PASSWORD'),
            'unix_socket'    => env('MYSQL_READ_SECURE_DATABASE_SOCKET'),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]): [],
        ],
        // 駅・路線データベース (読み込み専用)
        DatabaseDefs::CONNECTION_NAME_READ_TRANSIT => [
            'driver'         => 'mysql',
            'url'            => env('MYSQL_READ_TRANSIT_DATABASE_URL'),
            'host'           => env('MYSQL_READ_TRANSIT_DATABASE_HOST'),
            'port'           => env('MYSQL_READ_TRANSIT_DATABASE_PORT'),
            'database'       => env('MYSQL_TRANSIT_DATABASE_NAME'),
            'username'       => env('MYSQL_READ_TRANSIT_DATABASE_USERNAME'),
            'password'       => env('MYSQL_READ_TRANSIT_DATABASE_PASSWORD'),
            'unix_socket'    => env('MYSQL_READ_TRANSIT_DATABASE_SOCKET'),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]): [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */
    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */
//    'redis' => [
//        'client'  => env('REDIS_CLIENT'),
////        'options' => [
////            'cluster' => env('REDIS_CLUSTER'),
////            'prefix'  => env('REDIS_PREFIX'),
////        ],
//        'default' => [
////            'url'      => env('REDIS_URL'),
//            'host'     => env('REDIS_HOST'),
//            'password' => env('REDIS_PASSWORD'),
//            'port'     => env('REDIS_PORT'),
//            'database' => DatabaseDefs::REDIS_DB_NUMBER_DEFAULT,
//        ],
//        /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//         * For Session
//         * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//        'session' => [
//            'url'      => env('REDIS_URL'),
//            'host'     => env('REDIS_HOST'),
//            'password' => env('REDIS_PASSWORD'),
//            'port'     => env('REDIS_PORT'),
//            'database' => DatabaseDefs::REDIS_DB_NUMBER_SESSION,
//        ],
//        /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//         * For Application Cache
//         * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//        'cache' => [
//            'url'      => env('REDIS_URL'),
//            'host'     => env('DATA_CACHE_HOST'),
//            'password' => env('REDIS_PASSWORD'),
//            'port'     => env('REDIS_PORT'),
//            'database' => DatabaseDefs::REDIS_DB_NUMBER_CACHE,
//        ],
//        /* =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//         * For Queue
//         * =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//        'queue' => [
//            'url'      => env('REDIS_URL'),
//            'host'     => env('REDIS_HOST'),
//            'password' => env('REDIS_PASSWORD'),
//            'port'     => env('REDIS_PORT'),
//            'database' => DatabaseDefs::REDIS_DB_NUMBER_QUEUE,
//        ],
//    ],
    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],
];