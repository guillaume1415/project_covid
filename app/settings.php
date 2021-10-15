<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

define('APP_ROOT', __DIR__);

return function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => true, // Should be set to false in production
            'determineRouteBeforeAppMiddleware' => false,
            'logger' => [
                'name' => 'slim-app',
                'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                'level' => Logger::DEBUG,
            ],

            'doctrine' => [
                // if true, metadata caching is forcefully disabled
                'dev_mode' => true,

                // path where the compiled metadata info will be cached
                // make sure the path exists and it is writable
                'cache_dir' => APP_ROOT . '/var/doctrine',

                // you should add any other path containing annotated entity classes
                // 'metadata_dirs' => [APP_ROOT . '/src/Domain'],
                'metadata_dirs' => [APP_ROOT . '/../src/'],

                'connection' => [
                    'driver' => 'pdo_mysql',
//                    'driver' => 'mysql',
//                    'host' => 'localhost',
                    'host' => 'db',
                    'port' => 3306,
                    'dbname' => 'projet_covid',
                    'user' => 'user',
                    'password' => 'user',
                    'charset' => 'utf8'
                ]
            ],
            // Twig settings
            'twig' => [
                // Template paths
                'paths' => [
                    __DIR__ . '/../templates',
                ],
                // Twig environment options
                'options' => [
                    // Should be set to true in production
                    'cache_enabled' => false,
                    'cache_path' => __DIR__ . '/../tmp/twig',
                ],
            ]
        ],
    ]);
};
