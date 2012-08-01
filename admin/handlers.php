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
	
	// this function should be replaced with users form mvc
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
		
		if(!isValid($params['username'], 0)){
			echoexit('error',"Invalid username.");
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
			if(!isValid($params['password'],8) ){
			echoexit('error', 'Invalid password.');
			}
			if($params['password'] != $params['password2']){
				echoexit('error',"Passwords don't match!");
			}
			if(!isValid($params['pin'],4) || !is_numeric($params['pin'])){
				//echoexit('error',"Bad PIN!");
				$params['pin'] = 0;
			}
			
			// hash the user password with new random salt
			$userSalt = strval(genSalt());
			$encryptedPassword = passGen($params['password'],$userSalt);
			
			$values = "'" . strval($params['username']) . "','" 
							. strval($params['firstname']) . "','"
							. strval($params['lastname']) . "','"
							. strval($encryptedPassword) . "','"
							. strval($params['email']) . "','"
							. strval($params['sudo']) . "','"
							. strval($params['year']) . "','"
							. $userSalt . "','"							
							. strval($params['pin']) . "'";
		
			if(mysql_query("INSERT INTO admin(username,firstname,lastname, password,email,sudo, year, salt,PIN) VALUES ($values)"))
				echoexit('success', "User created!");
			else
				echoexit('error', "Failed to create user!");
		}
		else{
			//CASE 1: Admin editing another user
			if($params['id'] != $_SESSION['id']){
			
				// check if editing password
				if(isValid($params['password'],8)){
					if($params['password'] != $params['password2']){
						echoexit('error',"Passwords don't match!");
					}
					else{
						$userSalt = strval(genSalt());
						$encryptedPassword = passGen($params['password'],$userSalt);
						if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', sudo = '{$params["sudo"]}', password = '{$encryptedPassword}', year = '{$params["year"]}', salt = '{$userSalt}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
							echoexit('update_success', "Update successful! Information and Password changed!");
						else
							echoexit('error', "Update failed!");
					}
				}
				else{
					//just update all other information
					if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', sudo = '{$params["sudo"]}', year = '{$params["year"]}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
							echoexit('update_success', "Update successful! Information changed!");
						else
							echoexit('error', "Update failed!");
				}
			}
			//CASE 2: Admin editing self
			else{
				// check if editing password
				if(isValid($params['password'],8)){
					if($params['password'] != $params['password2']){
						echoexit('error',"Passwords don't match!");
					}
					else{
						$userSalt = strval(genSalt());
						$encryptedPassword = passGen($params['password'],$userSalt);
						if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', password = '{$encryptedPassword}', year = '{$params["year"]}', salt = '{$userSalt}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
							echoexit('update_success', "Update successful! Information and Password changed!");
						else
							echoexit('error', "Update failed!");
					}
				}
				else{
					//just update all other information
					if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', year = '{$params["year"]}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
							echoexit('update_success', "Update successful! Information changed!");
						else
							echoexit('error', "Update failed!");
				}
			}
		}
	}
	function delete_user(){
		global $params;
		$params = json_decode($params, true);
		if(mysql_query("DELETE FROM admin WHERE id = '".$params['id']."'"))
			echoexit('success', "User deleted!");
		else
			echoexit('error', "Failed to delete user!");
	}
	
	function update_item(){
		global $params;
		$params = json_decode($params, true);
		
		// creating a new item
		if(empty($params['id'])){
			if(!isValid($params['itemname'], 0)){
				echoexit('error',"Invalid item name.");
			}
			if(!isValid($params['location'],0) ){
				echoexit('error', 'Invalid location.');
			}
			if(!isValid($params['minamt'], 0) || !is_numeric($params['minamt'])){
				$params['minamt'] = DEFAULT_MIN;
			}
			if(!isValid($params['maxamt'], 0) || !is_numeric($params['maxamt'])){
				$params['maxamt'] = DEFAULT_MAX;
			}
			if($params['maxamt'] <= $params['minamt']){
				echoexit('error',"MAX can't be less than or equal to MIN!");
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
			//update the item
			
			// nightly inventory update
			if($params['itemType'] == 'nightly'){
				$sql="SELECT * FROM nightlyinventory WHERE id = {$params["id"]}";
				$result=mysql_query($sql);
				$row = mysql_fetch_array($result);
				if($row['item_name'] != $params['itemname'])
					$row['item_name'] = $params['itemname'];
				if($row['location'] != $params['location'])
					$row['location'] = $params['location'];
				if(($row['min_amt'] != $params['minamt']) && is_numeric($params['minamt']))
					$row['min_amt'] = $params['minamt'];
				if(($row['max_amt'] != $params['maxamt']) && is_numeric($params['maxamt']))
					$row['max_amt'] = $params['maxamt'];
				if(($row['increment'] != $params['increment']) && is_numeric($params['increment']))
					$row['increment'] = $params['increment'];
				if($row['measure_type'] != $params['measure_type'])
					$row['measure_type'] = $params['measure_type'];
				if(($row['warning_limit'] != $params['warning_limit']) && is_numeric($params['warning_limit']))
					$row['warning_limit'] = $params['warning_limit'];
				
				if(mysql_query("UPDATE nightlyinventory SET location = '{$row["location"]}', item_name = '{$row["location"]}', min_amt = '{$row["min_amt"]}', max_amt = '{$row["max_amt"]}', increment = '{$row["increment"]}', measure_type = '{$row["measure_type"]}', warning_limit = '{$row["warning_limit"]}' WHERE id = {$params["id"]}"))
					echoexit('update_success', "Update successful!");
				else
					echoexit('error', "Update failed!");
			}
			// weekly inventory update
			else if($params['itemType'] == 'weekly'){
				$sql="SELECT * FROM weeklyinventory WHERE id = {$params["id"]}";
				$result=mysql_query($sql);
				$row = mysql_fetch_array($result);
				if($row['item_name'] != $params['itemname'])
					$row['item_name'] = $params['itemname'];
				if($row['location'] != $params['location'])
					$row['location'] = $params['location'];
				if(($row['min_amt'] != $params['minamt']) && is_numeric($params['minamt']))
					$row['min_amt'] = $params['minamt'];
				if(($row['max_amt'] != $params['maxamt']) && is_numeric($params['maxamt']))
					$row['max_amt'] = $params['maxamt'];
				if(($row['increment'] != $params['increment']) && is_numeric($params['increment']))
					$row['increment'] = $params['increment'];
				if($row['measure_type'] != $params['measure_type'])
					$row['measure_type'] = $params['measure_type'];
				if(($row['warning_limit'] != $params['warning_limit']) && is_numeric($params['warning_limit']))
					$row['warning_limit'] = $params['warning_limit'];
				
				if(mysql_query("UPDATE weeklyinventory SET location = '{$row["location"]}', item_name = '{$row["location"]}', min_amt = '{$row["min_amt"]}', max_amt = '{$row["max_amt"]}', increment = '{$row["increment"]}', measure_type = '{$row["measure_type"]}', warning_limit = '{$row["warning_limit"]}' WHERE id = {$params["id"]}"))
					echoexit('update_success', "Update successful!");
				else
					echoexit('error', "Update failed!");
			}
			
			
		}
	}
	
	function delete_item(){
		global $params;
		$params = json_decode($params, true);
		if($params['itemType'] == 'nightly'){
			if(mysql_query("DELETE FROM nightlyinventory WHERE id = '".$params['id']."'"))
				echoexit('success', "Item deleted!");
			else
				echoexit('error', "Failed to delete item!");
		}
		else if($params['itemType'] == 'weekly'){
			if(mysql_query("DELETE FROM weeklyinventory WHERE id = '".$params['id']."'"))
				echoexit('success', "Item deleted!");
			else
				echoexit('error', "Failed to delete item!");
		}
	}
	
	function pin_verify(){
		global $params;
		$params = json_decode($params, true);
		
		if($params['pin'] == 0){
			echoexit('error', "You are not authorized to use this app!");
		}
		
		$sql="SELECT * FROM admin WHERE pin='".$params['pin']."'";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		
		if(mysql_num_rows($result)==1){
			//now set the session from here if needed
			$_SESSION['user']=$row['username'];
			$_SESSION['firstname']=$row['firstname'];
			$_SESSION['lastname']=$row['lastname'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['pin'] = $row['PIN'];
			echoexit('success', "Authentication successful!");
		
		}
		else if (mysql_num_rows($result)>1){
			echoexit('error','There are multiple employees with that ID! Please contact cafe managers!');
		}
		else{
			echoexit('error','Invalid PIN. Please try again.');
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
		case 3:
			delete_user();
			break;
		case 4:
			update_item();
			break;
		case 5:
			delete_item();
			break;
		case 6:
			pin_verify();
			break;
			
	}

	
	
	

?>