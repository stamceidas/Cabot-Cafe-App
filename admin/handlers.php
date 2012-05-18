<?
	/************************************************
	* handlers.php
	*************************************************
	*
	* Handlers for database calls
	* Functions for backend parsing
	* 
	*************************************************/
	
	require_once("../includes/common.php");
	
	$func = mysql_real_escape_string($_POST["func"]);
	// $params=mysql_real_escape_string($_POST["params"]);
	$params = $_POST["params"];
	
	
	/**********************
	* General Functions
	**********************/
	
	function escape_array(){
		global $params;
		$j = count($params);
		for($i = 0; $i < $j; $i++){
			$params[$i] = mysql_real_escape_string($params[$i]);
		}
	
	}
	
	
	/*******************************
	* Function Index List
	* 
	* 1 - update_admin()
	*
	********************************/
	
	
	function update_admin(){
		
		global $params;
		
		if(mysql_query("UPDATE admin SET name = '$params[0]', username = '$params[1]', password = '$params[2]', email = '$params[3]', year = '$params[4]' WHERE id = {$_SESSION["id"]}"))
			echo "Update successful!";
		else
			echo "Update failed! Check connection to database!";

	}

	//clean the strings out
	escape_array();



	switch ($func) {
		case 0:
			echo "Error! Unspecified function!";
			break;
		case 1:
			update_admin();
			break;
		case 2:
			break;
	}

	
	
	

?>