<!DOCTYPE html> 
<?
	require_once("includes/common.php");
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	
?>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Cabot Cafe App</title> 
	<link rel="stylesheet" href="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
	<script src="scripts/frontend.js"></script>
</head> 

	
<body> 

<!-- Start of first page: #one -->
<div data-role="page" id="home">

	<div data-role="header">
		<h1>Cafe Bean</h1>
	</div><!-- /header -->

	<div data-role="content" >	
		<h2>Welcome to the Cabot Cafe Inventory Application!</h2>
		
		<form action="" method="post" data-ajax="false">
			<h2>Enter Cafe Bean: Employee Login</h2>
			<label for="pinbox">Enter Employee PIN to log in:</label>
			<input type="tel" name="pinbox" id="pinbox" placeholder="4 Digit PIN"/>
			<!--<button type="submit" id="" data-theme="e" name="submit" value="submit-value" style="display:none">Submit</button>-->
		</form>
		<a href="#" id="pinSubmitButton" data-theme="e" data-role="button" data-transition="fade">Login</a>
		<p><a href="#emergency"data-role="button" data-rel="dialog" data-transition="pop">Emergency!</a></p>
	</div><!-- /content -->
	
	<? liveFooter(); ?>
</div><!-- /page one -->

<!-- Start of pop-up page: #emergency -->
<div data-role="page" id="emergency">

	<div data-role="header" data-theme="e">
		<h1>Emergency!</h1>
	</div><!-- /header -->

	
	
	<div data-role="content" data-theme="d">
		<h2>Contact Numbers</h2>
		<? liveEmergency(); ?>
		<p><a href="#home" data-rel="back" data-role="button" data-inline="true" data-icon="back">Home</a></p>	
	</div><!-- /content -->
	
	
	
	<? liveFooter(); ?>
</div><!-- /page popup -->


</body>
</html>