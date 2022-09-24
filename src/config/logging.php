<?php
use Monolog\Handler\NullHandler;
use App\Common\Log\Formatter\BasicFormatter;
use App\Common\Log\Formatter\SqlFormatter;

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
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */
    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

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
            'channels'          => ['basic', 'error', 'fatal'],
            'ignore_exceptions' => false,
        ],
        'basic' => [
            'driver'     => 'daily',
            'path'       => storage_path('logs/laravel.log'),
            'level'      => env('LOG_LEVEL_CHANNEL_BASIC', 'debug'),
            'days'       => 7,
            'permission' => 0664,
            'tap'        => [ BasicFormatter::class ]
        ],
        'error' => [
            'driver'     => 'daily',
            'path'       => storage_path('logs/error.log'),
            'level'      => 'error',
            'days'       => 7,
            'permission' => 0664,
            'tap'        => [ BasicFormatter::class ]
        ],
        'fatal' => [ # 緊急対応用
            'driver'     => 'daily',
            'path'       => storage_path('logs/fatal.log'),
            'level'      => 'critical',
            'days'       => 7,
            'permission' => 0664,
            'tap'        => [ BasicFormatter::class ]
        ],
        'slack' => [
            'driver'   => 'slack',
            'url'      => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji'    => ':boom:',
            'level'    => env('LOG_LEVEL_CHANNEL_SLACK', 'critical'),
        ],
        'null' => [
            'driver'  => 'monolog',
            'handler' => NullHandler::class,
        ],
        'sql' => [
            'driver'     => 'daily',
            'days'       => 3,
            'path'       => storage_path('logs/sql.log'),
            'level'      => 'info',
            'permission' => 0664,
            'tap'        => [ SqlFormatter::class ]
        ],
    ],
];
