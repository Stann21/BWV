<?php
	include_once ('dbh.inc.php');
	$userid = $_GET['user'];
               	
	//Get all user information
	$sql = "SELECT * FROM users WHERE user_id = $userid";
	$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$user_first = $row["user_first"];
					$user_last = $row["user_last"];
					$user_email = $row["user_email"];
					$user_company = $row["user_company"];
					$user_password = $row["user_pwd"];
					$user_lan = $row["user_lan"];
					$user_profilepicture = $row["user_profilepicture"];
				}
			}
			
			//When there is no profile picture use a placeholder.
			if (empty ($user_profilepicture)) {
				$user_profilepicture = 'user.png';
			}
	
	//Update the information except pwd
	if (isset($_POST['submit'])) {
		// Get all the variables from the inputs.
		$first = $_POST['user_first'];
		$last = $_POST['user_last'];
		$email = $_POST['user_email'];
		$company = $_POST['user_company'];
		$lan = $_POST['user_lan'];
		
		//Check email
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

		}else {
			// The ? below are parameter markers used for variable binding
			$sql = "UPDATE users SET user_first=?, user_last=?, user_email=?, user_company=?, user_lan=? WHERE user_id=?";
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("sssssi", $first, $last, $email, $company, $lan, $userid);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();
		}
	}
	
	if(isset($_POST['pwdsubmit'])) {
		// Get the information		
		$oldpwd = $_POST['user_pwdold'];
		$newpwd = $_POST['user_pwdnew'];
		
		if (password_verify($oldpwd, $user_password)) {
			//Hashing the password
			$hashedPWD = password_hash($newpwd, PASSWORD_DEFAULT);
			//Update the user that is logged in.
			// The ? below are parameter markers used for variable binding
			$sql = "UPDATE users SET user_pwd=? WHERE user_id=?";
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("si", $hashedPWD, $userid);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();
		}else {
			if ($user_lan == "NL") {
				$settingsmessage = 'Voer het correcte oude wachtwoord in.';
			}
			
			if ($user_lan == "EN") {
				$settingsmessage = 'Enter the correct old password.';
			}

			header ('settings.php?user=$userid');
		}
	}
?>