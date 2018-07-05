<?php

require_once 'vendor/j4mie/idiorm/idiorm.php';
require_once 'vendor/j4mie/paris/paris.php';

ORM::configure('sqlite:' . 'db/ubicaciones.db',  null, 'ubicaciones');
ORM::configure('return_result_sets', true);
ORM::configure('error_mode', PDO::ERRMODE_WARNING);
ORM::configure('logging', true);
