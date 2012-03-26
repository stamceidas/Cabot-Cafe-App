<!DOCTYPE html> 
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Cabot Cafe App</title> 
	<link rel="stylesheet" href="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
</head> 

	
<body> 

<!-- Start of first page: #one -->
<div data-role="page" id="home">

	<div data-role="header">
		<h1>Cabot Cafe App</h1>
	</div><!-- /header -->

	<div data-role="content" >	
		<h2>Welcome to the Cabot Cafe Application!</h2>
		
		<h3>Buttons</h3>
		<p><a href="#nightly" data-role="button">Nightly Inventory</a></p>
		<p><a href="#weekly" data-role="button">Weekly Inventory</a></p>
		<p><a href="#deliveries" data-role="button">Deliveries</a></p>
		<p><a href="#emergency"data-role="button" data-rel="dialog" data-transition="pop">Emergency!</a></p>
	</div><!-- /content -->
	
	<div data-role="footer" data-theme="d">
		<h4>Created by Saagar Deshpande for Cabot Cafe</h4>
	</div><!-- /footer -->
</div><!-- /page one -->


<!-- Start of second page: #nightly -->
<div data-role="page" id="nightly" data-theme="d">

	<div data-role="header">
		<h1>Nightly Inventory</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Two</h2>
		<p>I have an id of "two" on my page container. I'm the second page container in this multi-page template.</p>	
		<p>Notice that the theme is different for this page because we've added a few <code>data-theme</code> swatch assigments here to show off how flexible it is. You can add any content or widget to these pages, but we're keeping these simple.</p>	
		<p><a href="#home" data-direction="reverse" data-role="button" data-theme="d">Home</a></p>	
		
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page two -->

<!-- Start of third page: #weekly -->
<div data-role="page" id="weekly" data-theme="d">

	<div data-role="header">
		<h1>Weekly Inventory</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Two</h2>
		<p>I have an id of "two" on my page container. I'm the second page container in this multi-page template.</p>	
		<p>Notice that the theme is different for this page because we've added a few <code>data-theme</code> swatch assigments here to show off how flexible it is. You can add any content or widget to these pages, but we're keeping these simple.</p>	
		<p><a href="#home" data-direction="reverse" data-role="button" data-theme="d">Home</a></p>	
		
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
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

<!-- Start of pop-up page: #emergency -->
<div data-role="page" id="emergency">

	<div data-role="header" data-theme="e">
		<h1>Dialog</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Popup</h2>
		<p>I have an id of "popup" on my page container and only look like a dialog because the link to me had a <code>data-rel="dialog"</code> attribute which gives me this inset look and a <code>data-transition="pop"</code> attribute to change the transition to pop. Without this, I'd be styled as a normal page.</p>		
		<p><a href="#home" data-rel="back" data-role="button" data-inline="true" data-icon="back">Home</a></p>	
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page popup -->

</body>
</html>