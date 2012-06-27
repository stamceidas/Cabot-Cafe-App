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
	* 2 - update_user()
	********************************/
	
	
	function update_self_admin(){
		
		global $params;
		
		if(mysql_query("UPDATE admin SET firstname = '$params[0]', username = '$params[1]', password = '$params[2]', email = '$params[3]', year = '$params[4]' WHERE id = {$_SESSION["id"]}"))
			echo "Update successful!";
		else
			echo "Update failed! Check connection to database!";

	}
	function update_user(){
		
		global $params;
		$params = json_decode($params, true);
		var_dump($params);
		
		
		$values = "'" . strval($params['username']) . "','" 
						. strval($params['firstname']) . "','"
						. strval($params['lastname']) . "','"
						. strval($params['email']) . "','" 
						. strval($params['year']) . "'";
		echo $values;
		if(mysql_query("INSERT INTO admin(username,firstname,lastname, email,year) VALUES ($values)"))
			echo json_encode(array('flag' => 'success', 'msg' => "Created!"));
		else
			echo json_encode(array('flag' => 'error', 'msg' => "INSERT INTO admin(username,firstname,lastname, email,year) VALUES ($values)"));
	}
	

	//clean the strings out
	escape_array();

	// decide which function to run
	switch ($func) {
		case 0:
			echo "Error! Unspecified function!";
			break;
		case 1:
			update_self_admin();
			break;
		case 2:
			update_user();
			break;
	}

	
	
	

?>