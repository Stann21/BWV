<?php
	include_once ('dbh.inc.php');
	$userid = $_GET['user'];
	
	//Check if there is a groupid
	if (empty($_GET['groupid'])) {
		$groupid = 0;
	} else {
		$groupid = $_GET['groupid'];
	}
	
	//Check if it is a groupuser
		if (empty ($_GET['groupuser'])) {
			$groupuserid = '0';
			$check = '1';
		}else {
			$groupuserid = $_GET['groupuser'];
			$check = '2';
		}

	
	//Admin --> Dashboard
	if ($userid == '1' && $groupid == '0') {
		$sql = "SELECT * FROM users WHERE user_id > 1";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$userid1 = $row["user_id"];
				$company = $row["user_company"];
				$usergroup1 = $row["user_groups"];
				$profilepicture = $row["user_profilepicture"];
										
				if (empty($profilepicture)) {
					$profilepicture = 'user.png';
				}
				echo '<a href="groupexpoverview.php?user=1&groupuser=';
				echo $userid1;
				echo '&groupid=';
				echo $usergroup1;
				echo '">';
				echo '<div class="col-xs-4 startupblock">';
					echo $company; echo '<br>';
					echo '<img src="images/profilepictures/'; echo $profilepicture; echo ' " class="img-circle userimg grayscale" />';
				echo '</div>';
				echo '</a>';
			}
		}
	}
	
	//Admin --> Groupspage
	if ($userid == '1' && $groupid >= '1') {
		$sql = "SELECT * FROM experimenten WHERE exp_userid=$groupuserid";
		$result = $conn->query($sql);
				
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$id = $row["exp_id"];
				$experimentid = $row["exp_experimentid"];
				$date = $row["exp_date"];	
											
				echo '<a href="expoverview.php?user=';echo $userid;echo '&experiment=';echo $experimentid;echo '&groupuser='; echo $groupuserid; echo '">';
					echo '<div class="block">';
						echo '<div class="blockcontent">';
							echo '<div class="table">';
								echo '<div class="table-cell">';
									echo '<h2 class="bold">';
									echo $experimentid;
									echo '</h2><p class="date bold">';
									//Convert date to day-month-year
									$timestamp = strtotime($date);
									echo date('d/m/Y', $timestamp);
									echo '</p>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';;
				echo '</a>';
			}
		}
	}
	
	//Users
	if ($userid >= '2') {
		if ($check == '1') {
			$sql = "SELECT * FROM experimenten WHERE exp_userid=$userid";
		}
		
		if ($check == '2') {
			$sql = "SELECT * FROM experimenten WHERE exp_userid=$groupuserid";
		}
		//Get all the experiments from the right user
		$result = $conn->query($sql);
				
			if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$id = $row["exp_id"];
				$experimentid = $row["exp_experimentid"];
				$date = $row["exp_date"];
				
				if ($check == '1') {
					$userid = $row["exp_userid"];
				}
				
				if ($check == '2') {
					$groupuserid = $row["exp_userid"];
				}
	
				if ($check == '1') {
					echo '<a href="expoverview.php?user=';echo $userid;echo '&experiment=';echo $experimentid;echo '">';
				}
				
				if ($check == '2') {
					echo '<a href="expoverview.php?user=';echo $userid;echo '&experiment=';echo $experimentid;echo '&groupuser='; echo $groupuserid; echo '">';
				}
			
					echo '<div class="block">';
						echo '<div class="blockcontent">';
							echo '<div class="table">';
								echo '<div class="table-cell">';
									echo '<h2 class="bold">';
									echo $experimentid;
									echo '</h2><p class="date bold">';
									//Convert date to day-month-year
									$timestamp = strtotime($date);
									echo date('d/m/Y', $timestamp);
									echo '</p>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</a>';
			}
		}
	}
?>