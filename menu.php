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
		<p><a href="#nightly" data-role="button" id="nightlyInvButton">Nightly Inventory</a></p>
		<p><a href="#weekly" data-role="button">Weekly Inventory</a></p>
		<p><a href="#deliveries" data-role="button">Deliveries</a></p>
		
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
		<span class="minus">-</span>
		<!--<span class="count">0</span>-->
		<input class="count" name="" id="textinput1" placeholder="" value="2" type="">
		<span class="plus" >+</span>
	</div>
	<div data-role="content" data-theme="d">
		<span class="minus">-</span>
		<!--<span class="count">0</span>-->
		<input class="count" name="" id="textinput1" placeholder="" value="2" type="">
		<span class="plus" >+</span>
	</div>
	
	<div id="testing">
	
	</div>
	
	<div id="nightlyformcapsule" data-role="content" data-theme="d">	
		<form action="nightly.php" method="post" data-ajax="false">
			<h3>Front Fridge</h3>
				<h4> How many cartons left? </h4>
				
				<div data-role="fieldcontain">
					<span class="increment" style="display:none">2</span>
					<label for="box1">box1</label>
					<a href="#" class="minus" data-theme="d" data-role="button" data-inline="true">-</a>
					<input class="count" name="box1" id="textinput1" placeholder="" value="2" type="tel">
					<a href="#" class="plus" data-theme="d" data-role="button" data-inline="true">+</a>
				</div>
				<div data-role="fieldcontain">
					<span class="increment" style="display:none">.25</span>
					<label for="box1">box2</label>
					<a href="#" class="minus" data-theme="d" data-role="button" data-inline="true">-</a>
					<input class="count" name="box2" id="textinput2" placeholder="" value="2" type="tel">
					<a href="#" class="plus" data-theme="d" data-role="button" data-inline="true">+</a>
				</div>
				
				<label for="whole-f">Whole Milk:</label>
				<input type="range" name="whole-f" id="whole-f" value="10" min="0" max="20"  />
			
				<label for="skim-f">Skim Milk:</label>
				<input type="range" name="skim-f" id="skim-f" value="10" min="0" max="20"  />
			
				<label for="soy-f">Soy Milk:</label>
				<input type="range" name="soy-f" id="soy-f" value="10" min="0" max="20"  />
				
			<h3>Back Fridge</h3>
				<h4> How many cartons left? </h4>
				
				<label for="whole-b">Whole Milk:</label>
				<input type="range" name="whole-b" id="whole-b" value="10" min="0" max="20"  />
			
				<label for="skim-b">Skim Milk:</label>
				<input type="range" name="skim-b" id="skim-b" value="10" min="0" max="20"  />
			
				<label for="soy-b">Soy Milk:</label>
				<input type="range" name="soy-b" id="soy-b" value="10" min="0" max="20"  />
				
			<h3>Counter</h3>
				<h4> How much of the bag is left?</h4>
			
				<label for="regbean">Regular Beans:</label>
				<input type="range" name="regbean" id="regbean" value="0.5" min="0" max="1" step="0.1"  />

				<label for="decafbean">Decaf Beans:</label>
				<input type="range" name="decafbean" id="decafbean" value="0.5" min="0" max="1" step="0.1"  />
			
			<h3>Misc </h3>	
			
				<label for="nightinventcomment">Comments and name:</label><br>
				<textarea cols="40" rows="8" name="nightinventcomment" id="nightinventcomment"></textarea>
				
				<a href="#" id="nightlySubmitButton" data-theme="e" data-role="button" data-transition="fade">Submit</a>
				<button type="submit" data-theme="e" name="submit" value="submit-value">Submit</button>
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
		<form action="weekly.php" method="post" data-ajax="false">
			<h3>Baked Goods</h3>

				<label for="whole-f">Whole Milk:</label>
				<input type="range" name="whole-f" id="whole-f" value="10" min="0" max="20"  />
			
				<label for="skim-f">Skim Milk:</label>
				<input type="range" name="skim-f" id="skim-f" value="10" min="0" max="20"  />
			
				<label for="soy-f">Soy Milk:</label>
				<input type="range" name="soy-f" id="soy-f" value="10" min="0" max="20"  />
				
			<h3>Back Fridge</h3>
				
				<label for="whole-b">Whole Milk:</label>
				<input type="range" name="whole-b" id="whole-b" value="10" min="0" max="20"  />
			
				<label for="skim-b">Skim Milk:</label>
				<input type="range" name="skim-b" id="skim-b" value="10" min="0" max="20"  />
			
				<label for="soy-b">Soy Milk:</label>
				<input type="range" name="soy-b" id="soy-b" value="10" min="0" max="20"  />
				
			<h3>Counter</h3>
			
				<label for="regbean">Regular Beans:</label>
				<input type="range" name="regbean" id="regbean" value="0.5" min="0" max="1" step="0.1"  />

				<label for="decafbean">Decaf Beans:</label>
				<input type="range" name="decafbean" id="decafbean" value="0.5" min="0" max="1" step="0.1"  />
			
			<h3>Misc </h3>	
			
				<label for="nightinventcomment">Comments and name:</label><br>
				<textarea cols="40" rows="8" name="nightinventcomment" id="nightinventcomment"></textarea>
				
				
				<button type="submit" data-theme="e" name="submit" value="submit-value">Submit</button>
		</form>
		
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


</body>
</html>