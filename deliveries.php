<?

	require_once("constants.php");
	
	//pull post
	$arrivals = mysql_real_escape_string($_POST["arrivals_text"]);
	$happens = mysql_real_escape_string($_POST["happens_text"]);
	$comments = mysql_real_escape_string($_POST["comments_text"]);
	
	$newline = "\n";
	
	echo $arrivals;
	echo $newline;
	echo $happens;
	echo $newline;
	echo $comments;
	
	
	$date = date("Ymd");
	$time = date("Gi");
	//generate log
	$filename = "delivery_logs\\delivery_log_".$date."_".$time.".txt";
	$filehandle =  fopen($filename, 'w') or die("Log could not be generated. Reconnect to wifi and try again.");
	
	$filelog = "What arrived and how many?\n";
	$filelog = $filelog . $arrivals . $newline . $newline;
	$filelog = $filelog . "What arrived and how many?\n";
	$filelog = $filelog . $happens . $newline . $newline;
	$filelog = $filelog . "What arrived and how many?\n";
	$filelog = $filelog . $comments . $newline . $newline;
	
	fwrite($filehandle,$filelog);
	
	fclose($filehandle);
	
	//generate email
	
	$to      = $receiver_email;
	$subject = "[Cabot Cafe App] Delivery Log (".$date.")";
	$message = $filelog;
	$headers = 	'From:'. $sender_name. '<'.$sender_email.'>' . "\r\n" .
				'Reply-To: '.$sender_email . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

	$x = mail($to, $subject, $message, $headers);

	echo $x;


?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<title>Cabot Cafe App</title> 
	<link rel="stylesheet" href="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.css" />
	<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script src="//code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js"></script>
</head> 

<body>

	<!-- Start of first page -->
	<div data-role="page" id="deliver_success">

		<div data-role="header">
			<h1>Cabot Cafe App</h1>
		</div><!-- /header -->

		<div data-role="content" >	
			<h2>Delivery Submission Status</h2>
			
			<?
				if ($x == 1)
					echo "<p>Email submission successful!</p>";
				else
					echo "<p>Email submission failed</p>";
			?>
			<p><a href="index.php" data-direction="reverse" data-role="button" data-theme="d">Home</a></p>	
		</div><!-- /content -->
		
		<div data-role="footer" data-theme="d">
			<h4>Created by Saagar Deshpande for Cabot Cafe</h4>
		</div><!-- /footer -->
	</div><!-- /page one -->


</body>

