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
    //somewhat hacky because no salt is used...
    
    function passGen($input){
        $hash = hash('md5',$input);
        $pass = substr($hash, 0, 8) . substr($hash, -8);
        return $pass;
    }




?>
