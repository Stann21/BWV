<?php
	include_once ('header.php');
?>

	<body>
		<div class="bg">
		<br><br><br><br><br><br>
			<div class="thumbnail login"><br>
			  <img class="logoimg" src="images/logoclean.png" alt="Logo BWV">
			  <div class="caption">
					<br>
					<?php
						if (empty ($_GET['active'])) {
							$active = '0';
							$message = ' ';
						}else {
							$active = $_GET['active'];
						}
						
						if (empty ($_GET['login'])) {
							$login = '0';
							$message = ' ';
						} else {
							$login = '1';
						}
						
						//Check for errors (Activation and password and/or email)
						if ($active == '1') {
							$message = 'Your account is activated, you can now login.';
						}
						if ($active =='2') {
							$message = 'Your account is already activated.';
						}
						if ($login == '1') {
							$message = 'Invalid username and/or password.';
						}
						echo $message;
					?>
					<form action="includes/login.inc.php" method="POST">
						<p>
							<label class="inloglabel">Gebruikersnaam</label><br>
							<input type="text" name="uid" class="Input" placeholder="Naam" required autofocus />
						</p>

						<p>
							<label class="inloglabel">Wachtwoord</label><br>
							<input type="password" name="pwd"  class="Input" placeholder="Wachtwoord" required/>
						</p>

						<p>
							<input name="submit" type="Submit" value="Login" class="btn btn-default" />
						</p>
					</form>
			  </div> <!-- End caption -->
			</div> <!-- End thumbnail login -->
		</div> <!-- End BG -->
	</body>
	
<?php
	include_once 'footer.php';
?>