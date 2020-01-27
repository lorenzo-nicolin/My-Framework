<?php
	
	include('config.php');
	//set variables to globals 	

	$GLOBALS['host'] = $host;
	$GLOBALS['dbname'] = $dbname;
	$GLOBALS['username'] = $username;
	$GLOBALS['password'] = $password;
	$GLOBALS['driver'] = $driver;

 	try{
		$dbh  = new PDO("{$driver}:host={$host};dbname={$dbname}", "{$username}","{$password}");
		
		$GLOBALS['dbh'] = $dbh;	

	 }catch(PDOexception $e){
		echo 'conection failed'.$e->getMessage();
	 }		 