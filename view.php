<?php 
	
	
include("core_init.php");



	
	if (isset($_GET['firstname']) && $_GET['firstname']<>"" && isset($_GET['lastname']) && $_GET['lastname']<>"" && isset($_GET['age']) && $_GET['age']<>"" && isset($_GET['submit']) && $_GET['submit']<>"") {


		$obj = new dbHandler();

		// run first update query 
		$array = array(
		 					"firstname"=>$_GET['firstname'],
		 					"lastname"=>$_GET['lastname'] 					
		 			   );

		$users_id = $_GET['users_id'];

		$obj->update($array,$users_id,"users");

		//run second uodate 

		$array_2 = array(
		 					"age"=>$_GET['age']	 					
		 			   );

		$users_details_id = $_GET['users_details_id'];

		

		$obj->update($array_2,$users_details_id,"users_details");

		echo "<b>{$_GET['firstname']} details has updated</b><br><br>";

	}

	if(isset($_GET['firstname']) && $_GET['firstname']<>"" && isset($_GET['lastname']) && $_GET['lastname']<>"" && isset($_GET['age']) && $_GET['age']<>"" && isset($_GET['delete']) && $_GET['delete']<>""){

		 $obj = new dbHandler();

		 $obj->delete($_GET['users_id'],"users");
		 $obj->delete($_GET['users_id'],"users_details");

	}

	// $results=$dbh->query("select * from users order by firstname DESC");

	$obj = new dbHandler();

	$results = $obj->queryDB("select * from users order by firstname DESC");





	
	if(!isset($_GET['edit'])){
			print "<a href='index.php'>ADD</a><p>";
		while ($row=$results->fetch(PDO::FETCH_ASSOC)) {

	
			print $row['firstname']."<a href='view.php?edit=yes&id={$row['users_id']}'>EDIT</a>"." "."<br>";				
		}
	
	}else{		

		$id = $_GET['id'];
		$obj = new dbHandler();
		
		$results = $obj->queryDB("select u.*,ud.* from users u left join users_details ud on u.users_id = ud.users_id where u.users_id ='$id' order by u.users_id");		

		$row = $results->fetch(PDO::FETCH_ASSOC);

	
	?>	
		<a href='index.php'>ADD</a>
		
		<form method="GET" action="view.php">
			First Name : <br>
			<input type="text" name="firstname" value="<?php print $row['firstname'] ?>"><br>
			Last Name : <br>
			<input type="text" name="lastname" value="<?php print $row['lastname'] ?>"><br>
			Age : <br>
			<input type="text" name="age" value="<?php print $row['age'] ?>"><br>	
			<input type="hidden" name="users_details_id" value="<?php print $row['users_details_id']; ?>">	
			<input type="hidden" name="users_id" value="<?php print $row['users_id']; ?>">	
			<button name="submit" value="submit">Submit</button>		
			<button name="cancel" value="cancel">Cancel</button>
			<button name="delete" value="delete">Delete</button>
		</form>
		
<?php
	}
?>