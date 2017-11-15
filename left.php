<?php 
	$userid = $_GET['user'];
	include_once ('includes/translate.inc.php');
?>

<div class="container-fluid">
	<div class="col-xs-12 col-sm-3 col-md-2 menuleft paddingreset">
	
	<nav class="navbar">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" href="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
	
	<?php
		//Get the userinfo
		$sql = "SELECT * FROM users WHERE user_id='$userid'";
		$result = $conn->query($sql);
			
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$firstname = $row["user_first"];
				$lastname = $row["user_last"];
				$companyname = $row["user_company"];
				$profilepicture = $row["user_profilepicture"];
				
				//Check if there is a profilepicture, if not then set a placeholder
				if (empty ($profilepicture)) {
					$profilepicture = 'user.png';
				}
			}
		}
			
			echo '<br><center><img class="img-circle userimg" src="images/profilepictures/'; echo $profilepicture; echo '" alt="User"  style=""> <br><br>';
			
			echo '<p class="extrabold">';
			echo $firstname;
			echo ' ';
			echo $lastname;
			echo '</p><p class="companyname">';
			echo $companyname;
			echo '</p>';
			
			//Get the pagename
			$pagename = basename($_SERVER['PHP_SELF']);
			//Depending on the pagename, make an item from the menu active
			switch ($pagename) {
				case "dashboard.php":
					$experimentactive = 'active';
					break;
					
				case "expoverview.php":
					$experimentactive = 'active';
					break;
					
				case "questions.php":
					$experimentactive = 'active';
					break;
						
				case "signup.php":
					$experimentactive = 'active';
					 break;
					
				case "group.php":
					$groupactive = 'active';
					break;
					
				case "groupexpoverview.php":
					$groupactive = 'active';
					break;
					
				case "groupoverview.php":
					$groupactive = 'active';
					break;
				
				case "sheets.php":
					$sheetsactive ='active';
					break;
					
				case "settings.php":
					$settingsactive = 'active';
					break;
			}
			
	?>
	   <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
    <br>
           <ul class="nav navbar-nav nav-pills nav-stacked" >
				<?php
					//Admin
					if ($userid == '1') {
						echo '<li class=" ';echo $experimentactive;echo ' "><a href="dashboard.php?user=';echo $userid;echo ' ">Startups';echo '</a></li>';
						echo '<li class=" ';echo $groupactive;echo ' "><a href="group.php?user=';echo $userid;echo ' ">';echo $TRgroup;echo '</a></li>';
						echo '<li class=" ';echo $sheetsactive;echo ' "><a href="sheets.php?user=';echo $userid;echo '&subject=experimentnl">Sheets';echo '</a></li>';
						echo '<li class=" ';echo $settingsactive;echo ' "><a href="settings.php?user=';echo $userid;echo ' ">';echo $TRsettings;echo '</a></li>';
					}
					//User
					if ($userid >= '2') {
						echo '<li class=" ';echo $experimentactive;echo ' "><a href="dashboard.php?user=';echo $userid;echo ' ">';echo $TRexperiment;echo '</a></li>';
						include_once ('includes/continue.inc.php');						

							//If there is no experment, then show nothing.
							if ($name == "experiment" && $expempty == 'yes') {
									
							}
							
							//Continue with last question from experiments
							if ($name == "experiment" && $expempty == 'no') {
								if ($finalqid == '0') {
									$finalqid = '1';
								}else {
									$finalqid = $expfinal;
								}
								echo '<li><a href="questions.php?user='; echo $userid; echo '&questionid='; echo $finalqid; echo '&experiment='; echo $finalsid; echo '">'; echo $TRcontinue; echo '</a></li>';					
							}
						
						echo '<li class=" ';echo $groupactive;echo ' "><a href="group.php?user=';echo $userid;echo ' ">';echo $TRgroup;echo '</a></li>';
						echo '<li class=" ';echo $settingsactive;echo ' "><a href="settings.php?user=';echo $userid;echo ' ">';echo $TRsettings;echo '</a></li>';
					}
				?>  
           </ul>   
		   
         <form action="includes/logout.inc.php" class="formlogout" method="POST">  
			<button class="logout btn btn-default" href="#" style="" type="submit" name="submit"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> <?php echo $TRlogout; ?></button>
         </form>
	</div> <!-- Einde col -->
      </ul>
    </div>
</nav>