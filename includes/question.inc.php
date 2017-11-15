<?php

	include_once ('dbh.inc.php');
	
	$userid = $_GET['user'];
	$questionid = $_GET['questionid'];
	$experimentid = $_GET['experiment'];
	$answer = $_POST['answer'];

	//Check if it is a result page.
	if (empty ($_GET['results'])) {
		$results = '0';
		$check = '1';
	}else {
		$results = $_GET['results'];
		$check = '2';
	}
	
	// Get user language
		$sql = "SELECT * FROM users WHERE user_id='$userid'";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$lan = $row["user_lan"];
				}
		}
	
	//Does the question already exist in the DB?
	$DBcheck = 1;
	
	//Experiment
	if ($check == '1') {
		$sql = "SELECT edsa_id, edsa_userid, edsa_questionid, edsa_experimentid FROM edsanswers WHERE edsa_experimentid=$experimentid";
		$result = $conn->query($sql);
	
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$edsa_id = $row["edsa_id"];
				$edsa_userid = $row["edsa_userid"];
				$edsa_questionid = $row["edsa_questionid"];
				$edsa_experimentid = $row["edsa_experimentid"];
				
				if ($edsa_userid == $userid && $edsa_questionid == $questionid && $edsa_experimentid == $experimentid) {
					// The ? below are parameter markers used for variable binding
					$sql = "UPDATE edsanswers SET edsa_answer=? WHERE edsa_id=?";
					$stmt = $conn->prepare($sql);
					//Bind the variables
					$stmt->bind_param("si", $answer, $edsa_id);
					//Execute the prepared statement
					$stmt->execute();
					//Close the statement
					$stmt->close();
					$DBcheck = 2;
				}
			}
		}
	
		// If varcheck is equal to 1, then insert it into the DB
		if ($DBcheck == 1) {
			//Insert the user into the database
			// The ? below are parameter markers used for variable binding
			$sql = "INSERT INTO edsanswers (edsa_userid, edsa_questionid, edsa_experimentid, edsa_answer, edsa_language) VALUES (?,?,?,?,?);";
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("iiiss", $userid, $questionid, $experimentid, $answer, $lan);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();
		}
	}
	
	//Result SQL
	if ($check == '2')	{
		$sql = "SELECT ersa_id, ersa_userid, ersa_experimentid, ersa_questionid, ersa_resultid FROM ersanswers";
		$result = $conn->query($sql);
	
		if ($result->num_rows > 0){
			while($row = $result->fetch_assoc()) {
				$ersa_id = $row["ersa_id"];
				$ersa_userid = $row["ersa_userid"];
				$ersa_questionid = $row["ersa_questionid"];
				$ersa_experimentid = $row["ersa_experimentid"];
				$ersa_resultid = $row["ersa_resultid"];
				
				if ($ersa_userid == $userid && $ersa_questionid == $questionid  && $ersa_experimentid == $experimentid && $ersa_resultid == $results) {
					// The ? below are parameter markers used for variable binding
					$sql = "UPDATE ersanswers SET ersa_answer=? WHERE ersa_id=?";
					$stmt = $conn->prepare($sql);
					//Bind the variables
					$stmt->bind_param("si", $answer, $ersa_id);
					//Execute the prepared statement
					$stmt->execute();
					//Close the statement
					$stmt->close();
					$DBcheck = 2;
				}
			}
		}
		// If varcheck is equal to 1, then insert it into the DB
		if ($DBcheck == 1) {
			//Insert the user into the database			
			// The ? below are parameter markers used for variable binding
			$sql = "INSERT INTO ersanswers (ersa_userid, ersa_questionid, ersa_experimentid, ersa_resultid, ersa_answer, ersa_language) VALUES (?,?,?,?,?,?);";
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("iiiiss", $userid, $questionid, $experimentid, $results, $answer, $lan);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();
		}
	}

	if ($check == '1') {
		//Get max. question id for Experiment
		$sql = "SELECT * FROM edsquestions ORDER BY edsq_id DESC LIMIT 1";
	}
	if ($check == '2') {
		//Get max. question id for Result
		$sql = "SELECT * FROM ersquestions ORDER BY ersq_id DESC LIMIT 1";
	}
	
		$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						//Experiment
						if ($check == '1') {
							$maxq = $row["edsq_id"];
						}
						//Result
						if ($check == '2') {
							$maxq = $row["ersq_id"];
						}
					}
			}
					
	//Check if submit button is pressed,
		if (isset($_POST['overview'])) {
			//Experiments
			if ($check == '1') {
				// Send to overview for the Experiment 
				header("Location: ../expoverview.php?user=$userid&experiment=$experimentid");
			}
			//Results
			if ($check == '2') {
				// Send to overview for the Result
				header("Location: ../expoverview.php?user=$userid&experiment=$experimentid&results=$results");
			}
		}
		
	//Check if submit button is pressed,
	if (isset($_POST['save'])) {
		if ($questionid == $maxq){
			//Experiments
			if ($check == '1') {
				// Send to overview for the Experiment 
				header("Location: ../expoverview.php?user=$userid&experiment=$experimentid");
			}
			//Results
			if ($check == '2') {
				// Send to overview for the Result
				header("Location: ../expoverview.php?user=$userid&experiment=$experimentid&results=$results");
			}
		} else {		
			if ($check == '1') {
				//QuestionID +1 and send back to questionpage
				$questionid ++;
				header("Location: ../questions.php?user=$userid&questionid=$questionid&experiment=$experimentid");
			}
			//Results
			if ($check == '2') {
				//QuestionID +1 and send back to questionpage
				$questionid ++;
				header("Location: ../questions.php?user=$userid&questionid=$questionid&experiment=$experimentid&results=$results");
			}
		}	
}