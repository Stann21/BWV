<?php
	include_once ('header.php');
	include_once ('includes/sessions.inc.php');
?>

<html>
	<body>
		<?php 
			include_once ('left.php');
		?>
		
		<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-7 col-md-offset-2 centerdiv whitespace">	
		<?php
			include_once ('includes/expoverview.inc.php');
		?>
		</div> <!-- Einde col -->
		
		<?php 
			include_once ('right.php');
		?>
	
	</body>
</html>

<?php
	include_once ('footer.php');
?>