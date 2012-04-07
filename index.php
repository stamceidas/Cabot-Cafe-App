<!DOCTYPE html> 
<?
	session_start();
	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	//header("Location: #");
	// sleep(3);
	// if(isset($_SESSION['reloaded'])){
		// $_SESSION['reloaded']=false; 
	// } 
	// else{ 
		// $_SESSION['reloaded']=true; 
		// header("Location: #");
	// }
?>

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
		<h3>Front Fridge</h3>
			<h4> How many cartons left? </h4>
			<form>
				<label for="whole-f">Whole Milk:</label>
				<input type="range" name="whole-f" id="whole-f" value="10" min="0" max="20"  />
			</form>
			<form>
				<label for="skim-f">Skim Milk:</label>
				<input type="range" name="skim-f" id="skim-f" value="10" min="0" max="20"  />
			</form>
			<form>
				<label for="soy-f">Soy Milk:</label>
				<input type="range" name="soy-f" id="soy-f" value="10" min="0" max="20"  />
			</form>
		
		<h3>Back Fridge</h3>
			<h4> How many cartons left? </h4>
			<form>
				<label for="whole-b">Whole Milk:</label>
				<input type="range" name="whole-b" id="whole-b" value="10" min="0" max="20"  />
			</form>
			<form>
				<label for="skim-b">Skim Milk:</label>
				<input type="range" name="skim-b" id="skim-b" value="10" min="0" max="20"  />
			</form>
			<form>
				<label for="soy-b">Soy Milk:</label>
				<input type="range" name="soy-b" id="soy-b" value="10" min="0" max="20"  />
			</form>
		
		<h3>Counter</h3>
			<h4> How much of the bag is left?</h4>
			<form>
				<label for="regbean">Regular Beans:</label>
				<input type="range" name="regbean" id="regbean" value="0.5" min="0" max="1" step="0.1"  />
			</form>
			<form>
				<label for="decafbean">Decaf Beans:</label>
				<input type="range" name="decafbean" id="decafbean" value="0.5" min="0" max="1" step="0.1"  />
			</form>
		
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
		<h1>Emergency??</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">	
		<h2>Contact Numbers</h2>
		<p> Jesse Kaplan: tel: 5555555 </p>
		<p> (note: need to admin panel this) </p>
		<p><a href="#home" data-rel="back" data-role="button" data-inline="true" data-icon="back">Home</a></p>	
	</div><!-- /content -->
	
	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page popup -->

</body>
</html>