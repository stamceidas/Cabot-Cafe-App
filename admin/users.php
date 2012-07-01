<?
	require_once("../includes/common.php");
	
	$sql="SELECT * FROM admin";
	$result=mysql_query($sql);
	
?>

<!DOCTYPE html>
<html>
	<head>
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
		</style>	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		<script src="../scripts/userscontrol.js" type="text/javascript"></script>
		

	</head>

	<body>
		<? navBar("dashboard");	?>
		<?
			if ($_SESSION['sudo'])
		{
		?>
			<!-- TEMPORARY SPACING -->
			<br />
			<br />
			<br />
			<a href="#" class="updateUserButton" name="">Create new Admin</a>
			<div id = "users">
				<table>
					<tr>
						<th colspan="7"> Cabot Cafe Admin List </th>
					</tr>
					<tr>
						<th> First Name </th>
						<th> Last Name </th>
						<th> Username </th>
						<th> Email </th>
						<th> Year </th>
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
						echo '<td>'.($row['sudo'] == 1 ? 'True':'False').'</td>';
						echo '<td><a href="#" class="updateUserButton" name="'.$row['id'].'"><span class="ui-icon ui-icon-pencil"></span></td>';
						echo '</tr>';
					}	
						
					?>
				
				</table>
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
