<?php
use GLC\Platform\Log\Formatters\BasicFormatter;
use GLC\Platform\Log\Formatters\SqlFormatter;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */
    'default' => env('LOG_CHANNEL'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */
    'channels' => [
        'stack' => [
            'driver'            => 'stack',
            'channels'          => [ 'basic' ],
            'ignore_exceptions' => false,
        ],
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        // 基本チャンネル
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        'basic' => [
            'driver' => 'daily',
            'days'   => 28,
            'path'   => storage_path('logs/laravel.log'),
            'level'  => 'info',
            'tap'    => [ BasicFormatter::class ]
        ],
        'statistic' => [
            'driver' => 'daily',
            'days'   => 7,
            'path'   => storage_path('logs/statistic.log'),
            'level'  => 'info',
            'tap'    => [ BasicFormatter::class ]
        ],
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        // 実行されたSQLを出力するチャンネル
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        'sql' => [
            'driver' => 'daily',
            'days'   => 3,
            'path'   => storage_path('logs/sql.log'),
            'level'  => 'info',
            'tap'    => [ SqlFormatter::class ]
        ],
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        // APIアクセスリクエストログ出力チャンネル
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        'apiAccessRequest' => [
            'driver' => 'daily',
            'days'   => 14,
            'path'   => storage_path('logs/api_access_request.log'),
            'level'  => 'info',
            'tap'    => [ BasicFormatter::class ]
        ],
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        // エラーに適応するチャンネル
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        'error' => [
            'driver' => 'daily',
            'days'   => 28,
            'path'   => storage_path('logs/error.log'),
            'level'  => 'error',
            'tap'    => [ BasicFormatter::class ]
        ],
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        // 緊急で対応が必要なエラーに適応するチャンネル
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        'fatal' => [
            'driver' => 'daily',
            'days'   => 28,
            'path'   => storage_path('logs/fatal.log'),
            'level'  => 'critical',
            'tap'    => [ BasicFormatter::class ]
        ],
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        // Slack通知用チャンネル
        //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        'slack' => [
            'driver'   => 'slack',
            'url'      => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji'    => ':boom:',
            'level'    => 'critical',
            'tap'      => [ BasicFormatter::class ]
        ],
    ],
];