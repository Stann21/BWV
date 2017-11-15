<?php
	include_once ('dbh.inc.php');

	$userid = $_GET['user'];
	$questionid = $_GET['questionid'];
	
	//Check if it is a results page.
	if (empty($_GET['results'])) {
		$results = '0';
	}else {
		$results = $_GET['results'];
	}

	//Check language from user
	$sql = "SELECT user_lan from users where user_id='$userid'";
	$result = $conn->query($sql);
				
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$user_lan = $row['user_lan'];
			}
		}
	//Get max. question id
	if ($results == '0') {
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM edsquestions ORDER BY edsq_id DESC LIMIT 1";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM edsquestionsen ORDER BY edsq_id DESC LIMIT 1";
		}
	}
	if ($results >= '1') {
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM ersquestions ORDER BY ersq_id DESC LIMIT 1";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM ersquestions ORDER BY ersq_id DESC LIMIT 1";
		}
	}

	$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if ($results == '0') {
					$maxq = $row["edsq_id"];
				}	
				if ($results >= '1') {
					$maxq = $row["ersq_id"];
				}
			}
		}
	
	//Select the right questions.
	if ($results == '0') {
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM edsquestions";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM edsquestionsen";
		}
	}
	
	if ($results >= '1') {
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM ersquestions";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM ersquestionsen";
		}
	}
	
	$result = $conn->query($sql);
				
	if ($result->num_rows>0) {
		while ($row = $result->fetch_assoc()) {
			if ($results == '0') {
				$progressquestion = $row["edsq_id"];
			}	
			if ($results >= '1') {
				$progressquestion = $row["ersq_id"];
			}
			
			//If questionid is equal to the questionid on the page, make it active.
			if ($progressquestion == $questionid) {
				if ($results == '0') {
					echo '<a href="questions.php?questionid='; echo $progressquestion; echo '&user='; echo $userid; echo '&experiment='; echo $experimentid; echo '">';
						echo '<div class="progressbox" id="progressactive"></div>';
					echo '</a>';
				}
				if ($results >= '1') {
					echo '<a href="questions.php?questionid='; echo $progressquestion; echo '&user='; echo $userid; echo '&experiment='; echo $experimentid; echo '&results='; echo $results; echo '">';
						echo '<div class="progressbox" id="progressactive"></div>';
					echo '</a>';
				}
			}else {
				if ($results == '0') {
					echo '<a href="questions.php?questionid='; echo $progressquestion; echo '&user='; echo $userid; echo '&experiment='; echo $experimentid; echo '">';
						echo '<div class="progressbox"></div>';
					echo '</a>';
				}
				if ($results >= '1') {
					echo '<a href="questions.php?questionid='; echo $progressquestion; echo '&user='; echo $userid; echo '&experiment='; echo $experimentid; echo '&results='; echo $results; echo '">';
						echo '<div class="progressbox"></div>';
					echo '</a>';
				}
			}
			if ($maxq == $progressquestion) {
				echo '<div></div>';
			}else {
				echo '<div class="progressline"></div>';
			}
		}
	}	
?>