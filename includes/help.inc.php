<?php
 	//Need to know experiment or result
	if ($check == '1') {
		$var = 'Experiment';
	}
	
	if ($check == '2') {
		$var = 'Result';
	}
	
	//get the information
	$sql = "SELECT * from help where help_questionid='$questionid' AND help_lan='$user_lan' AND help_var='$var'";
	$result = $conn->query($sql);
				
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$helptext = $row['help_text'];
			}
		}
	
?>

<div class="col-xs-2 pull-left"><span class="glyphicon glyphicon-question-sign glyphiconquestion" aria-hidden="true"></span></div>
</div> <!-- End row, started in questions.php -->

<!-- TO DO: Delete style and add to css file -->
<div id="helpblock" class="helpblock">
	<?php
		echo '<div class="col-xs-12 helpitem">';
			echo $helptext;
		echo '</div>';
	?>
</div>