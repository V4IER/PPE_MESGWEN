<?php
	include 'connectAD.php';
	
	//test pour voir si il s'agie d'une creation d'etape
	if (isset($_GET['valider'])) {
		// recuperate Des informations
		$date = $_GET['date'];
		$chauffeur = $_GET['chauffeur'];
		$voiture = $_GET['voiture'];
		$commentaire = $_GET['commentaire'];
		$prisEnCharge =$_GET['prisEnCharge'];
	
		//recherche du dernier id 
		$sql = "SELECT max(TRNNUM) 
				FROM tournee";
		
		$result = executeSQL($sql);
		
		$IdTournee = mysql_fetch_row($result);

		//recherche de l'id du chauffeur
		$sql = "SELECT CHFID 
				FROM chauffeur 
				WHERE CHFNOM = '$chauffeur'";
		
		$result = executeSQL( $sql);
		
		$chauffeurid = mysql_fetch_row($result);
		
		// envoie les informations sur la bdd
		$sql = "INSERT INTO tournee(TRNNUM, VEHIMMAT, CHFID, TRNCOMMENTAIRE, TRNDTE) 
				VALUES ($IdTournee[0]+1,'$voiture',$chauffeurid[0],'$commentaire','$prisEnCharge')";
		
		$result = executeSQL($sql);
	}
	
	if ($result)
		echo "<meta http-equiv='refresh' content='0;url=index.php?message=<font color=green> Ajout realisee ! </font>'>";
		else
			echo "<meta http-equiv='refresh' content='0;url=index.php?message=<font color=red> Probleme d'ajout ... </font>'>";
?>
