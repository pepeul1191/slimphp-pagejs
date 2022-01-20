<?php
return [
  'settings' => [
    'displayErrorDetails' => true, // set to false in production
    'addContentLengthHeader' => false, // Allow the web server to send the content-length header
    // Renderer settings
    'renderer' => [
      'template_path' => __DIR__ . '/../templates/',
    ],
    // Monolog settings
    'logger' => [
      'name' => 'slim-app',
      'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/app.log',
      'level' => \Monolog\Logger::DEBUG,
    ],
    'constants' => [
      'local' => [
        'base_url' => 'http://192.168.1.26:8090/',
        'static_url' => 'http://192.168.1.26:8090/public/',
        'env_static' => 'desarrollo',
        'service_url' => 'http://localhost:8080/',
        'validation_csrf' => 'disable',
        'validation_session' => 'able',
        'login' => [
          'user' => 'admin',
          'password' => 'sistema123'
        ],
        'admin' => [
          'url' => 'http://localhost:8080/',
          'static_url' => 'http://localhost:8080/public/',
          'key' => 'api-key',
          'value' => 'SJdTvhpVBTm9f6SwjUAs48ffnlmhZU',
        ],
        'csrf' => [
          'secret' => 'PKBcauXg6sTXz7Ddlty0nejVgoUodXL89KNxcrfwkEme0Huqtj6jjt4fP7v2uF4L',
          'key' => 'csrf_val'
        ],
      ],
      'prod' => [
        'base_url' => 'https://legisjuristas.com/',
        'static_url' => 'https://legisjuristas.com/public/',
        'env_static' => 'desarrollo',
        'remote_url' => 'https://admin.legisjuristas.com/public/',
        'service_url' => 'https://admin.legisjuristas.com/',
        'validation_csrf' => 'disable',
        'validation_session' => 'able',
        'login' => [
          'user' => 'admin',
          'password' => 'sistema123'
        ],
        'admin' => [
          'url' => 'https://admin.legisjuristas.com/',
          'static_url' => 'https://admin.legisjuristas.com/public/',
          'key' => 'api-key',
          'value' => 'SJdTvhpVBTm9f6SwjUAs48ffnlmhZU',
        ],
        'csrf' => [
          'secret' => 'PKBcauXg6sTXz7Ddlty0nejVgoUodXL89KNxcrfwkEme0Huqtj6jjt4fP7v2uF4L',
          'key' => 'csrf_val'
        ],
      ],
    ],
  ],
];
