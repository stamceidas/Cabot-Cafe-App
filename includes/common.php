<?

    /***********************************************************************
     * common.php
     *
     *
     * Contains all generic/universal code
     **********************************************************************/

    require_once("constants.php");

    if (($connection = @mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE)
        echo "Check internet connectivity! <br> Error: Could not connect to database server. Check database information in constants.php. <br>";
    if (@mysql_select_db(DB_NAME, $connection) === FALSE)
        echo"Error: Could not select database (" . DB_NAME . ").";
	
	session_start();
	
    //generate password using md5 hash.
    //update to be salted with username, which is unique
    
    function passGen($user, $pass){
		$combine = $user.$pass;
        $hash = hash('md5',$combine);
        return $hash;
    }

	
	function navBar($page){
	
		echo "<div id='menu'>";
			echo	"<a href='dashboard.php?logout'><b>Logout</b></a> || ";
			if($page != "dashboard") echo "<a href='dashboard.php'>Dashboard</a> || ";
			if($page != "update") echo "<a href='update.php'>Update Admin Info</a> || ";
			if ($_SESSION['sudo']) echo "<a href='users.php'>Manage Admins</a> || ";
			if($page != "employees") echo "<a href='employees.php'>Manage Cafe Employees</a> || ";
			if($page != "nightitems") echo "<a href='nightitems.php'>Manage Nightly Inventory Page</a> || ";
			if($page != "weeklyitems") echo "<a href='weeklyitems.php'>Manage Weekly Inventory Page</a> || ";
		echo "</div>";
		
	}



?>
