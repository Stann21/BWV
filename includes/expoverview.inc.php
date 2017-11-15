<?php
	include_once ('dbh.inc.php');
	include_once ('translate.inc.php');
	
	$userid = $_GET['user'];
	$experimentid = $_GET['experiment'];
	
	$count = '0';
	$translate = '0';
	$expstyle = ' ';
	$resstyle = ' ';
	
	$numbers= array();
	$answers= array();
	
	//Check if user has permission to edit experiments.
	if (empty ($_GET['groupuser'])) {
		$groupuser = '0';
		$id = $userid;
		$permission = '0';
	} else {
		$groupuser = $_GET['groupuser'];
		$id = $groupuser;
		$permission = '1';
	}
	
	//If the user is admin then you cant edit as well.
	if ($userid == '1') {
		$permission = '1';
	}
	
	//Check if we are on the groupoverview
	if ($groupuser >= '2') {
		//Get the user language
		$sql = "SELECT user_lan FROM users WHERE user_id = $userid";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$userlan = $row['user_lan'];
			}
		}
		
		//Get the groupuser language
		$sql = "SELECT user_lan FROM users WHERE user_id = $groupuser";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$groupuserlan = $row['user_lan'];
			}
		}
		
		$translatewarning = '';
		//Check if a translation for the answers is needed
		if ($userlan == 'EN' && $groupuserlan == 'NL') {
			$source = 'NL';
			$target = 'EN';
			$translate = '1';
			$translatewarning = 'Warning! The text is translated, there could be small errors.';
		}
		
		if ($userlan == 'NL' && $groupuserlan == 'EN') {
			$source = 'EN';
			$target = 'NL';
			$translate = '2';
			$translatewarning = 'Waarschuwing! De tekst is automatisch vertaald, er kunnen kleine fouten inzitten.';
		}
	}
	
	//Check language from user
	$sql = "SELECT user_lan from users where user_id='$userid'";
	$result = $conn->query($sql);
				
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$user_lan = $row['user_lan'];
			}
		}
	
	//Check if it is a results page
	if (empty ($_GET['results'])) {
		$results = '0';
		$check = '1';
		$expstyle = 'expstyle';
	} else {
		$results = $_GET['results'];
		$check = '2';
		$resstyle = 'resstyle';
	}
	
	//Get max. question id for Experiment
	if ($check == '1') {
		//Check language
		if ($user_lan == 'NL') {
				$sql = "SELECT * FROM edsquestions ORDER BY edsq_id DESC LIMIT 1";
		}
		if ($user_lan == 'EN') {
				$sql = "SELECT * FROM edsquestionsen ORDER BY edsq_id DESC LIMIT 1";
		}
	}
	
	//Get max. question id for Results
	if ($check == '2') {
		//Check user language
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM ersquestions ORDER BY ersq_id DESC LIMIT 1";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM ersquestionsen ORDER BY ersq_id DESC LIMIT 1";
		}
	}

	$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					//Experiment
					if ($check == '1') {
						$maxq = $row["edsq_id"];
					}
					//Results
					if ($check == '2') {
						$maxq = $row["ersq_id"];
					}
				}
			}
		
		if ( $check == '1') {
			//Get the questionid and answer that exist in the DB for Experiment
			$sql = "SELECT edsa_answer, edsa_questionid FROM edsanswers WHERE edsa_userid=$id AND edsa_experimentid=$experimentid ORDER BY edsa_questionid";
		}
		if ( $check == '2') {
			//Get the questionid and answer that exist in the DB for Results
			$sql = "SELECT ersa_answer, ersa_questionid, ersa_experimentid FROM ersanswers WHERE ersa_userid=$id AND ersa_resultid=$results AND ersa_experimentid=$experimentid ORDER BY ersa_questionid";
		}
		$result = $conn->query($sql);
		
		//API Google Translate stuff
		require_once ('translate/vendor/autoload.php');
		use \Statickidz\GoogleTranslate;
		$trans = new GoogleTranslate();
		
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				//Experiment and no translate
				if ($check == '1' && $translate == '0') {		
					$questionid = $row["edsa_questionid"];
					$answer = $row["edsa_answer"];
				}
				
				//Experiment and translate
				if ($check == '1') {
					if ($translate == '1' || $translate == '2') {	
						$questionid = $row["edsa_questionid"];
						$answer = $row["edsa_answer"];

						//Translate the answer with the source and target.
						$translated = $trans->translate($source, $target, $answer);
						$answer = $translated;
					}
				}
					
				//Results and no translate
				if ($check == '2' && $translate == '0') {		
					$questionid = $row["ersa_questionid"];
					$answer = $row["ersa_answer"];
				}
				
				//Results and translate
				if ($check == '2') {
					if ($translate == '1' || $translate == '2') {	
						$questionid = $row["ersa_questionid"];
						$answer = $row["ersa_answer"];

						//Translate the answer with the source and target.
						$translated = $trans->translate($source, $target, $answer);
						$answer = $translated;
					}
				}
			
			// Push questionid in array $numbers
				array_push($numbers, $questionid);
				
			// Push answer in array $answers
				array_push($answers, $answer);
			}
		}
		
	//Add result or show the results, depending on the permission.
	if ($permission == '0') {	
		//Experiment name
		echo '<h1 class="text-center">'; echo $TRexpoverview; echo '</h1><br>';
		echo '<div class= "col-xs-4 col-sm-4 col-md-3 exptitel '; echo $expstyle; echo '">';
			echo '<a class="exptitela"  href="expoverview.php?user=';echo $userid;echo '&experiment=';echo $experimentid;echo '">Experiment '; echo $experimentid; echo '</a>';
		echo '</div>';
	
		//Add results to menu
		$sql = "SELECT * FROM results WHERE res_userid=$id AND res_experimentid=$experimentid";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$res_resultid = $row["res_resultid"];
							
				if ($results == $res_resultid) {
					echo '<div class="col-xs-4 col-sm-4 col-md-3 restitel '; echo $resstyle; echo '">';
				} else {
					echo '<div class="col-xs-4 col-sm-4 col-md-3 restitel">';
				}
					echo '<a class="restitela" href="expoverview.php?user=';echo $userid;echo '&results=';echo $res_resultid;echo '&experiment=';echo $experimentid;echo '">'; echo $TRresult; echo $res_resultid; echo '</a>';
				echo '</div>';
			}
		}
		//Add results
		echo '<div class="col-xs-4 col-sm-4 col-md-3 restitel">';
			echo '<a class="restitela" href="includes/experiment.inc.php?user=';echo $userid;echo '&experiment=';echo $experimentid;echo '">';echo $TRaddresult;echo'</a>';
		echo '</div>';
	}
	
	if ($permission == '1') {	
		echo '<div class="col-xs-12 paddingreset"><p class="extrabold text-center">';
			echo $translatewarning;
		echo '</p></div>';
		echo '<h1 class="text-center">'; echo $TRexpoverview; echo '</h1><br>';
		echo '<div class="col-xs-4 col-sm-4 col-md-3 exptitel '; echo $expstyle; echo '">';
			echo '<a href="expoverview.php?user=';echo $userid;echo '&experiment=';echo $experimentid;echo '&groupuser='; echo $groupuser; echo '">Experiment '; echo $experimentid; echo '</a>';
		echo '</div>';
		
		//Add results to menu
		$sql = "SELECT * FROM results WHERE res_userid=$id AND res_experimentid=$experimentid";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$res_resultid = $row["res_resultid"];

				if ($results == $res_resultid) {
					echo '<div class="col-xs-4 col-sm-4 col-md-3 restitel '; echo $resstyle; echo '">';
				} else {
					echo '<div class="col-xs-4 col-sm-4 col-md-3 restitel">';
				}
					echo '<a href="expoverview.php?user=';echo $userid;echo '&results=';echo $res_resultid;echo '&experiment=';echo $experimentid;echo '&groupuser='; echo $groupuser; echo '">Result '; echo $res_resultid; echo '</a>';
				echo '</div>';
			}
		}
	}
			
	//Get all the questions that exist in the DB for Experiment
	if ($check == '1') {
		//Check user language
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM edsquestions";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM edsquestionsen";
		}
	}
	
	//Get all the questions that exist in the DB for Results
	if ($check == '2') {
		//Check for language
		if ($user_lan == 'NL') {
			$sql = "SELECT * FROM ersquestions";
		}
		if ($user_lan == 'EN') {
			$sql = "SELECT * FROM ersquestionsen";
		}
	}
		$result = $conn->query($sql);
			
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					//Experiment
					if ($check == '1') {
						$questionid = $row["edsq_id"];
						$questiontitle = $row["edsq_questiontitle"];
						$question = $row["edsq_questions"];
					}
					//Results
					if ($check == '2') {
						$questionid = $row["ersq_id"];
						$questiontitle = $row["ersq_questiontitle"];
						$question = $row["ersq_questions"];
					}
					
					//If the questionid DOES NOT exist in the array $numbers, then DONT SHOW a answer.
					if (!in_array($questionid, $numbers)) {
						echo '<div class="col-xs-12 questionbox paddingreset">';
							echo '<p class="regular">';echo $questiontitle;echo '</p>';
								if ($user_lan == "NL") {
									echo '<p class="answerbox">Er is nog geen antwoord.</p>';
								}
								if ($user_lan == "EN") {
									echo '<p class="answerbox">There is no answer yet.</p>';
								}
							if ($permission == '0') {
								//Experiment
								if ( $check == '1') {
									echo '<a href="questions.php?user=';echo $userid;echo '&questionid=';echo $questionid;echo '&experiment=';echo $experimentid;echo '"><p>';echo $TRedit;echo'</p></a>';
								}
								//Results
								if ( $check == '2') {
									echo '<a href="questions.php?user=';echo $userid;echo '&questionid=';echo $questionid;echo '&experiment=';echo $experimentid;echo '&results='; echo $results; echo'"><p>';echo $TRedit;echo'</p></a>';
								}
							}
						echo '</div>';
					}
					
					//If the questionid DOES exist in the array $numbers, then SHOW a answer.
					if (in_array($questionid, $numbers)) {
						echo '<div class="col-xs-12 questionbox paddingreset">';
							echo '<p class="regular">';echo $questiontitle;echo '</p>';
							echo '<p class="answerbox">';print_r($answers[$count]);echo '</p>';
							if ($permission == '0') {
								//Experiment
								if ( $check == '1') {
									echo '<a href="questions.php?user=';echo $userid;echo '&questionid=';echo $questionid;echo '&experiment=';echo $experimentid;echo '"><p>';echo $TRedit; echo'</p></a>';
								}
								//Results
								if ( $check == '2') {
									echo '<a href="questions.php?user=';echo $userid;echo '&questionid=';echo $questionid;echo '&experiment=';echo $experimentid;echo '&results='; echo $results; echo'"><p>';echo $TRedit; echo'</p></a>';
								}
							}
						echo '</div>';
						$count ++;
					}
				}
			}
			
			//If the user has permission to edit and if it is a result then show delete button
			if ($permission == '0') {
				if ($results >= '1') {
					echo '<div class="col-xs-12">';
						echo '<form action="includes/experiment.inc.php?user='; echo $userid; echo '&result='; echo $results; echo '&experiment='; echo $experimentid; echo '" method="POST">';
							if ($user_lan == 'NL') {
								echo '<button name="delete" type="submit" class="btn btn-danger" onclick="return checkDeleteNL()" />Delete result</button>';					
							}
							if ($user_lan == 'EN') {
								echo '<button name="delete" type="submit" class="btn btn-danger" onclick="return checkDeleteEN()" />Delete result</button>';					
							}
						echo '</form>';
					echo '</div>';
				}
			}
			
			//If the user has permission to edit and if it is a experiment then show delete button
			if ($permission == '0') {
				if ($results == '0') {
					echo '<div class="col-xs-12 paddingreset questionbox">';
						echo '<form action="includes/experiment.inc.php?user='; echo $userid; echo '&experiment='; echo $experimentid; echo '" method="POST">';
							if ($user_lan == 'NL') {
								echo '<button name="deleteexp" type="submit" class="btn btn-danger" onclick="return checkDeleteNL()" />Delete Experiment</button>';							
							}
							if ($user_lan == 'EN') {
								echo '<button name="deleteexp" type="submit" class="btn btn-danger" onclick="return checkDeleteEN()" />Delete Experiment</button>';
							}
						echo '</form>';
					echo '</div>';
				}
			}
?>

<!-- Confirmation for deleting EN -->
<script language="JavaScript" type="text/javascript">
function checkDeleteEN(){
    return confirm('Are you sure?');
}
</script>

<!-- Confirmation for deleting NL -->
<script language="JavaScript" type="text/javascript">
function checkDeleteNL(){
    return confirm('Weet je het zeker?');
}
</script>