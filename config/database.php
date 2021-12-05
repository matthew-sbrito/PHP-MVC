<?php

/**
 * CONFIG OF DATABASE DRIVE
 */

return [
  'host' => getenv('DB_HOST'),
  'name' => getenv('DB_NAME'),
  'user' => getenv('DB_USER'),
  'pass' => getenv('DB_PASSWORD'),
  'port' => getenv('DB_PORT') ?? 3306,
];