<?php
	session_start();
	include 'connectAD.php';

	$con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

	//on recupere les varirable issue du formulaire
	$tournee=$_GET['tournee'];
	$idetape=$_GET['idetape'];

	$sql = "DELETE FROM etape
			WHERE TRNNUM = $tournee
			AND ETPID = $idetape";

	$result = mysqli_query($con,$sql);

	if ($result){
			$_SESSION["Supression"] = "<font color=green> Supression etape réalisée ! </font>";
			 echo "<meta http-equiv='refresh' content='0;url=../index.php?page=dashboard'>";
	}else{
			$_SESSION["Error"] = "<font color=red>  ".erreurSQL().".... </font>";
			echo "<meta http-equiv='refresh' content='0;url=../index.php?page=dashboard'>";
	}
?>
