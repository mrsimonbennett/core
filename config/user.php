<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default user settings
    |--------------------------------------------------------------------------
    |
    | Available user settings and their default value
    |
    */
    'settings' => [

        /*
        |--------------------------------------------------------------------------
        | Datetime settings
        |--------------------------------------------------------------------------
        */

        'datetime_format' => [
            'default' => 'd/m/Y H:i',
            'rules'   => 'required|string',
        ],
        'date_format'     => [
            'default' => 'd/m/Y',
            'rules'   => 'required|string',
        ],
        'time_format'     => [
            'default' => 'H:i',
            'rules'   => 'required|string',
        ],
        'timezone'        => [
            'default' => 'Europe/London',
            'rules'   => 'required|timezone',
        ],
    ]
];