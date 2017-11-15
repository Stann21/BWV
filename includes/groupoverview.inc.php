<?php
	include_once 'dbh.inc.php';
	
	$groupid = $_GET['groupid'];
		
	//Check if submit button is pressed,
	if (isset($_POST['submit'])) {
		foreach($_POST['groupid'] as $userid) {
			//Insert the user into the database
			// The ? below are parameter markers used for variable binding
			$sql = "UPDATE users SET user_groups=? WHERE user_id=?";
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("ii", $groupid, $userid);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();
		}
			header("Location: ../groupoverview.php?user=1&groupid=$groupid");
			exit();
	}
?>