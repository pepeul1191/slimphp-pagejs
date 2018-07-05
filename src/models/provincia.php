<?php

require_once 'src/configs/database.php';

class Provincia extends Model 
{
	public static $_table = 'provincias';
	public static $_connection_name = 'ubicaciones';
}
