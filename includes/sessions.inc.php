<?php
	session_start();
	$userid = $_GET['user'];
	$sessioncheck = $_SESSION['u_id'];
	
	//Check if userid is equal to the loged in id.
	if ($sessioncheck == $userid) {

	}else {
		//if it is not equal delete the current session and send back to the homepage.
		session_start();
		session_unset();
		session_destroy();
		header("Location: index.php");
		exit();
	}
?>