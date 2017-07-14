<?php
//db_connect
//password_encrypt


if (!function_exists("db_connect")) {
	function db_connect(){
		$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER_NAME, DB_PASSWORD, array(
		    PDO::ATTR_PERSISTENT => true
		));

		return $dbh;
	}
}
if (!function_exists("password_encrypt")) {
	function password_encrypt($psw){
		$psw = md5(md5($psw));
		return $psw;
	}
}	

?>