<?php
require_once 'src/configs/Database.php';
//use Configs\Database;

class Departamento extends Model
{
	public static $_table = 'departamentos';
	public static $_connection_name = 'ubicaciones';
}
