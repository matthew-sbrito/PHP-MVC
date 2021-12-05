<?php

/**
 * MAPPING THE APPLICATION MIDDLEWARES
 */
return [
  'middlewares' => [
    'maintenance'         => \App\Http\Middleware\Maintenance::class,
    'authenticatedUser'   => \App\Http\Middleware\AuthenticatedUser::class,
    'authenticatedAdmin'  => \App\Http\Middleware\AuthenticatedAdmin::class,
    'checkLogged'         => \App\Http\Middleware\CheckLogged::class,
    'api'                 => \App\Http\Middleware\Api::class,
    'userBasicAuth'       => \App\Http\Middleware\UserBasicAuth::class,
    'jwtAuth'             => \App\Http\Middleware\JWTAuth::class,
    'cache'               => \App\Http\Middleware\Cache::class,
  ],
  'default' => [
    'maintenance'
  ]
];