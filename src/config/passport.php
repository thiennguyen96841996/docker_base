<?php

use GLC\Platform\Database\Definitions\DatabaseDefs;

return [
    /*
    |--------------------------------------------------------------------------
    | Passport Storage Driver
    |--------------------------------------------------------------------------
    |
    | This configuration options determines the storage driver that will
    | be used to store Passport's data. In addition, you may set any
    | custom options as needed by the particular driver you choose.
    |
    */

    'storage' => [
        'database' => [
            'connection' => DatabaseDefs::CONNECTION_NAME_WRITE
        ],
    ],

];