<?php
use Illuminate\Support\Str;
use App\Common\Database\Definition\DatabaseDefs;

return [
    /*
    |--------------------------------------------------------------------------
    | 実行されたクエリをログに書き出すかどうか
    |--------------------------------------------------------------------------
    */
    'debug_query' => env('DB_DEBUG_QUERY'),

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
    'default' => env('DB_CONNECTION', DatabaseDefs::CONNECTION_NAME_READ),

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
        'sqlite' => [
            'driver'                  => 'sqlite',
            'url'                     => env('DATABASE_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],
        DatabaseDefs::CONNECTION_NAME_WRITE => [
            'driver'         => 'mysql',
            'url'            => env('DATABASE_URL'),
            'host'           => env('MYSQL_WRITE_DB_HOST'),
            'port'           => env('MYSQL_WRITE_DB_PORT'),
            'database'       => env('MYSQL_WRITE_DB_DATABASE'),
            'username'       => env('MYSQL_WRITE_DB_USERNAME'),
            'password'       => env('MYSQL_WRITE_DB_PASSWORD'),
            'unix_socket'    => env('MYSQL_WRITE_DB_SOCKET', ''),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        DatabaseDefs::CONNECTION_NAME_READ => [
            'driver'         => 'mysql',
            'url'            => env('DATABASE_URL'),
            'host'           => env('MYSQL_READ_DB_HOST'),
            'port'           => env('MYSQL_READ_DB_PORT'),
            'database'       => env('MYSQL_READ_DB_DATABASE'),
            'username'       => env('MYSQL_READ_DB_USERNAME'),
            'password'       => env('MYSQL_READ_DB_PASSWORD'),
            'unix_socket'    => env('MYSQL_READ_DB_SOCKET', ''),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
        DatabaseDefs::CONNECTION_NAME_MIGRATION => [
            'driver'         => 'mysql',
            'url'            => env('DATABASE_URL'),
            'host'           => env('MYSQL_MIGRATION_DB_HOST'),
            'port'           => env('MYSQL_MIGRATION_DB_PORT'),
            'database'       => env('MYSQL_MIGRATION_DB_DATABASE'),
            'username'       => env('MYSQL_MIGRATION_DB_USERNAME'),
            'password'       => env('MYSQL_MIGRATION_DB_PASSWORD'),
            'unix_socket'    => env('MYSQL_MIGRATION_DB_SOCKET', ''),
            'charset'        => 'utf8mb4',
            'collation'      => 'utf8mb4_bin',
            'prefix'         => '',
            'prefix_indexes' => true,
            'strict'         => true,
            'engine'         => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
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
    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix'  => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],
        DatabaseDefs::CONNECTION_NAME_REDIS_DEFAULT => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT'),
            'database' => DatabaseDefs::REDIS_DB_NUMBER_DEFAULT,
        ],
        DatabaseDefs::CONNECTION_NAME_REDIS_SESSION => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT'),
            'database' => DatabaseDefs::REDIS_DB_NUMBER_SESSION,
        ],
        DatabaseDefs::CONNECTION_NAME_REDIS_CACHE => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT'),
            'database' => DatabaseDefs::REDIS_DB_NUMBER_CACHE,
        ],
        DatabaseDefs::CONNECTION_NAME_REDIS_QUEUE => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT'),
            'database' => DatabaseDefs::REDIS_DB_NUMBER_QUEUE,
        ],
        DatabaseDefs::CONNECTION_NAME_REDIS_BROADCASTING => [
            'url'      => env('REDIS_URL'),
            'host'     => env('REDIS_HOST'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT'),
            'database' => DatabaseDefs::REDIS_DB_NUMBER_BROADCASTING,
        ],
    ],
];
