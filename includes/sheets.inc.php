<?php
	include_once ('dbh.inc.php');
	$subject = $_GET['subject'];
	$userid = $_GET['user'];
	
	$id = '1';
	
	//Get max. question id for what needs to be updated.
	switch ($subject) {
		case 'experimentnl':
			$sql = "SELECT * FROM edsquestions ORDER BY edsq_id DESC LIMIT 1";
			break;
				
		case 'resultnl':
			$sql = "SELECT * FROM ersquestions ORDER BY ersq_id DESC LIMIT 1";
			break;
				
		case 'experimenten':
			$sql = "SELECT * FROM edsquestionsen ORDER BY edsq_id DESC LIMIT 1";
			break;
				
		case 'resulten':
			$sql = "SELECT * FROM ersquestionsen ORDER BY ersq_id DESC LIMIT 1";
			break;
	}
	$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if ($subject == 'experimentnl' || $subject == 'experimenten') {
					$maxq = $row["edsq_id"];
				}
				
				if ($subject == 'resultnl' || $subject == 'resulten') {
					$maxq = $row["ersq_id"];
				}
			}
		}
		
	//Check if submit button is pressed,
	if (isset($_POST['submit'])) {
		//Loop everthing that is posted for questions
		foreach ($_POST['question'] as $insert) {
			//Update the questions that are requested.
			switch ($subject) {
				case 'experimentnl':
					// The ? below are parameter markers used for variable binding
					$sql = "UPDATE edsquestions SET edsq_questions=? WHERE edsq_id=?";
					break;
						
				case 'resultnl':
					$sql = "UPDATE ersquestions SET ersq_questions=? WHERE ersq_id=?";
					break;
						
				case 'experimenten':
					$sql = "UPDATE edsquestionsen SET edsq_questions=? WHERE edsq_id=?";
					break;
						
				case 'resulten':
					$sql = "UPDATE ersquestionsen SET ersq_questions=? WHERE ersq_id=?";
					break;
			}	
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("si", $insert, $id);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();		
			
			//If $id is not equal too maxq, then ++ $id
			if ($id !== $maxq) {
				$id ++;
			}
		}
		
		$id = '1';
		//Loop everthing that is posted for title
		foreach ($_POST['title'] as $title) {
			//Update the question titles that are requested.
			switch ($subject) {
				case 'experimentnl':
					$sql = "UPDATE edsquestions SET edsq_questiontitle=? WHERE edsq_id=?";
					break;
						
				case 'resultnl':
					$sql = "UPDATE ersquestions SET ersq_questiontitle=? WHERE ersq_id=?";
					break;
						
				case 'experimenten':
					$sql = "UPDATE edsquestionsen SET edsq_questiontitle=? WHERE edsq_id=?";
					break;
						
				case 'resulten':
					$sql = "UPDATE ersquestionsen SET ersq_questiontitle=? WHERE ersq_id=?";
					break;
			}
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("si", $title, $id);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();		
			
			//If $id is equal to maxq, then send back.
			if ($id == $maxq) {
				header("Location: ../sheets.php?user=$userid&subject=$subject&button=save");
			}
			
			//If $id is not equal too maxq, then ++ $id
			if ($id !== $maxq) {
				$id ++;
			}
		}
	}
	
	//Check if add button is pressed
	if (isset($_POST['add'])) {	
		$maxq ++;
		$newtitle = 'New title';
		$newq = 'New question';
		
		switch ($subject) {
			case 'experimentnl':
				// The ? below are parameter markers used for variable binding
				$sql = "INSERT INTO edsquestions (edsq_id, edsq_questiontitle, edsq_questions) VALUES (?,?,?);";
				break;
					
			case 'resultnl':
				$sql = "INSERT INTO ersquestions (ersq_id, ersq_questiontitle, ersq_questions) VALUES (?,?,?);";
				break;
					
			case 'experimenten':
				$sql = "INSERT INTO edsquestionsen (edsq_id, edsq_questiontitle, edsq_questions) VALUES (?,?,?);";
				break;
					
			case 'resulten':
				$sql = "INSERT INTO ersquestionsen (ersq_id, ersq_questiontitle, ersq_questions) VALUES (?,?,?);";
				break;
		}
			$stmt = $conn->prepare($sql);
			//Bind the variables
			$stmt->bind_param("iss", $maxq, $newtitle, $newq);
			//Execute the prepared statement
			$stmt->execute();
			//Close the statement
			$stmt->close();
			
		header("Location: ../sheets.php?user=$userid&subject=$subject&button=add");
	}
?>