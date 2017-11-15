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
			<?php 
				$userid = $_GET['user'];
				$groupid = $_GET['groupid'];
				
				//Get groupname
				$sql = "SELECT * FROM groups WHERE groups_id=$groupid";
				$result = $conn->query($sql);
			
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$groupname = $row["groups_groupname"];
					}
				}
				
				echo '<h1>';
				echo $groupname;
				echo '</h1>';
		
				//Admin
				if ($userid == 1) {
					//Show all groups.
					$sql = "SELECT * FROM users WHERE user_groups=$groupid";
					$result = $conn->query($sql);
							
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$company = $row["user_company"];
							$id = $row["user_id"];
									
							echo '<a href="groupexpoverview.php?user=1&groupuser='; echo $id; echo '&groupid='; echo $groupid; echo '">';
								echo '<div class="blockgroup block">';
									echo '<div class="blockcontent">';
										echo '<div class="table">';
											echo '<div class="table-cell">';
												echo '<h2 class="startuptitle extrabold">'; echo $company; echo '</h2>';
											echo '</div>';
										echo '</div>';
									echo '</div>';
								echo '</div>';	
							echo '</a>';
						}
					}
				}
		
				echo '<h2 class="marginbottom grouptitle">';
				echo 'Add people';
				echo '</h2>';
				echo '<div class="row marginbottom">';
				
				echo '<div class="table-responsive">';
					echo '<table class="table table-hover">';
						echo '<thead>';
							 echo '<tr>';
								echo '<th>Naam</th>';
								echo '<th>Bedrijf</th>';
								echo '<th>Huidige groep</th>';
								echo '<th>Selecteren?</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';

							//Admin
							if ($userid == 1) {
								echo '<form action="includes/groupoverview.inc.php?groupid='; echo $groupid; echo '" method="POST">';
								//Show all groups.
								$sql = "SELECT * FROM users WHERE user_id >= 2";
								$result = $conn->query($sql);
										
								if ($result->num_rows > 0) {
									while($row = $result->fetch_assoc()) {
										$user_id = $row['user_id'];
										$user_first = $row['user_first'];
										$user_last = $row['user_last'];
										$user_company = $row['user_company'];
										$user_groups = $row['user_groups'];
										
										echo '<tr>';
											echo '<td>'; echo $user_first; echo $user_last; echo '</td>';
											echo '<td>'; echo $user_company; echo '</td>';
											echo '<td>'; echo $user_groups; echo '</td>';
											echo '<td><input type="checkbox" name="groupid[]" class="Input" value=" '; echo $user_id; echo ' "></td>';
										echo '</tr>';
									}
								}
						echo '</tbody>';
					echo '</table>';
				echo '</div>';
				echo '</div>';
				echo '<div class="row marginbottom">';
					echo '<input name="submit" type="Submit" value="Toevoegen" class="btn btn-default" /> ';
				echo '</div>';
				echo '</form>';
			}
			?>
		</div> <!-- End dashboard -->
		</div> <!-- Einde col -->
		<?php 
			include_once ('right.php');
		?>
	</body>
</html>

<?php
	include_once ('footer.php');
?>