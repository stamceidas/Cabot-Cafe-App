<!DOCTYPE html>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function() {
			$("#add").click(function() {
			  $('#mytable tbody>tr:last').clone(true).insertAfter('#mytable tbody>tr:last');
			  $('#mytable tbody>tr:last #name').val('');
			  $("#mytable tbody>tr:last").each(function() {this.reset();});
			  return false;
			});
		});
		</script>

	</head>

	<body>
		<form method="post" action="" id="admin_form">
		<form id="personas" name="personas" method="post" action="">
			<a href="#" id="add">Add</a>
			
			  <table id="mytable" width="300" border="1" cellspacing="0" cellpadding="2">
				<tbody>
					<tr>
					  <td>Name</td>
					</tr>
					<tr class="person">
					  <td><input type="text" name="name[]" id="name" /></td>
					</tr>
				</tbody>
			  </table>
			  
			<input name="Submit" type="submit" id="submit" value="Submit" />
			<div id="loginmsg"></div>
			<br>
		</form>
	</body>
</html>
