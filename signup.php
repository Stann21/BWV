<?php
	include_once ('header.php');
	include_once ('includes/sessions.inc.php');
	$user = $_GET["user"];
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>
		
		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv">		
			<div class="col-xs-12">
				<?php
					include_once('mail/index.php');
				?>
			</div>
		
			<div class="col-xs-12">
				<div class="dashboard">
					<h1 class="text-center"><?php echo $TRadduser ?></h1>
					<form action="signup.php?user=1" method="POST">						
						<p>
							<label class="inloglabel">E-mail</label>
						</p>
						
						<p>
							<input type="text" name="email"  class="Input" placeholder="E-mail" required />
						</p>

						<p>
							<input name="submit" type="Submit" value="Sign up" class="paddingreset btn btn-default" />
							<a href="dashboard.php?user=1"><p>Klik hier om terug te gaan</p></a>
						</p>
					</form>
				</div> <!-- End dashboard -->
			</div> <!-- Div xs12 -->
		</div> <!-- Einde col -->
		
		<?php 
			include_once ('right.php');
		?>
	
	</body>
</html>

<?php
	include_once ('footer.php');
?>