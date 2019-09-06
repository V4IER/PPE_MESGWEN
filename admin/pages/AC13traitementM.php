<?php
	session_start();
	include 'connectAD.php';

	$con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

	$TRNNUM = $_POST['tournee'];
	$IDLieu = $_POST['lieu'];
	$Debut = $_POST['RDVDebut'];
	$Fin = $_POST['RDVFin'];
	$Commentaire = $_POST['commentaire'];
	$ETPID = $_POST['etape'];

	$sql = "SELECT ETPID
			FROM etape
			WHERE TRNNUM = '$TRNNUM'";

	$result = mysqli_query($con,$sql);

	$cpt = compteSQL($sql);

	$sql = "UPDATE etape
			SET LIEUID = '$IDLieu',
			ETPHREDEBUT = '$Debut',
			ETPHREFIN = '$Fin',
			ETPCOMMENTAIRE = '$Commentaire'
			WHERE ETPID = '$ETPID';";

	$result = mysqli_query($con,$sql);

	if ($result){
			$_SESSION["Modification"] = "<font color=green> Modification etape réalisée ! </font>";
			 echo "<meta http-equiv='refresh' content='0;url=../index.php?page=dashboard'>";
	}else{
			$_SESSION["Error"] = "<font color=red>  ".erreurSQL().".... </font>";
			echo "<meta http-equiv='refresh' content='0;url=../index.php?page=dashboard'>";
	}
?>
