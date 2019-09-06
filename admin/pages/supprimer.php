<?php
	session_start();
	include 'connectAD.php';

	$con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

	$TRNNUM = $_GET['tournee'];

	$sql1 = "DELETE FROM etape
			WHERE TRNNUM = $TRNNUM";

	$result1 = mysqli_query($con,$sql1);

	$sql2 = "DELETE FROM tournee
			WHERE TRNNUM = $TRNNUM";

	$result2 = mysqli_query($con,$sql2);

	if ($result2){
			$_SESSION["Supression"] = "<font color=green> Supression tournées réalisée ! </font>";
			 echo "<meta http-equiv='refresh' content='0;url=../index.php?page=dashboard'>";
	}else{
			$_SESSION["Error"] = "<font color=red>  ".erreurSQL().".... </font>";
			echo "<meta http-equiv='refresh' content='0;url=../index.php?page=dashboard'>";
	}
?>
