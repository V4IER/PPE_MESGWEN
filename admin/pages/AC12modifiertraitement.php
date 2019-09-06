<?php
	include 'connectAD.php';

	//test pour voir si il s'agie d'une creation d'etape
	if (isset($_POST['valider'])) {
		// recuperate Des informations
		$date = $_POST['date'];
		$chauffeur = $_POST['chauffeur'];
		$voiture = $_POST['voiture'];
		$remorque = $_POST['remorque'];
		$commentaire = $_POST['commentaire'];
		$prisEnCharge =$_POST['prisEnCharge'];
		$TRNNUM = $_POST['tournee'];

		//recherche de l'id du chauffeur
		$sql = "SELECT CHFID
				FROM chauffeur
				WHERE CHFNOM = '$chauffeur'";

		$result = executeSQL( $sql);

		$chauffeurid = mysqli_fetch_row($result);

		// envoie les informations sur la bdd
		$sql = "UPDATE tournee
				SET VEHIMMAT = '$voiture', REMMAT = '$remorque', CHFID = '$chauffeurid[0]', TRNCOMMENTAIRE = '$commentaire', TRNDTE = '$prisEnCharge'
				WHERE TRNNUM = '$TRNNUM'";

		$result = executeSQL($sql);


	if ($result){
			$_SESSION["Modification"] = "<font color=green> Modification tournée réalisée ! </font>";
			 echo "<meta http-equiv='refresh' content='0;url=../admin/index.php?page=dashboard'>";
	}else{
			$_SESSION["Error"] = "<font color=red>  ".erreurSQL().".... </font>";
			echo "<meta http-equiv='refresh' content='0;url=../admin/index.php?page=dashboard'>";
	}
}
else{
	$_SESSION["Renseigner"] = "<font color=red> Renseigner l'information... </font>";
	echo "<meta http-equiv='refresh' content='0;url=../admin/index.php?page=dashboard'>";
}

	/*if ($result)
		echo "<meta http-equiv='refresh' content='0;url=../admin/index.php?message=<font color=green> Modification realisee ! </font>'>";
		else
			echo "<meta http-equiv='refresh' content='0;url=../admin/index.php?message=<font color=red> Probleme de modification ... </font>'>";*/
?>
