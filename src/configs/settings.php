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
      'base_url' => 'http://localhost:8080/',
      'static_url' => 'http://localhost:8080/public/',
      'ambiente_static' => 'desarrollo',
      'ambiente_csrf' => 'activo',
      'ambiente_session' => 'activo',
      'login' => [
        'usuario' => 'admin',
        'contrasenia' => 'sistema123'
      ],
      'csrf' => [
        'secret' => 'PKBcauXg6sTXz7Ddlty0nejVgoUodXL89KNxcrfwkEme0Huqtj6jjt4fP7v2uF4L',
        'key' => 'csrf_val'
      ],
    ],
  ],
];
