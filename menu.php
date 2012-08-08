<!DOCTYPE html> 
<?
	require_once("includes/common.php");
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	
	//if session not set, not logged in
	if(empty($_SESSION['user'])){
		header("Location:index.php");
	}
	
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
	<script type="text/javascript">  
		$(function() {

			// Need to use .live to make sure jqm loads script live for any content loaded via ajax
			// necessary for inventory forms
			
			// $('.minus').click(function() {
			$('.minus').live('click',function() {
				// parse as float to avoid NaN errors and appending numbers as strings
				var value = parseFloat($(this).parents('div').children('.count').val());
				var increment = parseFloat($(this).parents('div').children('.increment').text());
				if (value == 0) return;
				value-=increment;
				$(this).parents('div').children('.count').val(value);
			});

			// $('.plus').click(function() {
			$('.plus').live('click',function() {
				// parse as float to avoid NaN errors and appending numbers as strings
				var value = parseFloat($(this).parents('div').children('.count').val());
				var increment = parseFloat($(this).parents('div').children('.increment').text());
				value+=increment;
				$(this).parents('div').children('.count').val(value);
			});
		});
	</script>
	
</head> 

	
<body> 

<!-- Start of first page: #one -->
<div data-role="page" id="home">

	<div data-role="header">
		<h1>Cafe Bean</h1>
	</div><!-- /header -->

	<div data-role="content" >	
		<h3>Inventory Options</h3>
		<p><a href="#nightly" data-role="button" id="nightlyInvButton" name="nightly">Nightly Inventory</a></p>
		<p><a href="#weekly" data-role="button" id="weeklyInvButton" name="weekly">Weekly Inventory</a></p>
		<p><a href="#deliveries" data-role="button">Deliveries</a></p>
		
	</div><!-- /content -->
	
	<div data-role="footer" data-theme="d">
		<h4>Created by Saagar Deshpande for Cabot Cafe</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


<!-- Start of second page: #nightly -->
<div data-role="page" id="nightly" data-theme="d">
	
	<!-- header -->
	<div data-role="header">
		<h1>Nightly Inventory</h1>
	</div>
	<!-- /header -->
	
	<!-- content -->
	<div id="nightlyformcapsule" data-role="content" data-theme="d">	
		<form action="nightly.php" method="post" data-ajax="false"></form>
	</div>
	<!-- /content -->
	
	<p><a href="#home" data-direction="reverse" data-role="button" data-theme="d">Home</a></p>
	
	<? liveFooter(); ?>
	
</div><!-- /page two -->

<!-- Start of third page: #weekly -->
<div data-role="page" id="weekly" data-theme="d">
	
	<!-- header -->
	<div data-role="header">
		<h1>Weekly Inventory</h1>
	</div>
	<!-- /header -->

	<!-- content -->
	<div id="weeklyformcapsule" data-role="content" data-theme="d">	
		<form action="weekly.php" method="post" data-ajax="false"></form>
	</div>
	<!-- /content -->
	
	<p><a href="#home" data-direction="reverse" data-role="button" data-theme="d">Home</a></p>
	
	<? liveFooter(); ?>

</div><!-- /page three -->

<!-- Start of fourth page: #deliveries -->
<div data-role="page" id="deliveries" data-theme="d">

	<div data-role="header">
		<h1>Deliveries</h1>
	</div><!-- /header -->
	

	<div data-role="content" data-theme="d">	
		<h2>Please fill the following form:</h2>
		<!-- deliveries form -->
		<form action="deliveries.php" method="post" data-ajax="false">
			<div data-role="fieldcontain">
				<label for="arrivals_text">What arrived and how many?:</label><br>
				<textarea cols="40" rows="8" name="arrivals_text" id="arrivals_text"></textarea>
			</div>
			<div data-role="fieldcontain">
				<label for="happens_text">What did you do with it?:</label><br>
				<textarea cols="40" rows="8" name="happens_text" id="happens_text"></textarea>
			</div>
			<div data-role="fieldcontain">
				<label for="comments_text">Comments and name:</label><br>
				<textarea cols="40" rows="8" name="comments_text" id="comments_text"></textarea>
			</div>
			<button type="submit" data-theme="e" name="submit" value="submit-value">Submit</button>
		</form>
	
		<p><a href="#home" data-direction="reverse" data-role="button" data-theme="d">Home</a></p>	
	
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page four -->


</body>
</html>