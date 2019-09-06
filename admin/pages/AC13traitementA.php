<?php
session_start();
	include 'connectAD.php';

	$con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

	$TRNNUM = $_POST['tournee'];
	$IDLieu = $_POST['lieu'];
	$Debut = $_POST['RDVDebut'];
	$Fin = $_POST['RDVFin'];
	$Commentaire = $_POST['commentaire'];

	$sql = "SELECT ETPID
			FROM etape
			WHERE TRNNUM = '$TRNNUM'";

	$result = mysqli_query($con,$sql);

	$cpt = compteSQL($sql);

	$ETPID = $cpt + 1;

	$sql = "INSERT INTO etape(TRNNUM, ETPID, LIEUID, ETPHREDEBUT, ETPHREFIN, ETPCOMMENTAIRE)
			VALUES (\"$TRNNUM\", \"$ETPID\",\"$IDLieu\", \"$Debut\", \"$Fin\", \"$Commentaire\");";

	$result = mysqli_query($con,$sql);

	if ($result){
			$_SESSION["Ajout"] = "<font color=green> Ajout etape réalisée ! </font>";
			 echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
	}else{
			$_SESSION["Error"] = "<font color=red>  ".erreurSQL().".... </font>";
			echo "<meta http-equiv='refresh' content='0;url=../index.php'>";
	}
?>
