<?
	require_once("../includes/common.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="../css/smoothness/jquery-ui-1.8.21.custom.css" media="screen" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="../scripts/userscontrol.js" type="text/javascript"></script>
		

	</head>

	<body>
		
		<?
			if ($_SESSION['sudo'])
		{
		?>
			<a href="#" id="addUserButton" >Add Box</a>
			<div id = "users">
					
			</div>
			<div id="userDiag" style="display:none"><span>stuff</span></div>
		<?
		}
		else
		{
		?>
			<p> You don't have priviledge to edit users!</p>
		<?
		}
		?>
		
		
		
		
	</body>
</html>
