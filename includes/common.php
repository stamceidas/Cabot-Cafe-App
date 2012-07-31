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

    if (($connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE)
        echo "Check internet connectivity! <br> Error: Could not connect to database server. Check database information in constants.php. <br>";
    if (@mysql_select_db(DB_NAME, $connection) === FALSE)
        echo"Error: Could not select database (" . DB_NAME . ").";
	
	//start session to use on every page
	//session_start();
	
	
	
    //generate password hash with blowfish
    function passGen($password, $salt){
		//need 22 char salt from ./0-9A-Za-z
		$saltpre = "$2a$10$"; //contains blowfish identifier and cost param after middle $
        return crypt($password, $saltpre.$salt);
    }

	//generate navbar for each page
	function navBar($page){
		
		echo "<div id='userbox'>";
			echo "Hello there, ". $_SESSION['firstname'] . " || ";
			echo '<a href="#" class="updateUserButton" name="'.$_SESSION['id'] .'">Edit Your Account Info</div></a>';
			echo '<div id="userDiag" style="display:none"><span>stuff</span></div>';
		echo "</div>"; 
	
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
