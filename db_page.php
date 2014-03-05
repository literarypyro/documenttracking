<?php
function retrieveRecordsDb(){
	//Database for Records
	//$db=new mysqli('nea','records','123456','records');

	//$db=new mysqli('records','records','123456','records');
	//$db=new mysqli('sup-psilva','records','123456','records');
//	$db=new mysqli('sup-psilva','records_officer','123456','records');
//	$db=new mysqli ( 'mysqlsdb.co8hm2var4k9.eu-west-1.rds.amazonaws.com','depbeuw9bkz','Gpqq1jD7sLGp','depbeuw9bkz');

//	$db=new mysqli ( 'localhost','root','','records');
	$db=$_SESSION['db'];
	//$db=new mysqli('192.168.1.128','server_user','123456','records');
	return $db;
}

function retrieveUsersDb(){
	//Database for Users
	//$db2=new mysqli('nea','records','123456','user_management');

	//$db2=new mysqli('records','records','123456','user_management');
//	$db2=new mysqli('sup-psilva','records','123456','user_management');
//	$db2=new mysqli('sup-psilva','records_officer','123456','user_management');

//	$db2=new mysqli('mysqlsdb.co8hm2var4k9.eu-west-1.rds.amazonaws.com','depbeuw9bkz','Gpqq1jD7sLGp','depbeuw9bkz');

//	$db2=new mysqli ( 'localhost','root','','user_management');

	$db2=$_SESSION['db'];
	//$db2=new mysqli('192.168.1.128','server_user','123456','user_management');
	return $db2;
}
function instantiateDb(){
	
	$db2=new mysqli('mysqlsdb.co8hm2var4k9.eu-west-1.rds.amazonaws.com','depbeuw9bkz','Gpqq1jD7sLGp','depbeuw9bkz');
	
	$_SESSION['db']=$db2;
	return $db2;
}


?>