<html>
	<body>
	<?php
		require_once ('vendor/autoload.php');
		use \Statickidz\GoogleTranslate;

		$trans = new GoogleTranslate();
		$translated = $trans->translate($source, $target, $answer);
	?>
	</body>
</html>