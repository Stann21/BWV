<?php
	include_once ('header.php');
	
	include_once ('includes/sessions.inc.php');
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>
		
		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv text-center">	
			<div class="dashboard">
			<h1><?php echo $TRgroup; ?></h1>
			
			<?php 
				$userid = $_GET['user'];
		
		//Admin
		if ($userid == 1) {
			//Make a new group
				echo '<form action="includes/group.inc.php" method="POST">
				<div class="col-xs-4">
					<label>Group name</label>
					<input type="text" name="groupname" class="Input" placeholder="Group name" required>
					<input name="submit" type="Submit" value="Groep toevoegen" class="btn btn-default" />
				</div>
				</form>';
		
			//Show all groups.
			echo '<form action="includes/group.inc.php" method="POST">';
			$sql = "SELECT * FROM groups";
			$result = $conn->query($sql);
					
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$groupname = $row["groups_groupname"];
					$id = $row["groups_id"];
							
					echo '<a href="groupoverview.php?user=1&groupid='; echo $id; echo '">';
						echo '<div class="blockgroup block">';
							echo '<div class="blockcontent">';
								echo '<div class="table">';
									echo '<div class="table-cell">';
										echo '<h2 class="startuptitle extrabold">'; echo $groupname; echo '</h2>';
										echo '<input type="radio" name="deleteid" value="';echo $id;echo '">';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						echo '</div>';	
					echo '</a>';
				}
				
				echo '<div class="row">';
				echo '<button name="delete" type="submit" class="btn btn-danger" onclick="return checkDeleteNL()"/>Delete group</span></button>';
				echo '</div>';
				echo '</form>';
			}
		}
		
		//Users
		if ($userid >= 2) {
		//Get the groupid of the user
		$sql = "SELECT user_groups FROM users WHERE user_id = $userid";
		$result = $conn->query($sql);
				
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$groupid = $row["user_groups"];
				}
			}
				
		//Get all the users with the same groupid from the selected user.
		$sql = "SELECT * FROM users WHERE user_groups = $groupid";
		$result = $conn->query($sql);
				
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$groupuserid = $row["user_id"];
					$company = $row["user_company"];
					$profilepicture = $row["user_profilepicture"];
						
					//When there is no profile picture use a placeholder.
					if (empty ($profilepicture)) {
						$profilepicture = 'user.png';
					}
						
					if ($groupuserid != $userid) {
						echo '<a href="groupexpoverview.php?user='; echo $userid; echo '&groupuser='; echo $groupuserid; echo '">';
							echo '<div class="blockgroup block">';
								echo '<div class="blockcontent">';
									echo '<div class="table">';
										echo '<div class="table-cell">';
											echo '<h2 class="startuptitle extrabold">'; echo $company; echo '</h2>';
											echo '<img src="images/profilepictures/'; echo $profilepicture; echo ' " class="img-circle grouppicture grayscale hidden-xs"/>';
										echo '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';																								
						echo '</a>';
					}
				}
			}
		}
		?>
		</div> <!-- Einde dashboard -->
		</div> <!-- Einde col -->
		
		<?php 
			include_once ('right.php');
		?>
	</body>
</html>

<?php
	include_once ('footer.php');
?>

<!-- Confirmation for deleting NL -->
<script language="JavaScript" type="text/javascript">
function checkDeleteNL(){
    return confirm('Weet je het zeker?');
}
</script>