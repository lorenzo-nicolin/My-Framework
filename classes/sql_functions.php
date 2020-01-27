<?php 

include("conn.php");

/**
* 
*/
class sqlFunctions	
{


	// 	get the collumn thats a primary key or an od of the table 

	function getPrimaryColumn($table){


	global $dbh;	
	global $dbname;
		

	$SqlTablePrimaryKeyCollumnName = "	SELECT k.column_name
											FROM information_schema.table_constraints t
											JOIN information_schema.key_column_usage k
											USING(constraint_name,table_schema,table_name)
										WHERE t.constraint_type='PRIMARY KEY'
									  		AND t.table_schema='{$dbname}'
									  		AND t.table_name='{$table}';
									   ";

	$ResultTablePrimaryKeyCollumnName=$dbh->query($SqlTablePrimaryKeyCollumnName);

	$row = $ResultTablePrimaryKeyCollumnName->fetch(PDO::FETCH_ASSOC);

	return $row['column_name'];

	}
	
}
	


?>