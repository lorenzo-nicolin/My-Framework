<?php

include("core_init.php");



if(isset($_GET['firstname']) && $_GET['firstname']<>""){
	
	$obj = new dbHandler();

	// run first query 
	$array = array(
	 					"firstname"=>$_GET['firstname'],
	 					"lastname"=>$_GET['lastname'], 					
	 			   );

	$lastInsertId = $obj->insert($array,"users");

	//run second query 
	$array_2 = array(	
						"users_id"=>$lastInsertId,
						"age"=>$_GET['age']					
					);

	$obj->insert($array_2,"users_details");
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<a href="view.php">View</a>
<form method="GET">
  First name:<br>
  <input type="text" name="firstname"><br>
  Last name:<br>
  <input type="text" name="lastname"><br>
  Age:<br>
  <input type="text" name="age"><br>
  <button>Submit</button>
</form> 
</body>
</html>