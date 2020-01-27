<?php
include("conn.php");
include("sql_functions.php");

class dbHandler
{

	function checkIfExists($check){
		$bool = array();

		foreach ($check as $key){

			if(isset($key) && $key <> ""){

				 $bool[$key] = TRUE;
			}else{
				 $bool[$key] = FALSE;
			}
		}

		if (in_array(FALSE, $bool)) {		    

		    return $bool = FALSE; 

		}else{
			
			return $bool = TRUE;

		}

	}		

	function insert($array,$table){

		global $dbh;

		$firstRow = 1;
		$lastInsertId ="";	

		// get db first column where id is a primary key 
		$primaryKey = $this->getPrimaryColumn($table);

		$sql_update =""; 

		//insert into database
		foreach ($array as $key => $value) {
			
			if($firstRow == 1){
				$sql_insert =  "insert into {$table}($key)values('$value')";				

				$this->queryDB($sql_insert);

				// get last insert id 
				$lastInsertId =  $dbh->lastInsertId();
			}else{

				$sql_update .=  "update {$table} set $key='$value' where $primaryKey = '$lastInsertId';";			
			}
			$firstRow++;
		}
		$this->queryDB($sql_update);

		//return the last inserted id if the user requires it 

		return $lastInsertId;
	}

	function update($array,$id,$table) {

		// get db first column where id is a primary key
		$primaryKey = $this->getPrimaryColumn($table);

		//insert into database
		$sql_update="";

		foreach ($array as $key => $value)		{		
	
			$sql_update .=  "update {$table} set $key='$value' where $primaryKey = '$id'";			
		}

		$this->queryDB($sql_update);
	}

	function delete($id,$table){
		
		// get db first column where id is a primary key 		
		$primaryKey = $this->getPrimaryColumn($table);

		$sql_delete = "delete from {$table} where $primaryKey ='{$id}'";

		$this->queryDB($sql_delete);	
	}

	function queryDB($query){
		//get executes a statement and returns the results 
		global $dbh;

		return $dbh->query($query);
	}

	function getPrimaryColumn($table){

		global $dbname;			

		$SqlTablePrimaryKeyCollumnName = "	SELECT k.column_name
											FROM information_schema.table_constraints t
											JOIN information_schema.key_column_usage k
											USING(constraint_name,table_schema,table_name)
										WHERE t.constraint_type='PRIMARY KEY'
									  		AND t.table_schema='{$dbname}'
									  		AND t.table_name='{$table}';
									   ";

		$ResultTablePrimaryKeyCollumnName=$this->queryDB($SqlTablePrimaryKeyCollumnName);

		$row = $ResultTablePrimaryKeyCollumnName->fetch(PDO::FETCH_ASSOC);

		return $row['column_name'];
	}




}