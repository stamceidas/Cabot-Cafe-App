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
	
	function isValid($x, $size){
		if(empty($x))
			return false;
		if(strlen($x) < $size){
			return false;
		}
		return true;
	}
	
	function echoexit($status, $msg){
		echo json_encode(array('status' => $status, 'msg' => $msg));
		exit();
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
		//var_dump($params);
		
		if(empty($params['id'])){
			
			if(!isValid($params['username'], 8)){
				echoexit('error',"Invalid username.");
			}
			if(!isValid($params['password'],8) ){
				echoexit('error', 'Invalid password.');
			}
			if($params['password'] != $params['password2']){
				echoexit('error',"Passwords don't match!");
			}
			if(!isValid($params['email'], 0)){
				echoexit('error', "Invalid email.");
			}
			if($params['sudo'] == 'true'){
				$params['sudo'] = 1;
			}
			else{
				$params['sudo'] = 0;
			}
			
			$values = "'" . strval($params['username']) . "','" 
							. strval($params['firstname']) . "','"
							. strval($params['lastname']) . "','"
							. strval($params['password']) . "','"
							. strval($params['email']) . "','"
							. strval($params['sudo']) . "','"							
							. strval($params['year']) . "'";
		
			if(mysql_query("INSERT INTO admin(username,firstname,lastname, password,email,sudo, year) VALUES ($values)"))
				echoexit('success', "User created!");
			else
				echoexit('error', "Failed to create user!");
		}
		else{
		
		
		}
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