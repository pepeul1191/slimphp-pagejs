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
        'base_url' => 'http://localhost:8090/',
        'static_url' => 'http://localhost:8090/public/',
        'redirect_url' => [
          'google' => 'http://localhost:8090/oauth/callback?origin=google',
        ],
        'env_static' => 'desarrollo',
        'validation_csrf' => 'disable',
        'validation_session' => 'disable',
        'login' => [
          'user' => 'admin',
          'password' => 'sistema123'
        ],
        'admin' => [
          'url' => 'http://localhost:8080/',
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
