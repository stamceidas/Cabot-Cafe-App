<?

	//placeholder page. don't actually want anyone here.
	require_once("../includes/common.php");

	//if session not set, not logged in
	if(empty($_SESSION['user'])){
		header("Location:admin.php");
	}
	
	
	if(!empty($_SESSION['user'])){
		header("Location:dashboard.php");
	}


?>