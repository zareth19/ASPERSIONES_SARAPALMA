<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database Tables Configuration
    |--------------------------------------------------------------------------
    |
    | This configuration file allows you to cache the existence of database
    | tables to avoid repeated Schema::hasTable() calls that impact performance.
    |
    */

    'aspersion_codigo_exists' => env('ASPERSION_CODIGO_TABLE_EXISTS', true),
    'fincas_temp_exists' => env('FINCAS_TEMP_TABLE_EXISTS', true),
];