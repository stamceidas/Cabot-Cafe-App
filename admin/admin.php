<?
	require_once("../includes/common.php");

	
	if(!empty($_SESSION['user'])){
		header("Location:dashboard.php");
	}
		
?>

<!DOCTYPE html>
<html>

	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>
		<script src="../scripts/required.js"></script>
		<title>Cabot Cafe Admin Panel Login</title>
	</head>


	<body>
					
		<div id="login_container">
			<h3>Login</h3>
			<form method="post" action="" id="login_form">
				Username: 	<input name="username" type="text" id="username"/><br>
				Password: 	<input name="password" type="password" id="password"/><br>
				<input name="Submit" type="submit" id="submit" value="Login" />
				<div id="loginmsg"></div>
				<br>
			</form>
		</div>
		
	</body>

</html>
