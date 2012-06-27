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
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>
		<script src="../scripts/required.js"></script>
		<title>Cabot Cafe: <? print($_SESSION['name']."'s " ) ?> Dashboard </title>
	</head>
	
	<body>
		<div align='center'>
			Welcome to the Cabot Cafe Admin Dashboard!
		</div>
		<? navBar("dashboard");	?>
		
		
		
	
	</body>


</html>