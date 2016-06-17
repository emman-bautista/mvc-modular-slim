<?php 
namespace App\Utilities;

/**
* Helper Class
*/
class Helper
{
	
	static function todayMysqlDate() {
		return date("Y-m-d H:i:s");
	}

	static function todayMysqlTime() {
		return date("H:i:s");
	}
}