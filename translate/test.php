<?php
	include_once ('../header.php');

	session_start();
?>

<html>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<h1>Portfolio sprint 3</h1>
					<?php $text = 'Bij deze sprint heb ik mezelf vooral gefocust op het PHP gedeelte van de website. Er zijn heel veel dingen bijgekomen ten opzichte van de vorige keer. Daarom heb ik ook besloten om een changelog bij te houden. Hierbij “update” ik mijn cms telkens naar een nieuwe versie, en zet ik er telkens bij wat ik precies gedaan heb. Na deze sprint ben ik gebleven bij versie 1.7.0. Om te beginnen heb ik de grote divs met felle kleuren weggehaald en vervangen door nuttige divs die ik ga gebruiken. Zo heb ik ook javascript gebruikt om een grid te maken voor de categorie pagina. Ook heb ik de projectpagina opgedeeld in twee gedeeltes, links voor content en rechts voor fotos. Tot slot is er ook nog een inlogpagina bijgekomen, omdat je nu steeds meer kunt doen in het backend.
					Ik ben nog steeds ontzettend veel aan het leren over PHP. Hierbij kun je denken aan Sessions (inloggen) en $_Files (afbeeldingen uploaden). Verder kijk ik erg veel rond op w3schools voor tutorials en hulp als ik er niet uit kom. Tot slot probeer ik zoveel mogelijk alles zelf op te lossen. Als ik lang ergens mee bezig ben, heb ik het gevoel dat het beter blijft hangen bij mij. Als het echt niet lukt vraag ik alsnog hulp.'; ?>
					<p> <?php require_once ('template.php'); echo $result; ?> </p>
				</div>
			</div>
		</div>
	</body>
</html>

<?php
	include_once ('../footer.php');

?>