<?

	require_once("../../includes/common.php");
	//if session not set, not logged in
	if(empty($_SESSION['user'])){
		header("Location:admin.php");
	}

	// create form
	
	$formStr = '<form id="userform" name="">'
				.'Username: <input type="text" id="username" /><br />'
				.'First Name: <input type="text" id="firstname" /><br />'
				.'Last Name: <input type="text" id="lastname" /><br />'
				.'Email: <input type="text" id="email" /><br />'
				.'Year: <input type="text" id="year" /><br />'
				.'<input type="checkbox" id="sudo" value="true" /> Super Admin<br />'
				.'* Super Admins can manage Cafe Dashboard users.'
				.'<input type="submit" value="Submit" style="display:none"/>'
				.'<div id="msgbox" style="display:hidden"><span>content</span></div>'
				.'</form>';

	echo json_encode(array('msg' => 'success', 'form' => $formStr));



?>

