<?php
	include_once ('header.php');
	include_once ('includes/dbh.inc.php');
	include_once ('includes/sessions.inc.php');
	
	$questionid = $_GET['questionid'];
	$userid = $_GET['user'];
	$experimentid = $_GET['experiment'];
	
	//Check if it is a result page.
	if (empty ($_GET['results'])) {
		$results = '0';
		$check = '1';
		$title = 'Experiment Design ';
	}else {
		$results = $_GET['results'];
		$check = '2';
		$title = 'Results Reporting ';
	}
	
	//Check language from user
	$sql = "SELECT user_lan from users where user_id='$userid'";
	$result = $conn->query($sql);
				
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$user_lan = $row['user_lan'];
			}
		}
		
	//Get max. question id for Experiment
	$sql = "SELECT * FROM edsquestions ORDER BY edsq_id DESC LIMIT 1";
	$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				//Experiment
				$maxq = $row["edsq_id"];
			}
		}
	
	
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>
	
		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv whitespace">	
		
			<?php  
				echo '<h1 class="text-left qpagetitle">';
					echo $title;
					if ($check == '1') {
						echo $experimentid;
					}
					if ($check == '2') {
						echo $results;
					}

				echo '</h1>';
			
			//Experiment sql
			if ($check == '1') {
				//Check language
				if ($user_lan == 'NL') {
					$sql = "SELECT * FROM edsquestions WHERE edsq_id='$questionid'";
				}
				if ($user_lan == 'EN') {
					$sql = "SELECT * FROM edsquestionsen WHERE edsq_id='$questionid'";
				}
			}
			//Result sql
			if ($check == '2') {
				//Check language
				if ($user_lan == 'NL') {
					$sql = "SELECT * FROM ersquestions WHERE ersq_id='$questionid'";
				}
				if ($user_lan == 'EN') {
					$sql = "SELECT * FROM ersquestionsen WHERE ersq_id='$questionid'";
				}
			}
				
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						//Experiment
						if ($check == '1') {					
							$id = $row["edsq_id"];
							$questiontitle = $row["edsq_questiontitle"];
							$questions = $row["edsq_questions"];
						}
							
						//Result
						if ($check == '2') {					
							$id = $row["ersq_id"];
							$questiontitle = $row["ersq_questiontitle"];
							$questions = $row["ersq_questions"];
						}
								
						echo '<div class="row">';	
							echo '<div class="col-xs-10">';
								echo '<p class="marginreset questiontitle">';
									echo $id;
									echo '. ';
									echo $questiontitle;
								echo '</p>';
								
								echo '<p>';
									echo $questions;
								echo '</p>';
							echo '</div>';
						}
					}
								
					echo '<div class="col-xs-2 showhelp">';
						//Help page
						include_once('includes/help.inc.php');
					echo '</div>';
		
				//Experiment SQL
				if ($check == '1') {
					//Look for a answer that matches the userid, experimentid and questionid.
					$sql = "SELECT edsa_answer FROM edsanswers WHERE edsa_userid=$userid AND edsa_experimentid=$experimentid AND edsa_questionid=$questionid";
				}
				
				//Result SQL
				if ($check == '2') {
					//Look for a answer that matches the userid, experimentid and questionid.
					$sql = "SELECT ersa_answer FROM ersanswers WHERE ersa_userid=$userid AND ersa_resultid=$results AND ersa_questionid=$questionid AND ersa_experimentid=$experimentid";		
				}

				$result = $conn->query($sql);
						
				//If it exist, put it in variabel answer, otherwise leave variabel answer empty.
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						//Experiment
						if ( $check == '1') {
							$answer = $row["edsa_answer"];
						}
						//Result
						if ( $check == '2') {
							$answer = $row["ersa_answer"];
						}
					}
				} else {
						$answer = "";
					}
				?>
				
			<?php 
			//Experiment
			if ( $check == '1') {
				echo '<form action="includes/question.inc.php?questionid=';echo $questionid;echo '&user=';echo $userid;echo '&experiment=';echo $experimentid;echo '" method="POST">';
			}
			//Results
			if ( $check == '2') {
				echo '<form action="includes/question.inc.php?&questionid=';echo $questionid;echo '&user=';echo $userid;echo '&experiment=';echo $experimentid;echo '&results='; echo $results; echo '" method="POST">';
			}
			?>
				<div class="Col-xs-12 paddingreset">
					<textarea name="answer" class="Qanswerbox" autofocus><?php echo $answer; ?></textarea>
				</div> <!-- Einde col -->
				
				<div class="col-xs-12 progressdiv">
					<?php include_once ('includes/progressbar.inc.php'); ?>
				</div><!-- End col -->
				
				<div class="col-xs-12 questionitems">
					<input name="overview" type="submit" value="<?php echo $TRoverview; ?>" class="btn btn-default pull-right" />
					<input name="save" type="submit" value="<?php echo $TRsave; ?>" class="btn btn-default pull-right" />
			</form>
				</div><!-- Einde col -->
		</div> <!-- Einde Col -->
		
		<?php 
			include_once ('right.php');
		?>
	</body>
</html>

<?php
	include_once ('footer.php');
?>