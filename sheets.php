<?php
	include_once ('header.php');
	include_once ('includes/sessions.inc.php');
	
	$userid = $_GET['user'];
	$subject = $_GET['subject'];
	
	if(empty($_GET['button'])) {
		$button = '0';
	}else {
		$button = $_GET['button'];
		if ($button == 'save') {
			$button = 'De wijzigingen zijn opgeslagen';
		}
		if ($button == 'add') {
			$button = 'Er is een nieuwe vraag toegevoegd';
		}
	}
	
	$expstyle = ' ';
	$resstyle = ' ';
	$expstyle1 = ' ';
	$resstyle1 = ' ';
	
	switch ($subject) {
		case "experimentnl":
			$expstyle = 'expstyle';	
			break;
			
		case "experimenten":
			$expstyle1 = 'expstyle';	
			break;
			
		case "resultnl":
			$resstyle = 'resstyle';
			break;
			
		case "resulten":
			$resstyle1 = 'resstyle';
			break;
		}
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>
		
		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv">	
			<?php
				if ($button == '0') {
				
				}else {
					echo '<div class="col-xs-12 paddingreset">';
						echo '<p class="text-center extrabold">';
							echo $button;
						echo '</p>';
					echo '</div>';
				}
			?>
		
			<div class="dashboard">
			<h1 class="text-center">Experiment Sheets</h1>
			<!-- Menu for switching -->
			<div class="row">
				<a href="sheets.php?user=<?php echo $userid; ?>&subject=experimentnl"><div class="col-xs-4 col-sm-4 col-md-3 exptitel <?php echo $expstyle; ?>"><label>Experiment NL</label></div></a>
				<a href="sheets.php?user=<?php echo $userid; ?>&subject=resultnl"><div class="col-xs-4 col-sm-4 col-md-3 restitel <?php echo $resstyle; ?>"><label>Result NL</label></div></a>
				<a href="sheets.php?user=<?php echo $userid; ?>&subject=experimenten"><div class="col-xs-4 col-sm-4 col-md-3 exptitel <?php echo $expstyle1; ?>"><label>Experiment EN</label></div></a>
				<a href="sheets.php?user=<?php echo $userid; ?>&subject=resulten"><div class="col-xs-4 col-sm-4 col-md-3 restitel <?php echo $resstyle1; ?>"><label>Result EN</label></div></a>
			</div>
				
			<?php
			//Load all the questions from the selected sheets.
			switch ($subject) {
				case "experimentnl":
					$sql = "SELECT * FROM edsquestions";
					break;
						
				case "experimenten":
					$sql = "SELECT * FROM edsquestionsen";
					break;
						
				case "resultnl":
					$sql = "SELECT * FROM ersquestions";
					break;
						
				case "resulten":
					$sql = "SELECT * FROM ersquestionsen";
					break;
			}
			
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						
					if ($subject == 'experimentnl' || $subject == 'experimenten') {
						$id = $row['edsq_id'];
						$title = $row['edsq_questiontitle'];
						$question = $row['edsq_questions'];
					}
					
					echo '<form action="includes/sheets.inc.php?user=';echo $userid; echo'&subject='; echo $subject; echo '" method="POST">';
					if ($subject == 'resultnl' || $subject == 'resulten') {
						$id = $row['ersq_id'];
						$title = $row['ersq_questiontitle'];
						$question = $row['ersq_questions'];
					}
							echo '<p class="questionbox">';
								echo '<input type="text" name="title[]" class="sheetsinput" value="'; echo $title; echo '"></input>';
							echo '</p>';
					
							echo '<p>';
								echo '<input type="text" name="question[]" class="sheetsinput" value="'; echo $question; echo '"></input>';
							echo '</p>';
					}
					echo '<input name="submit" type="submit" value="';echo $TRsavesettings; echo '" class="btn btn-default" />';
					echo '<input name="add" type="submit" value="';echo $TRaddquestion; echo '" class="btn btn-default" />';
					echo '</form>';
				}
			?>
			</div>
		</div> <!-- Einde col -->
		
		<?php 
			include_once ('right.php');
		?>
	
	</body>
</html>

<?php
	include_once ('footer.php');
?>