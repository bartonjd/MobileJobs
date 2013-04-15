<?php
include('appConstants.inc.php');
function connect2DB(){
	$conn_array = array(
		 "host"     =>DB_HOST
		,"port"     =>DB_PORT
		,"dbname"   =>DB_NAME
		,"user"     =>DB_USER
		,"password" =>DB_PASSWORD
	);
	$conn_string = "host=${conn_array['host']} ";
	$conn_string .= "port=${conn_array['port']} ";
	$conn_string .= "dbname=${conn_array['dbname']} ";
	$conn_string .= "user=${conn_array['user']} ";
	$conn_string .= "password=${conn_array['password']}";

	$dbconn = pg_pconnect($conn_string);
	return $dbconn;

}
?>