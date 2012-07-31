<?
	//log in server validation
	require_once("../includes/common.php");

	//get the posted values
	$user=mysql_real_escape_string($_POST["user"]);
	// $user = 'ichen';
	//uncomment this to add password hashing
	//$pass= passGen(mysql_real_escape_string($_POST["pass"]));
	$pass= mysql_real_escape_string($_POST["pass"]);
	// $pass = 'test';

	//now validating the username and password
	$sql="SELECT * FROM admin WHERE username='".$user."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	
	//var_dump($row);
	
	//if username exists
	if(mysql_num_rows($result)>0)
	{
			//compare the password
			//if(strcmp($row['password'],$pass)==0)
			
			if(strcmp($row['password'],passGen($pass,$row['salt']))==0)
			{
				echo "1";
				//now set the session from here if needed
				$_SESSION['user']=$row['username'];
				$_SESSION['firstname']=$row['firstname'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['sudo'] = $row['sudo'];
				
				//echo $_SESSION['user'];
			}
			else
					echo "0";
	}
	else
			echo "0"; 
		
?>