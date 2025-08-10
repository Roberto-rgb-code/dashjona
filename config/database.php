<?php

   return [
       'default' => env('DB_CONNECTION', 'mysql'),
       'connections' => [
           'mysql' => [
               'driver' => 'mysql',
               'host' => env('DB_HOST', '64.202.185.148'),
               'port' => env('DB_PORT', '3306'),
               'database' => env('DB_DATABASE', 'costmexico_cashimirodb'),
               'username' => env('DB_USERNAME', 'costmexico_adminCash'),
               'password' => env('DB_PASSWORD', 'i&lSlYH{TL#RW!fu'),
               'charset' => 'utf8mb4',
               'collation' => 'utf8mb4_unicode_ci',
               'prefix' => '',
               'strict' => true,
               'engine' => null,
           ],
       ],
   ];