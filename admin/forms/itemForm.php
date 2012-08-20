<?

	require_once("../../includes/common.php");
	//if session not set, not logged in
	if(empty($_SESSION['user'])){
		header("Location:admin.php");
	}
	
	$itemid=mysql_real_escape_string($_POST["id"]);
	$itemtype=mysql_real_escape_string($_POST["itemType"]);
	if(!empty($itemid)){
		if($itemtype == "nightly")
			$sql="SELECT * FROM nightlyinventory WHERE id='".$itemid."'";
		else if ($itemtype == "weekly")
			$sql="SELECT * FROM weeklyinventory WHERE id='".$itemid."'";
		$result=mysql_query($sql);
		$row = mysql_fetch_array($result);
		// create form with item's information
		
		$formStr = '<form id="itemform" name="'.$itemid.'"><table>'
					.'<tr><td id="label">Item Name:</td><td id="field"><input type="text" id="itemname" value="'.$row['item_name'].'"/></td></tr>'
					.'<tr><td id="label">Location: </td><td id="field"><input type="text" id="location" value="'.$row['location'].'"/></td></tr>'
					.'<tr><td id="label">Min. Amount: </td><td id="field"><input type="text" id="minamt" value="'.$row['min_amt'].'"/></td></tr>'
					.'<tr><td id="label">Max. Amount: </td><td id="field"><input type="text" id="maxamt" value="'.$row['max_amt'].'"/></td></tr>'
					.'<tr><td id="label">Increment: </td><td id="field"><input type="text" id="increment" value="'.$row['increment'].'"/></td></tr>'
					.'<tr><td id="label">Measure Type: </td><td id="field"><input type="text" id="measure_type" value="'.$row['measure_type'].'"/></td></tr>'
					.'<tr><td id="label">Warning Limit: </td><td id="field"><input type="text" id="warning_limit" value="'.$row['warning_limit'].'"/></td></tr>'
					.'</table>'
					.'<input type="submit" value="Submit" style="display:none"/>'
					.'<div id="msgbox" style="display:none"><span>content</span></div>'
					.'</form>';
	}
	else{
		// create blank form
		
		$formStr = '<form id="itemform" name=""><table>'
					.'<tr><td id="label">Item Name:</td><td id="field"><input type="text" id="itemname"/></td></tr>'
					.'<tr><td id="label">Location: </td><td id="field"><input type="text" id="location" /></td></tr>'
					.'<tr><td id="label">Min. Amount: </td><td id="field"><input type="text" id="minamt" /></td></tr>'
					.'<tr><td id="label">Max Amount: </td><td id="field"><input type="text" id="maxamt"/></td></tr>'
					.'<tr><td id="label">Increment: </td><td id="field"><input type="text" id="increment" /></td></tr>'
					.'<tr><td id="label">Measure Type: </td><td id="field"><input type="text" id="measure_type"/></td></tr>'
					.'<tr><td id="label">Warning Limit: </td><td id="field"><input type="text" id="warning_limit"/></td></tr>'
					.'</table>'
					.'<input type="submit" value="Submit" style="display:none"/>'
					.'<div id="msgbox" style="display:none"><span>content</span></div>'
					.'</form>';
	
	}
	
	
	echo json_encode(array('msg' => 'success', 'form' => $formStr));



?>

