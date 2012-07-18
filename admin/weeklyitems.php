<?

	require_once("../includes/common.php");

	$sql="SELECT * FROM weeklyinventory ORDER BY location";
	$result=mysql_query($sql);
	
?>



<!DOCTYPE html>
<html>
	<head>
		
		<title>Weekly Inventory: Cabot Cafe App</title>
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
		<script src="../scripts/required.js"></script>
		<script src="../scripts/itemscontrol.js" type="text/javascript"></script>
	</head>
	
	<body>
		
		<? navBar("dashboard");	?>
		
		<!-- TEMPORARY SPACING -->
		<br />
		<br />
		<br />
		<a href="#" class="updateItemButton" name="">Create new item</a>
		<div id = "items">
			<table>
				<tr>
					<th colspan="8"> Cabot Cafe Weekly Inventory List </th>
				</tr>
				<tr>
					<th> Location </th>
					<th> Item Name </th>
					<th> Min. Amount </th>
					<th> Max. Amount </th>
					<th> Increment </th>
					<th> Measure Type </th>
					<th> Warning Limit </th>
					<th> Actions </th>
				</tr>
				<?
				while($row = mysql_fetch_array($result)){
					echo '<tr>';
					echo '<td>'.$row['location'].'</td>';
					echo '<td>'.$row['item_name'].'</td>';
					echo '<td>'.$row['min_amt'].'</td>';
					echo '<td>'.$row['max_amt'].'</td>';
					echo '<td>'.$row['increment'].'</td>';
					echo '<td>'.$row['measure_type'].'</td>';
					echo '<td>'.$row['warning_limit'].'</td>';
					echo '<td><div id="clear">';
					echo '<a href="#" class="updateItemButton" name="'.$row['id'].'"><div id="add" class="ui-icon ui-icon-pencil"></div></a>';
					echo '<a href="#" class="deleteItemButton" name="'.$row['id'].'"><div id="del" class="ui-icon ui-icon-close"></div></a>';
					echo '</div></td>';
					echo '</tr>';
				}	
					
				?>
			
			</table>
		</div>
		<div id="itemDiag" style="display:none"><span>stuff</span></div>
		<div id="inventoryFlag" name="weekly" style="display:none"><span>If this span appears, something broke somewhere.</span></div>
	
	</body>


</html>