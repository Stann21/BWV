<?php
	include_once ('header.php');
	include_once ('includes/sessions.inc.php');
	
	$userid = $_GET['user'];
	$settingsmessage = '';
	
	include_once ('includes/translate.inc.php');	
				//Check if submit button is pressed
                if(isset($_POST['submit'])) {
					//Automatic refresh
					header("location:settings.php?user=$userid");
						for($i = 0; $i < count($_FILES['file_img']['name']); $i++)
						{
							//Get everything from the $_FILES
							$filetmp = $_FILES["file_img"]["tmp_name"][$i];
							$filename = $_FILES["file_img"]["name"][$i];
							$filesize = $_FILES["file_img"]["size"][$i];
							$filepath = "images/profilepictures/" . $filename;

							//Check if file size is too big
							if ($filesize > 1000000){
								echo "<div class='col-xs-12 col-sm-6'><p class='error'>Je bestand is te groot. De maximale grootte van een afbeelding is 976kb/1000000b. Jouw afbeelding is ";
								echo $filesize;
								echo 'b groot. </p></div>';
							}
	
							//Get the length of the $filename and put it in a new variable
							$filechecker =  strlen ($filename);
							//If the filename is bigger then 2 (Then there is a file) then upload it to the db
							if ($filechecker >= 1) {
								move_uploaded_file($filetmp, $filepath);
								// The ? below are parameter markers used for variable binding
								$sql = "UPDATE users SET user_profilepicture=? WHERE user_id=?";
								$stmt = $conn->prepare($sql);
								//Bind the variables
								$stmt->bind_param("si", $filename, $userid);
								//Execute the prepared statement
								$stmt->execute();
								//Close the statement
								$stmt->close();
							}
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
				include_once('includes/settings.inc.php');
				echo '<div class="col-xs-12 paddingreset"><p class="extrabold text-center">';
					echo $settingsmessage;
				echo '</p></div>';
			?>
			<h1 class="text-center title"> <?php echo $TRsettings; ?> </h1>
			
			<div class="col-xs-12 col-sm-6">
			<!-- Language -->
			<p><?php echo $TRlanguage ?></p>
			<form action ="settings.php?user=<?php echo $userid; ?>" method="POST" enctype="multipart/form-data" >
			<div class="col-xs-12 paddingreset marginbottom">
				<div class="flagbox paddingreset">
					<label>
						<input type="radio" name="user_lan" value="NL" <?php if ($user_lan == "NL") {echo 'checked'; } ?>/>
						<img src="images/netherlands.png" class="flag">
					</label>
				</div><!-- Einde col -->
				<div class="flagbox paddingreset">
					<label>
						<input type="radio" name="user_lan" value="EN" <?php if ($user_lan == "EN") {echo 'checked'; } ?>/>
						<img src="images/greatbrittain.png" class="flag" />
					</label>
				</div><!-- Einde col -->
			</div><!-- Einde col -->
			
			<!--  Photo -->
			<p><?php echo $TRprofilepicture ?></p>
			<p>
				<img src='images/profilepictures/<?php echo $user_profilepicture; ?>' class="img-circle userimg"/>
				<label class="fileContainer">
					<span class="glyphicon glyphicon-cloud-upload choosefile" aria-hidden="true"></span>
					<span class="choosefile">Choose a file</span>
					<input type="file" name="file_img[]" class="inputimage inputfile" />
				</label>
            </p>
			
			<!-- Personal data -->
			<div class="Col-xs-12 paddingreset">
				<label name="user_first" class="labels"><?php echo $TRfirstname; ?></label>
				<input type ="text" class="input" name="user_first" value="<?php echo $user_first; ?>" required>
			</div> <!-- Einde col -->
			<div class="Col-xs-12 paddingreset">
				<label name="user_last" class="labels"><?php echo $TRlastname; ?></label>
				<input type ="text" class="input" name="user_last" value="<?php echo $user_last; ?>" required>
			</div> <!-- Einde col -->
			<div class="Col-xs-12 paddingreset">
				<label name="user_email" class="labels"><?php echo $TRemail; ?></label>
				<input type ="text" class="input" name="user_email" value="<?php echo $user_email; ?>" required>
			</div> <!-- Einde col -->
			<div class="Col-xs-12 paddingreset">
				<label name="user_company" class="labels"><?php echo $TRcompany; ?></label>
				<input type ="text" class="input" class="marginbottom" name="user_company" value="<?php echo $user_company; ?>" required>
			</div> <!-- Einde col -->
			<div class="col-xs-12 paddingreset">
				<input name="submit" type="submit" aria-hidden="true" value="<?php echo $TRsavesettings; ?>" class="btn btn-default" />
			</div>
			</form>
			</div> <!-- End col -->

			<!-- pwd -->
			<div class="col-xs-12 col-sm-6">
			<form action ="settings.php?user=<?php echo $userid; ?>" method="POST" enctype="multipart/form-data">
				<div class="col-xs-12 col-sm-6 paddingreset">
					<div class="col-xs-12 paddingreset">
						<label name="user_passwordold" class="labels">Old password</label>
						<input type ="password" class="input" class="marginbottom" name="user_pwdold" required>
					</div> <!-- Einde col -->
					<div class="col-xs-12 paddingreset marginbottom">
						<label name="user_passwordnew" class="labels">New password</label>
						<input type ="password" class="input" class="marginbottom" name="user_pwdnew" required>
					</div> <!-- Einde col -->
					<div class="col-xs-12 paddingreset">
						<input name="pwdsubmit" type="submit" aria-hidden="true" value="<?php echo $TRsavesettings; ?>" class="btn btn-default" />
					</div> <!-- End col -->
				</div> <!-- End col -->
			</form>			
		</div> <!-- End col -->
		</div> <!-- End col -->
		
		<?php 
			include_once ('right.php');
		?>
	
	</body>
</html>

<?php
	include_once ('footer.php');
?>