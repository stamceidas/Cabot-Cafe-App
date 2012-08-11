<?
	require_once("../includes/common.php");

	$sql="SELECT * FROM admin WHERE username='".$_SESSION['user']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
?>


<!DOCTYPE html>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>
		<script src="../scripts/required.js"></script>
		<title>Cabot Cafe: Update Personal Info </title>
	</head>
	
	<body>
		<div align='center'>
			Update Personal Information
		</div>
		<? navBar("update"); ?>

		<form method="post" action="" id="info_form">			
			<table cellpadding="5">
			<tr>
				<td>Name</td>
				<td><input name="name" type="text" id="name" value="<?echo $row['firstname'];?>"/></td>
			</tr>
			<tr>
				<td>Username</td>
				<td><input name="username" type="text" id="username" value="<?echo $row['username'];?>"/></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="password" type="password" id="password"/></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input name="email" type="text" id="email" value="<?echo $row['email'];?>"/></td>
			</tr>
			<tr>
				<td>Year</td>
				<td><input name="year" type="text" id="year" value="<?echo $row['year'];?>"/></td>
			</tr>
		</table>
			<input name="Submit" type="submit" id="submit" value="Submit" />
			<div id="formmsg"></div>
			<br>
		</form>
	</body>
</html>