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
	
	function create_log_file($filename, $items_array, $type){
		$filehandle =  fopen($filename, 'w') or die("Log could not be generated. Reconnect to wifi and try again.");
		
		$date = date("Ymd");
		$time = date("Gi");
		
		$newline = "\n";
		$linebreak = "=================================";
		$sep = ",";
		
		$datecreated = "Date Created: " . $date . $newline;
		$timecreated = "Time Created: " . $time . $newline;
		
		if($type == 'nightly')
			$filelog = "Nightly Inventory Log" . $newline . $newline;
		else if($type == 'weekly')
			$filelog = "Weekly Inventory Log" . $newline . $newline;
		
		$userinfo = "Submitted by: " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . $newline;
		$userinfo = $userinfo . "Username: " . $_SESSION['user'] . $sep . "ID: " . $_SESSION['id'] . $newline;
		
		$filelog = $filelog . $datecreated . $timecreated . $userinfo . $linebreak . $newline . $newline;
		
		fwrite($filehandle,$filelog);
		
		$namesStr = '';
		$valuesStr = '';
		
		// parse through item array and store names and values
		// also update the values in the database...
		foreach($items_array as $item){
			$namesStr = $namesStr . $item['name'] . $sep;
			$valuesStr = $valuesStr . $item['value'] . $sep;
		
			if($type == 'nightly')
				$sql = "UPDATE nightlyinventory SET last_amt = {$item['value']} WHERE item_name = '{$item['name']}'";
			if($type == 'weekly')
				$sql = "UPDATE weeklyinventory SET last_amt = {$item['value']} WHERE item_name = '{$item['name']}'";
			if(!mysql_query($sql))
				echoexit('error', "Failed to update item amounts correctly!");
				// echoexit('error',$sql);
		}
		
		fwrite($filehandle, $namesStr.$newline);
		fwrite($filehandle, $valuesStr);
		
		fclose($filehandle);
		
		return true;
	}
	
	
	function generate_mail($type,$filename){
		
		$date = date("Ymd");
		$time = date("Gi");
		
		$receiver_email = '';
		
		$sql = "SELECT * FROM admin WHERE sendto = 1";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			$receiver_email = $receiver_email . $row['email'] . ", ";
		}

		$sender_email = 'cabotcafe@hcs.harvard.edu';
		$sender_name = 'Cabot Cafe Daemon via HCS';
		
		//get account name from url
		preg_match_all('/^(\/[^\/]*){1}/',$_SERVER['REQUEST_URI'],$matches);	
		
		$url="http://".$_SERVER['HTTP_HOST'].$matches[0][0].substr($filename,2);
		
		$msg = "Inventory log was submitted by user:". $_SESSION['firstname'] .' '. $_SESSION['lastname'] ."<".$_SESSION['user'].">. Download it here: " . $url;
		echoexit('error',$msg);
		
		$to      = $receiver_email;
		if($type == 'nightly')
			$subject = "[Cabot Cafe App] Nightly Inventory Log (".$date.")";
		else if($type == 'weekly')
			$subject = "[Cabot Cafe App] Weekly Inventory Log (".$date.")";
		$message = $msg;
		$headers = 	'From:'. $sender_name. '<'.$sender_email.'>' . "\r\n" .
					'Reply-To: '.$sender_email . "\r\n" .
					'X-Mailer: PHP/' . phpversion();

		//$x = mail($to, $subject, $message, $headers);
		$x = 1;
		return $x;
	}
	
	/*******************************
	 * Function Index List
	 * 
	 * 1 - update_admin()
	 * 2 - update_user()
	 * 3 - delete_user()
	 * 4 - update_item()
	 * 5 - delete_item()
	 * 6 - pin_verify()
	 * 7 - get_inv_form()
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
		if($params['emergency'] == 'true'){
			$params['emergency'] = 1;
		}
		else{
			$params['emergency'] = 0;
		}
		if($params['sendto'] == 'true'){
			$params['sendto'] = 1;
		}
		else{
			$params['sendto'] = 0;
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
			
			// put together all the values
			$values = "'" . strval($params['username']) . "','" 
							. strval($params['firstname']) . "','"
							. strval($params['lastname']) . "','"
							. strval($encryptedPassword) . "','"
							. strval($params['email']) . "','"
							. strval($params['sudo']) . "','"
							. strval($params['year']) . "','"
							. strval($params['phone']) . "','"
							. strval($params['emergency']) . "','"
							. strval($params['sendto']) . "','"
							. $userSalt . "','"							
							. strval($params['pin']) . "'";
		
			if(mysql_query("INSERT INTO admin(username,firstname,lastname, password,email,sudo, year, tel,emergency,sendto,salt,PIN) VALUES ($values)"))
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
						if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', sudo = '{$params["sudo"]}', password = '{$encryptedPassword}', year = '{$params["year"]}', tel = '{$params["phone"]}', sendto = '{$params["sendto"]}', emergency = '{$params["emergency"]}', salt = '{$userSalt}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
							echoexit('update_success', "Update successful! Information and Password changed!");
						else
							echoexit('error', "Update failed!");
					}
				}
				else{
					//just update all other information
					if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', sudo = '{$params["sudo"]}', year = '{$params["year"]}', tel = '{$params["phone"]}', sendto = '{$params["sendto"]}', emergency = '{$params["emergency"]}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
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
						if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', password = '{$encryptedPassword}', year = '{$params["year"]}', tel = '{$params["phone"]}', sendto = '{$params["sendto"]}', emergency = '{$params["emergency"]}', salt = '{$userSalt}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
							echoexit('update_success', "Update successful! Information and Password changed!");
						else
							echoexit('error', "Update failed!");
					}
				}
				else{
					//just update all other information
					if(mysql_query("UPDATE admin SET firstname = '{$params["firstname"]}', lastname = '{$params["lastname"]}', email = '{$params["email"]}', year = '{$params["year"]}', tel = '{$params["phone"]}', sendto = '{$params["sendto"]}', emergency = '{$params["emergency"]}', PIN = '{$params["pin"]}' WHERE id = {$params["id"]}"))
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

	function get_inv_form(){
		global $params;
		$params = json_decode($params, true);
		
		if($params['formtype'] == "nightly"){
			
			$location = '';
			$itemform = '<form id="target" method="post" data-ajax="false">';
			$itemform = $itemform . '<input class="nightly" name="nightly" id="nightly" value="1" type="text" style="display:none">';
			
			$sql="SELECT * FROM nightlyinventory order by location asc";
			$result=mysql_query($sql);
			//$row = mysql_fetch_array($result);
			
			while($row = mysql_fetch_array($result)){
				
				if(strcmp($location,$row['location']) != 0){
					$location = $row['location'];
					$itemform = $itemform . '<h3>'.$row['location'].'</h3>';
				}
				
				$itemform = $itemform . '<div data-role="fieldcontain">';
				$itemform = $itemform . '<span class="increment" style="display:none">'.$row['increment'].'</span>';
				$itemform = $itemform . '<label for="'.$row['item_name'].'">'.$row['item_name'].'('.$row['increment'].')</label>';
				$itemform = $itemform . '<a href="#" class="minus" data-theme="d" data-role="button" data-inline="true">-</a>';
				$itemform = $itemform . '<input class="count" name="'.$row['item_name'].'" id="'.$row['item_name'].'" placeholder="###" value="'.$row['min_amt'].'" type="tel">';
				$itemform = $itemform . '<a href="#" class="plus" data-theme="d" data-role="button" data-inline="true">+</a>';
				$itemform = $itemform . '</div>';
				
			
			}
			$itemform = $itemform . '<a href="#" id="nightlySubmitButton" data-theme="e" data-role="button" data-transition="fade">Submit</a>';
			$itemform = $itemform . '</form>';
			$itemform = $itemform . '<div class="response"></div>';
			
			$formjson = json_encode($itemform);
			echoexit('success',$itemform);
			
		}
		else if($params['formtype'] == "weekly"){
			$location = '';
			$itemform = '<form id="target" method="post" data-ajax="false">';
			$itemform = $itemform . '<input class="weekly" name="weekly" id="weekly" value="1" type="text" style="display:none">';
			
			$sql="SELECT * FROM weeklyinventory order by location asc";
			$result=mysql_query($sql);
			
			while($row = mysql_fetch_array($result)){
				
				if(strcmp($location,$row['location']) != 0){
					$location = $row['location'];
					$itemform = $itemform . '<h3>'.$row['location'].'</h3>';
				}
				
				$itemform = $itemform . '<div data-role="fieldcontain">';
				$itemform = $itemform . '<span class="increment" style="display:none">'.$row['increment'].'</span>';
				$itemform = $itemform . '<label for="'.$row['item_name'].'">'.$row['item_name'].'('.$row['increment'].')</label>';
				$itemform = $itemform . '<a href="#" class="minus" data-theme="d" data-role="button" data-inline="true">-</a>';
				$itemform = $itemform . '<input class="count" name="'.$row['item_name'].'" id="'.$row['item_name'].'" placeholder="###" value="'.$row['min_amt'].'" type="tel">';
				$itemform = $itemform . '<a href="#" class="plus" data-theme="d" data-role="button" data-inline="true">+</a>';
				$itemform = $itemform . '</div>';
				
			
			}
			$itemform = $itemform . '<a href="#" id="weeklySubmitButton" data-theme="e" data-role="button" data-transition="fade">Submit</a>';
			$itemform = $itemform . '</form>';
			$itemform = $itemform . '<div class="response"></div>';
			
			$formjson = json_encode($itemform);
			echoexit('success',$itemform);
		}
		else if($params['formtype'] == "deliveries"){

		}
		
	}
	
	function submit_inv_form(){
		global $params;
		$params = json_decode($params, true);
		
		//var_dump($params);
		
		$date = date("Ymd");
		$time = date("Gi");
		
		//email success flag
		$x = 0;
		
		// after array_shift, $logtype will contain the first array item, $params will contain the rest
		// $logtype will contain the logtype indicator
		$logtype = array_shift($params);

		if($logtype['name'] == 'nightly'){
			//generate nightly log and send email
			$filename = "../nightly_logs/nightly_log_".$date."_".$time.".csv";
			create_log_file($filename, $params, 'nightly');
			$x = generate_mail('nightly',$filename);
		}
		else if ($logtype['name'] == 'weekly'){
			//generate weekly log and send email
			$filename = "../weekly_logs/weekly_log_".$date."_".$time.".csv";
			create_log_file($filename, $params, 'weekly');
			$x = generate_mail('weekly',$filename);
		}

		if ($x == 1)
			echoexit("success", "Email submission successful!");
		else
			echoexit("error", "Email submission failed!");

		
		
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
		case 7:
			get_inv_form();
			break;
		case 8:
			submit_inv_form();
			break;
		default:
			echoexit("error", "Error! Unspecified action!");
			break;
	}

	
	
	

?>