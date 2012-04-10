<?
	/********************************************
	* Nightly.php
	*********************************************
	* Handles the nightly inventory form 
	* Generates submission log
	* Emails receipt to manager
	*********************************************/


?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Cabot Cafe App</title> 
	<link rel="stylesheet" href="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
</head> 

<?

	require_once("constants.php");
	
	//pull post
	$whole_f = htmlentities($_POST["whole-f"]);
	$skim_f = htmlentities($_POST["skim-f"]);
	$soy_f = htmlentities($_POST["soy-f"]);
	
	$whole_b = htmlentities($_POST["whole-b"]);
	$skim_b = htmlentities($_POST["skim-b"]);
	$soy_b = htmlentities($_POST["soy-b"]);
	
	$regbean = htmlentities($_POST["regbean"]);
	$decafbean = htmlentities($_POST["decafbean"]);
	
	$comments = htmlentities($_POST["nightinventcomment"]);
	
	//var_dump($_POST);

	$newline = "\n";
	$break = "=================================";
	
	$whole = "Whole Milk: ";
	$skim = "Skim Milk: ";
	$soy = "Soy Milk: ";
	
	$date = date("Ymd");
	$time = date("Gi");
	
	//generate log
	$filename = "nightly_logs/nightly_log_".$date."_".$time.".txt";
	$filehandle =  fopen($filename, 'w') or die("Log could not be generated. Reconnect to wifi and try again.");
	
	$datecreated = "Date Created: " . $date . $newline;
	$timecreated = "Time Created: " . $time . $newline;
	

	
	$filelog = "Nightly Inventory Log" . $newline . $newline;
	$filelog = $filelog . $datecreated . $timecreated . $break . $newline . $newline;
	
	$filelog = $filelog . "Front Fridge ". $newline . $newline;
	$filelog = $filelog . $whole . $whole_f . $newline . $newline;
	$filelog = $filelog . $skim . $skim_f . $newline . $newline;
	$filelog = $filelog . $soy . $soy_f . $newline . $newline;
	
	$filelog = $filelog . $break . $newline . $newline;
	
	$filelog = $filelog . "Back Fridge ". $newline . $newline;
	$filelog = $filelog . $whole . $whole_b . $newline . $newline;
	$filelog = $filelog . $skim . $skim_b . $newline . $newline;
	$filelog = $filelog . $soy . $soy_b . $newline . $newline;
	
	$filelog = $filelog . $break . $newline . $newline;
	
	$filelog = $filelog . "Counter ". $newline . $newline;
	$filelog = $filelog . "Reg Bean" . $regbean . $newline . $newline;
	$filelog = $filelog . "Decaf Bean" . $decafbean . $newline . $newline;
	
	$filelog = $filelog . $break . $newline . $newline;
	
	$filelog = $filelog . "Comments and name: ". $newline . $newline;
	$filelog = $filelog . $comments . $newline . $newline;
	
	fwrite($filehandle,$filelog);
	
	fclose($filehandle);
	
	//generate email
	
	$to      = $receiver_email;
	$subject = "[Cabot Cafe App] Nightly Inventory Log (".$date.")";
	$message = $filelog;
	$headers = 	'From:'. $sender_name. '<'.$sender_email.'>' . "\r\n" .
				'Reply-To: '.$sender_email . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

	$x = mail($to, $subject, $message, $headers);

	echo $x;

?>

<body>

	<!-- Start of first page -->
	<div data-role="page" id="deliver_success">

		<div data-role="header">
			<h1>Cabot Cafe App</h1>
		</div><!-- /header -->

		<div data-role="content" >	
			<h2>Nightly Inventory Log Submission Status</h2>
			
			<?
				if ($x == 1)
					echo "<p>Email submission successful!</p>";
				else
					echo "<p>Email submission failed</p>";
				
				// echo $whole_f;
				// echo $newline;
			
			?>
			<p><a href="index.php" data-role="button" data-theme="d" data-ajax="false">Home</a></p>	
		</div><!-- /content -->
		
		<div data-role="footer" data-theme="d">
			<h4>Created by Saagar Deshpande for Cabot Cafe</h4>
		</div><!-- /footer -->
	</div><!-- /page one -->


</body>

