<?php
	include_once ('header.php');
	
    $userid = $_GET['user'];
	
	include_once ('includes/sessions.inc.php');
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>

		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv text-center">
            <?php	
				//Admin
				if ($userid == '1') {
					echo '<h1>Startups</h1>';
					echo '<div class="dashboard">';
						echo '<div class="col-xs-4"><a href="signup.php?signup=normal&user=1"><p class="marginreset">Add new startup</p><img src="images/newstartup.png" class="userimg"></img></a></div>';
						include_once('includes/expdashboard.inc.php');
					echo '</div>';

				}
				
				//User
				if ($userid >= '2') {
					echo '<h1>'; echo $TRexperiment; echo '</h1>';
					echo '<div class="dashboard">';
						echo '<div id="addblock" class="block"><div class="blockcontent"><a href="includes/experiment.inc.php?questionid=1&user='; echo $userid; echo '"><span class="helper"></span><img src="images/expadd.png"></div></div></a>';   
						include_once('includes/expdashboard.inc.php');
					echo '</div>';
				}
            ?>
		</div> <!-- Einde col  -->
		<?php 
			include_once ('right.php');
		?>
	</body>
</html>

<?php
	include_once ('footer.php');
?>