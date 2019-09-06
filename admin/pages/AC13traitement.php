<?php
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

	if ($result)
		echo "<meta http-equiv='refresh' content='0;url=../index.php?message=<font color=green> Ajout realisee ! </font> <input id=\"tournee\" name=\"tournee\" type=\"hidden\" value=\"<?php echo \"$TRNNUM\" ?>'>";
		else
			echo "<meta http-equiv='refresh' content='0;url=../index.php?message=<font color=red> Probleme pour ajouter ... </font>'>";
?>
