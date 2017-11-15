<?php
	include_once ('dbh.inc.php');

	$sql = "SELECT user_lan from users where user_id=$userid";
	$result = $conn->query($sql);
				
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$user_lan = $row['user_lan'];
		}
	}
				
	if ($user_lan == 'NL') {
		$TRexperiment = 'Experimenten';
		$TRexpoverview = 'Experiment overzicht';
		$TRgroup = 'Groep';
		$TRsettings = 'Instellingen';
		$TRlogout = 'Uitloggen';
		$TRedit = 'Antwoord aanpassen';
		$TRquestion = 'Vraag: ';
		$TRanswer = 'Antwoord: ';
		$TRresult = 'Resultaat ';
		$TRaddresult = 'Resultaat toevoegen';
		$TRsave = 'Volgende vraag';
		$TRoverview = 'Overzicht';
		$TRdutch = 'Nederlands';
		$TRenglish = 'Engels';
		$TRfirstname = 'Voornaam';
		$TRlastname = 'Achternaam';
		$TRemail = 'Email';
		$TRcompany = 'Bedrijf';
		$TRlanguage = "Taal";
		$TRprofilepicture = "Profiel foto";
		$TRsavesettings = "Opslaan";
		$TRaddquestion = "Vraag toevoegen";
		$TRadduser = "Startup aanmaken";
		$TRcontinue = "Doorgaan";
}
				
	if ($user_lan == 'EN') {
		$TRexperiment = 'Experiments';
		$TRexpoverview = 'Experiment overview';
		$TRgroup = 'Group';
		$TRsettings = 'Settings';
		$TRlogout = 'Logout';
		$TRedit = 'Edit answer here';
		$TRquestion = 'Question: ';
		$TRanswer = 'Answer: ';
		$TRresult = 'Results ';
		$TRaddresult = 'Add results';
		$TRsave = 'Next question';
		$TRoverview = 'Overview';
		$TRdutch = 'Dutch';
		$TRenglish = 'English';
		$TRfirstname = 'First name';
		$TRlastname = 'Last name';
		$TRemail = 'Email';
		$TRcompany = 'Company';
		$TRlanguage = "Language";
		$TRprofilepicture = "Profile picture";
		$TRsavesettings = "Save changes";
		$TRaddquestion = "Add question";
		$TRadduser = "Create startup";
		$TRcontinue = "Continue";
}
?>