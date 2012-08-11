<?

    /***********************************************************************
     * common.php
     *
     *
     * Contains all generic/universal code
     **********************************************************************/

	//start session to use on every page
	if(session_id() == ''){
		session_start();
	}
	
    require_once("constants.php");

	// check connection to database to see if app is live 
    if (($connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE){
        echo "Cabot Cafe Inventory application is down!";
		echo "Check internet connectivity! <br> Error: Could not connect to database server. Check database information in constants.php. <br>";
		exit();
	}
    if (@mysql_select_db(DB_NAME, $connection) === FALSE){
        echo "Cabot Cafe Inventory application is down!";
		echo"Error: Could not select database (" . DB_NAME . ").";
		exit();
	}
	
    //generate password hash with blowfish. fallback is sha1 until HCS upgrades from PHP 5.2.4
	//for blowfish, salt needs to be 22 char from ./0-9A-Za-z
    function passGen($password, $salt){
		// this function by default should use crypt with blowfish.
		// I used SHA1 because HCS operates with PHP 5.2.4 and is badly in need of upgrade
		// on systems with 5.3.x, there is no reason NOT to use blowfish
	
		//contains blowfish identifier and cost param after middle $
		$saltpre = "$2a$10$"; 
		
        //comment in the crypt line to use blowfish, comment in sha1 line to use sha1
		//return crypt($password, $saltpre.$salt);
		return sha1($password.$salt);
    }

	//generate navbar for each page in backend
	function navBar($page){
		
		//generate simple userbox
		echo "<div id='userbox'>";
			echo "Hello there, ". $_SESSION['firstname'] . " || ";
			echo '<a href="#" class="updateUserButton" name="'.$_SESSION['id'] .'">Edit Your Account Info</div></a>';
			//if($page != "users") 
				echo '<div id="userDiag" style="display:none"><span>stuff</span></div>';
		echo "</div>"; 
		
		//generate the menu bar links
		echo "<div id='menu'>";
			echo	"|| <a href='dashboard.php?logout'><b>Logout</b></a> || ";
			if($page != "dashboard") echo "<a href='dashboard.php'>Dashboard</a> || ";
			//if($page != "update") echo "<a href='update.php'>Update Admin Info</a> || ";
			//if ($_SESSION['sudo']) echo "<a href='users.php'>Manage Admins</a> || ";
			if($page != "users")echo "<a href='users.php'>Manage Employees</a> || ";
			//if($page != "employees") echo "<a href='employees.php'>Manage Cafe Employees</a> || ";
			if($page != "nightitems") echo "<a href='nightitems.php'>Manage Nightly Inventory Page</a> || ";
			if($page != "weeklyitems") echo "<a href='weeklyitems.php'>Manage Weekly Inventory Page</a> || ";
		echo "</div>";
	}

	//generate the footer for each page in frontend
	function liveFooter(){
		echo '<!-- /footer -->';
		echo '<div data-role="footer">';
		echo '<h4>Created by Saagar Deshpande for Cabot Cafe</h4>';
		echo '</div>';
	}
	
	//generate the emergency contacts for frontend
	function liveEmergency(){
		$sql = "SELECT * FROM admin WHERE emergency = 1";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			echo '<p>'.$row['firstname'].' '.$row['lastname'].': <a href="mailto:'.$row['email'].'"> '.$row['email'].'</a>'.': <a href="tel:'.$row['tel'].'"> '.$row['tel'].'</a>'.'</p>';
		}
	}
	
	//generate the usage tips for the frontend forms
	function invMenuUsage(){
		$str = 'Use the +/- buttons to change the value of the item. <br> The number in () is the increment value. <br> You can also click on the text bar and fill in a custom value.<br>';
		echo $str;
	}
	
	//generate the salt for the password validation
	function genSalt($lenth = 22) {
		// makes a random alpha numeric string of a given lenth
		$aZ09 = array_merge(range('A', 'Z'), range('a', 'z'),range(0, 9));
		$out ='';
		for($c=0;$c < $lenth;$c++) {
		   $out .= $aZ09[mt_rand(0,count($aZ09)-1)];
		}
		return $out;
	}


?>
