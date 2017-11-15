<?php
	include_once 'dbh.inc.php';

	$hash = $_GET['hash'];
	$getactivated = '0';
	
	$sql = "SELECT user_id, user_hash, user_activated FROM users";
	$result = $conn->query($sql);
	
	if($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$userid = $row['user_id'];
			$activation = $row['user_hash'];
			$activated = $row['user_activated'];
			
			//If the activation code is the same as hash.
			if ($activation == $hash) {
				//if account is not activated yet.
				if ($activated == '1') {
					// The ? below are parameter markers used for variable binding
					$sql = "UPDATE users SET user_activated=? WHERE user_id=?";
					$stmt = $conn->prepare($sql);
					//Bind the variables
					$stmt->bind_param("ii", $getactivated, $userid);
					//Execute the prepared statement
					$stmt->execute();
					//Close the statement
					$stmt->close();
					header("Location: ../index.php?active=1");
				}
				//If account already is activated.
				if ($activated == '0') {
					header("Location: ../index.php?active=2");
				}
			}
		}
	}
?>