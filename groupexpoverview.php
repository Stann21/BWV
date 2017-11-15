<?php
	include_once ('header.php');
	include_once ('includes/sessions.inc.php');
	
	$groupuserid = $_GET['groupuser'];
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>
		
		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv text-center">
			<?php 
				$sql = "SELECT * FROM users WHERE user_id=$groupuserid";
				$result = $conn->query($sql);
				
				if ($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						$user_first = $row["user_first"];
						$user_last = $row["user_last"];
						$user_email = $row["user_email"];
						$user_company = $row["user_company"];
						$user_profilepicture = $row["user_profilepicture"];
						
						//When there is no profile picture use a placeholder.
						if (empty ($user_profilepicture)) {
							$user_profilepicture = 'user.png';
						}
					}
				}
			?>
			
			<h1><?php echo $user_company; ?></h1>
			
			<div class="dashboard">
			<?php include_once('includes/expdashboard.inc.php'); ?>
			
				<div class="col-xs-12">
				<div class="col-xs-12 col-sm-2">
					<a href="<?php echo 'group.php?user='; echo $userid; ?>"><button class="btn btn-default">Go back</button></a>
				</div>
				
				<div class="col-xs-12 col-sm-2 pull-right">
					<img src="images/profilepictures/<?php echo $user_profilepicture; ?> " class="img-circle userimgsmall infobox"/>
					<?php
							echo '<div class="userinfo text-left pull-right">';
									echo $user_first; echo '<br>'; 
									echo $user_last; echo '<br>'; 
									echo $user_email; echo '<br>'; 
									echo $user_company; echo '<br>';
							echo '</div>';
					?>
					</div>
				</div>
			</div> <!-- End dashboard -->
		</div> <!-- End col -->
		
		<?php 
			include_once ('right.php');
		?>
	</body>
</html>

<?php
	include_once ('footer.php');
?>