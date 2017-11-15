<?php
	include_once ('dbh.inc.php');

	$userid = $_GET['user'];
	
	//Get the date				
	$today = date("Y-m-d");
	
	//Check what to make. If there is questionid make a new experiment.
	if (empty ($_GET['questionid'])) {
		$questionid = '0';
	}else {
		$questionid = $_GET['questionid'];
		$permission = '1';
	}

	//Check what to make. If there is a experimentid make a new result.
	if (empty ($_GET['experiment'])) {
		$experiment = '0';
	}else {
		$experiment = $_GET['experiment'];
		$permission = '2';
		$questionid = '1';
	}
	
	//Delete experiment & results
	if (isset($_POST['deleteexp'])) {
		$experiment = $_GET['experiment'];
		
		//Delete experiment main
		//The ? below are parameter markers used for variable binding
		$sql = "DELETE FROM experimenten WHERE exp_experimentid=? AND exp_userid=?;";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("ii", $experiment, $userid);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
				
		//Delete experiment answers.
		// The ? below are parameter markers used for variable binding
		$sql = "DELETE FROM edsanswers WHERE edsa_experimentid=? AND edsa_userid=?;";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("ii", $experiment, $userid);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
		
		//Delete results main.
		// The ? below are parameter markers used for variable binding
		$sql = "DELETE FROM results WHERE res_experimentid=? AND res_userid=?;";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("ii", $experiment, $userid);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
		
		//Delete results answers
		// The ? below are parameter markers used for variable binding
		$sql = "DELETE FROM ersanswers WHERE ersa_experimentid=? AND ersa_userid=?;";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("iii", $results, $userid);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
		
		header("Location: ../dashboard.php?user=$userid");
		exit();
	}
	

	//Delete results
	if (isset($_POST['delete'])) {
		$results = $_GET['result'];
		$experiment = $_GET['experiment'];
		
		//Delete results main
		// The ? below are parameter markers used for variable binding
		$sql = "DELETE FROM results WHERE res_resultid=? AND res_userid=? AND res_experimentid=?;";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("iii", $results, $userid, $experiment);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
		
		//Delete results answers
		// The ? below are parameter markers used for variable binding
		$sql = "DELETE FROM ersanswers WHERE ersa_resultid=? AND ersa_userid=? AND ersa_experimentid=?;";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("iii", $results, $userid, $experiment);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();

		header("Location: ../expoverview.php?user=$userid&experiment=$experiment");
		exit();
	}
	
	//Make a new experiment
	if ($permission == '1') {
	//Get max. experiment id from user
	$sql = "SELECT * FROM experimenten WHERE exp_userid ='$userid' ORDER BY exp_experimentid DESC LIMIT 1";
	$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$experiment = $row["exp_experimentid"];
						$experiment ++;
					}
			} else {
				$experiment = '1';
			}

		// The ? below are parameter markers used for variable binding
		$sql = "INSERT INTO experimenten  (exp_userid, exp_experimentid, exp_date) VALUES (?,?,?);";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("iis", $userid, $experiment, $today);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
		
		header("Location: ../questions.php?user=$userid&questionid=$questionid&experiment=$experiment");
		exit();
	}
	
	//Make a new result
	if ($permission == '2') {
	//Get max. experiment id from user
	$sql = "SELECT * FROM results WHERE res_userid ='$userid' AND res_experimentid ='$experiment' ORDER BY res_resultid DESC LIMIT 1";
	$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$results = $row["res_resultid"];
				$results ++;
			}
		} else {
			$results = '1';
		}

		// The ? below are parameter markers used for variable binding
		$sql = "INSERT INTO results (res_resultid, res_userid, res_experimentid) VALUES (?,?,?);";
		$stmt = $conn->prepare($sql);
		//Bind the variables
		$stmt->bind_param("iis", $results, $userid, $experiment);
		//Execute the prepared statement
		$stmt->execute();
		//Close the statement
		$stmt->close();
			
		header("Location: ../questions.php?user=$userid&questionid=$questionid&experiment=$experiment&results=$results");
		exit();
	}		
?>