<?php
require_once 'src/configs/database.php';

class Departamento extends Model
{
	public static $_table = 'departamentos';
	public static $_connection_name = 'ubicaciones';
}
