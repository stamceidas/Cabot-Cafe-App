<?
	ob_start();
	require_once("../includes/common.php");
	
	//if session not set, not logged in
	if(empty($_SESSION['admin'])){
		header("Location:admin.php");
	}
	
	$sql="SELECT * FROM admin";
	$result=mysql_query($sql);
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Manage Admins - Cabot Cafe App</title>
		<link rel="stylesheet" type="text/css" href="../css/smoothness/jquery-ui-1.8.21.custom.css" media="screen" />
		<style type="text/css">
			table {
				border-width: 1px;
				border-spacing: 2px;
				border-style: outset;
				border-color: gray;
				border-collapse: collapse;
				background-color: white;
			}
			table th {
				border-width: 1px;
				padding: 5px;
				border-style: inset;
				border-color: gray;
				background-color: white;
				-moz-border-radius: ;
			}
			table td {
				border-width: 1px;
				padding: 5px;
				border-style: inset;
				border-color: gray;
				background-color: white;
				-moz-border-radius: ;
			}
			
			#clear {overflow:hidden; clear:both;}
			#add {float:left;}
			#del {float: right;}
		</style>	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="../scripts/userscontrol.js" type="text/javascript"></script>
	</head>

	<body>
		<? navBar("users");	?>
			<!-- TEMPORARY SPACING -->
			<br />
			<br />
			<br />
			<?
			if ($_SESSION['sudo'])
			{
			?>
				<a href="#" class="updateUserButton" name="">Create new Admin</a>
			<?
			}
			?>
			<div id = "users">
				<table>
					<tr>
						<th colspan="10"> Cabot Cafe Admin List </th>
					</tr>
					<tr>
						<th> First Name </th>
						<th> Last Name </th>
						<th> Username </th>
						<th> Email </th>
						<th> Year </th>
						<th> Phone # </th>
						<th> Receive Log? </th>
						<th> Emergency Contact? </th>
						<th> Sudo </th>
						<th> Action </th>
					</tr>
					<?
					while($row = mysql_fetch_array($result)){
						echo '<tr>';
						echo '<td>'.$row['firstname'].'</td>';
						echo '<td>'.$row['lastname'].'</td>';
						echo '<td>'.$row['username'].'</td>';
						echo '<td>'.$row['email'].'</td>';
						echo '<td>'.$row['year'].'</td>';
						echo '<td>'.$row['tel'].'</td>';
						echo '<td>'.($row['sendto'] == 1 ? 'True':'False').'</td>';
						echo '<td>'.($row['emergency'] == 1 ? 'True':'False').'</td>';
						echo '<td>'.($row['sudo'] == 1 ? 'True':'False').'</td>';
						echo '<td>';
						if ($_SESSION['sudo']){
							echo '<div id="clear">';
							echo '<a href="#" class="updateUserButton" name="'.$row['id'].'"><div id="add" class="ui-icon ui-icon-pencil"></div></a>';
							if($_SESSION['id'] != $row['id'])
								echo '<a href="#" class="deleteUserButton" name="'.$row['id'].'"><div id="del" class="ui-icon ui-icon-close"></div></a>';
							else
								echo '<div id="del" style="display:none"></div>';
							echo '</div>';
						}
						else{
							if($_SESSION['id'] == $row['id']){
								echo '<div id="clear">';
								echo '<a href="#" class="updateUserButton" name="'.$row['id'].'"><div id="add" class="ui-icon ui-icon-pencil"></div></a>';
								echo '<div id="del" style="display:none"></div>';
								echo '</div>';
							}
						}
						echo '</td>';
						echo '</tr>';
					}	
						
					?>
				
				</table>
			</div>
			<!--<div id="userDiag" style="display:none"><span>stuff</span></div>-->
			<div>
			<?
				if ($_SESSION['sudo'])
			{
			?>
				<p> As admin, you can create new accounts, edit existing accounts, and delete all but your own account. </p>
			<?
			}
			else
			{
			?>
				<p> As a user, you can only update your own information. </p>
			<?
			}
			?>
				<b> You can always edit your PIN (not visible in table!). </b>
			
			</div>
		
		
		
	</body>
</html>
<? ob_flush(); ?>