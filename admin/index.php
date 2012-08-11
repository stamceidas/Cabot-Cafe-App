<?
	ob_start();
	//placeholder page. don't actually want anyone here.
	require_once("../includes/common.php");

	//if session not set, not logged in
	if(empty($_SESSION['admin'])){
		header("Location:admin.php");
	}
	
	
	if(!empty($_SESSION['admin'])){
		header("Location:dashboard.php");
	}
	ob_flush();

?>