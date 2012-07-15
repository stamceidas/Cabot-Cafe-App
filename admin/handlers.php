<?
	/************************************************
	 * handlers.php
	 ************************************************
	 *
	 * Handlers for database calls
	 * Functions for backend parsing
	 * 
	 ************************************************/
	
	require_once("../includes/common.php");
	
	/*************
	* Constants
	**************/
	
	define("DEFAULT_MIN", 0);
	define("DEFAULT_MAX", 10);
	define("DEFAULT_INCREMENT", 1);
	define("DEFAULT_WARNINGLIMIT",0);
	define("DEFAULT_MEASURETYPE", "item");
	
	$func = mysql_real_escape_string($_POST["func"]);
	// $params=mysql_real_escape_string($_POST["params"]);
	$params = $_POST["params"];
	
	
	/*********************
	 * General Functions
	 *********************/
	
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
	 * 3 - delete_user()
	 * 4 - update_item()
	 * 5 - delete_item()
	 *******************************/
	
	
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
		
		// creating a new user
		if(empty($params['id'])){
			
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
			//CASE 1: Admin editing another user
			if($params['id'] != $_SESSION['id']){
			
				// check if editing password
				if(isValid($params['password'])){
					if($params['password'] != $params['password2']){
						echoexit('error',"Passwords don't match!");
					}
					else{
						$values = "'" . strval($params['firstname']) . "','"
							. strval($params['lastname']) . "','"
							. strval($params['password']) . "','"
							. strval($params['email']) . "','"
							. strval($params['sudo']) . "','"							
							. strval($params['year']) . "'";
					
					}
				}
				else{
					//just update all other information
				
				}
			}
			//CASE 2: Admin editing self
		}
	}
	function delete_user(){
		global $params;
		$params = json_decode($params, true);
		if(mysql_query("DELETE FROM items WHERE id = '".$params['id']."'"))
			echoexit('success', "Item deleted!");
		else
			echoexit('error', "Failed to delete item!");
	}
	
	function update_item(){
		global $params;
		$params = json_decode($params, true);
		
		if(!isValid($params['itemname'], 0)){
			echoexit('error',"Invalid username.");
		}
		if(!isValid($params['location'],0) ){
			echoexit('error', 'Invalid password.');
		}
		if(!isValid($params['minamt'], 0) || !is_numeric($params['minamt'])){
			$params['minamt'] = DEFAULT_MIN;
		}
		if(!isValid($params['maxamt'], 0) || !is_numeric($params['maxamt'])){
			$params['maxamt'] = DEFAULT_MAX;
		}
		if(!isValid($params['increment'], 0) || !is_numeric($params['increment'])){
			$params['increment'] = DEFAULT_INCREMENT;
		}
		if(!isValid($params['measure_type'], 0) || !is_numeric($params['measure_type'])){
			$params['measure_type'] = DEFAULT_MEASURETYPE;
		}
		if(!isValid($params['warning_limit'], 0) || !is_numeric($params['warning_limit'])){
			$params['warning_limit'] = DEFAULT_WARNINGLIMIT;
		}
		
		// creating a new item
		if(empty($params['id'])){
			
			$values = "'" . strval($params['itemname']) . "','" 
							. strval($params['location']) . "','"
							. strval($params['minamt']) . "','"
							. strval($params['maxamt']) . "','"
							. strval($params['increment']) . "','"
							. strval($params['measure_type']) . "','"							
							. strval($params['warning_limit']) . "'";
			if($params['itemType'] == 'nightly'){
				if(mysql_query("INSERT INTO nightlyinventory(item_name,location,min_amt, max_amt,increment,measure_type, warning_limit) VALUES ($values)"))
					echoexit('success', "Item created!");
				else
					echoexit('error', "Failed to create item in Nightly Inventory!");
			}
			else if($params['itemType'] == 'weekly'){
				if(mysql_query("INSERT INTO weeklyinventory(item_name,location,min_amt, max_amt,increment,measure_type, warning_limit) VALUES ($values)"))
					echoexit('success', "Item created!");
				else
					echoexit('error', "Failed to create item in Weekly Inventory!");
			}
		}
		else{
		
		}
	}
	function delete_item(){
	
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
		case 3:
			delete_user();
			break;
		case 4:
			update_item();
			break;
		case 5:
			delete_item();
			break;
	}

	
	
	

?>