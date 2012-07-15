<?

	require_once("../../includes/common.php");
	//if session not set, not logged in
	if(empty($_SESSION['user'])){
		header("Location:admin.php");
	}
	if (!$_SESSION['sudo']){
		echo json_encode(array('msg' => 'error', 'form' => "Error! You broke something!"));
		exit();
	}
	
	$userid=mysql_real_escape_string($_POST["id"]);
	if(!empty($userid)){
		$sql="SELECT * FROM admin WHERE id='".$userid."'";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		// create form with user's information
		$isSudo = '';
		if($row['sudo'] == 1){
			$isSudo = 'checked';
		}
		
		$formStr = '<form id="userform" name="'.$userid.'"><table>'
					.'<tr><td id="label">Username:</td><td id="field"><input type="text" id="username" value="'.$row['username'].'" readonly/></td></tr>'
					.'<tr><td id="label">Password: </td><td id="field"><input type="password" id="password" /></td></tr>'
					.'<tr><td id="label">Reenter Password: </td><td id="field"><input type="password" id="password2" /></td></tr>'
					.'<tr><td id="label">First Name: </td><td id="field"><input type="text" id="firstname" value="'.$row['firstname'].'"/></td></tr>'
					.'<tr><td id="label">Last Name: </td><td id="field"><input type="text" id="lastname" value="'.$row['lastname'].'"/></td></tr>'
					.'<tr><td id="label">Email: </td><td id="field"><input type="text" id="email" value="'.$row['email'].'"/></td></tr>'
					.'<tr><td id="label">Year: </td><td id="field"><input type="text" id="year" value="'.$row['year'].'"/></td></tr>'
					.'<tr><td><input type="checkbox" id="sudo" value="true" '.$isSudo.'/> Super Admin</td></tr>'
					.'</table>'
					.'* Super Admins can manage Cafe Dashboard users.'
					.'<input type="submit" value="Submit" style="display:none"/>'
					.'<div id="msgbox" style="display:none"><span>content</span></div>'
					.'</form>';
	}
	else{
		// create blank form
		
		$formStr = '<form id="userform" name=""><table>'
					.'<tr><td id="label">Username:</td><td id="field"><input type="text" id="username"/></td></tr>'
					.'<tr><td id="label">Password: </td><td id="field"><input type="password" id="password" /></td></tr>'
					.'<tr><td id="label">Reenter Password: </td><td id="field"><input type="password" id="password2" /></td></tr>'
					.'<tr><td id="label">First Name: </td><td id="field"><input type="text" id="firstname"/></td></tr>'
					.'<tr><td id="label">Last Name: </td><td id="field"><input type="text" id="lastname" /></td></tr>'
					.'<tr><td id="label">Email: </td><td id="field"><input type="text" id="email"/></td></tr>'
					.'<tr><td id="label">Year: </td><td id="field"><input type="text" id="year"/></td></tr>'
					.'<tr><td><input type="checkbox" id="sudo" value="true" /> Super Admin</td></tr>'
					.'</table>'
					.'* Super Admins can manage Cafe Dashboard users.'
					.'<input type="submit" value="Submit" style="display:none"/>'
					.'<div id="msgbox" style="display:none"><span>content</span></div>'
					.'</form>';
	
	}
	
	
	echo json_encode(array('msg' => 'success', 'form' => $formStr));



?>

