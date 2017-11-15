<?php
include_once ('dbh.inc.php');

$userid = $_GET['user'];

	//Get user language
	$sql = "SELECT user_lan FROM users WHERE user_id=$userid";
	$result = $conn->query($sql);
		if ($result->num_rows> 0 ) {
			while($row = $result->fetch_assoc()) {
				$user_lan = $row["user_lan"];
			}
		}
	
	//Get max. question id for Cexperiment
	if ($user_lan == "NL") {
		$sql = "SELECT * FROM edsquestions ORDER BY edsq_id DESC LIMIT 1";
	}	
	if ($user_lan == "EN") {
		$sql = "SELECT * FROM edsquestionsen ORDER BY edsq_id DESC LIMIT 1";
	}
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$expmaxq = $row["edsq_id"];
		}
	}
	
	//Setup var for checking
	$Cexperiment = '1';
	$checker = '1';
	
	//Get all the answers from the right user
	$sql = "SELECT * FROM edsanswers WHERE edsa_userid=$userid ORDER BY edsa_experimentid";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$Equestionid = $row["edsa_questionid"];
				$Cexperimentid = $row["edsa_experimentid"];
				
				//Check the right Cexperiment
				if ($Cexperiment == $Cexperimentid) {
					//Check if there is a questionid in the db.
					if ($checker == $Equestionid) {
						$checker ++;
						$expfinal = $checker;
						
						//If checker is bigger then the maxq, then conintue with checking Cresults.
						if ($checker > $expmaxq) {
							//Reset checker
							$checker = '1';
							$Cexperiment ++;
						}
					}
				}
			}
		}
	
	//Check if there is an experiment
	$sql = "SELECT * FROM experimenten WHERE exp_userid=$userid AND exp_experimentid=$Cexperiment";
	$result = $conn->query($sql);
		if ($result->num_rows == 0) {
				$expempty = 'yes';
			}else {
				$expempty = 'no';
			}
		
		//Setup var for checking
		$Cresults = '1';
		$checker = '1';
		
		if (empty($expfinal)) {
			$expfinal = '1';
		}
		
		if (empty($name)) {
			$name = 'experiment';
		}
		
		if (empty($finalsid)) {
			$finalsid = '1';
		}
		
		if (empty($finalqid)) {
			$finalqid = '1';
		}
		
		//If experiments are smaller then Cresults, then continue with experiments.
		if ($Cexperiment > $Cresults && $expfinal <= $expmaxq) {
			$name = 'experiment';
			$finalsid = $Cexperiment;
			$finalqid = $expfinal;
		}
		
		if ($expfinal > $expmaxq) {
			$expfinal = '1';
			$finalsid = $Cexperiment;
		}
?>