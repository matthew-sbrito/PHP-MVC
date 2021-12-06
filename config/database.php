<?php

/**
 * CONFIG OF DATABASE DRIVE
 */

return [
  'driver' => 'firebird',
  'host'   => env('DB_HOST'),
  'name'   => env('DB_NAME'),
  'user'   => env('DB_USER'),
  'pass'   => env('DB_PASSWORD'),
  'port'   => env('DB_PORT', 3306),
];