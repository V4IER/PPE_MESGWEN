<?php
	session_start();
	include 'connectAD.php';

	$con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

	//test pour voir si il s'agie d'une creation d'etape
	if (isset($_GET['valider'])) {
		// recuperate Des informations
		$date = $_GET['date'];
		$chauffeur = $_GET['chauffeur'];
		$voiture = $_GET['voiture'];
		$remorque = $_GET['remorque'];
		$commentaire = $_GET['commentaire'];
		$prisEnCharge =$_GET['prisEnCharge'];

		//recherche du dernier id
		$sql = "SELECT max(TRNNUM)
				FROM tournee";

		$result = executeSQL($sql);

		$IdTournee = mysqli_fetch_row($result);

		//recherche de l'id du chauffeur
		$sql = "SELECT CHFID
				FROM chauffeur
				WHERE CHFNOM = '$chauffeur'";

		$result = executeSQL( $sql);

		$chauffeurid = mysqli_fetch_row($result);

		// envoie les informations sur la bdd
		$sql = "INSERT INTO tournee(TRNNUM, VEHIMMAT, REMMAT, CHFID, TRNCOMMENTAIRE, TRNDTE)
				VALUES ($IdTournee[0]+1,'$voiture','$remorque',$chauffeurid[0],'$commentaire','$prisEnCharge')";

		$result = executeSQL($sql);


	if ($result){
			$_SESSION["Ajout"] = "<font color=green> Ajout tournée réalisée ! </font>";
			 echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
	}else{
			$_SESSION["Error"] = "<font color=red>  ".erreurSQL().".... </font>";
			echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
	}
}
else{
	$_SESSION["Renseigner"] = "<font color=red> Renseigner l'information... </font>";
	echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
}

	/*if ($result)
		echo "<meta http-equiv='refresh' content='0;url=../index.php?message=<font color=green> Ajout realisee ! </font>'>";
		else
			echo "<meta http-equiv='refresh' content='0;url=../index.php?message=<font color=red> Probleme d'ajout ... </font>'>";*/
?>
