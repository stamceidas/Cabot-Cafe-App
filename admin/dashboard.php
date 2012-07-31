<?
	require_once("../includes/common.php");
	
	//if session not set, not logged in
	if(empty($_SESSION['user'])){
		header("Location:admin.php");
	}
	
	//if logout then destroy the session and redirect the user
	if(isset($_GET['logout'])){
	  session_destroy();
	  header("Location:admin.php");
	}
	
	
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/smoothness/jquery-ui-1.8.21.custom.css" media="screen" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="../scripts/required.js"></script>
		<script src="../scripts/userscontrol.js" type="text/javascript"></script>
		<title>Cabot Cafe: <? print($_SESSION['firstname']."'s " ); ?> Dashboard </title>
	</head>
	
	<body>
		<div align='center'>
			Welcome to the Cabot Cafe Admin Dashboard!
		</div>
		<? navBar("dashboard");	?>
		
		
		
	
	</body>


</html>