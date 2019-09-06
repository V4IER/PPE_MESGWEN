<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="fr" />
		<title>MESGUEN - AC13M</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../css/tableau.css">
    <link rel="stylesheet" href="../admin/pages/style.css">
	</head>
	<body>
    <h2>Modifier une Etape</h2>
    <?php

    $con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

    $sql = "SELECT LIEUID, LIEUNOM
        FROM lieu";

    $result = mysqli_query($con,$sql);

    $cpt = mysqli_num_rows($result);

    ?>
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="box1">
              <p class="full-width-borders">AC13 - Modifier une Etape - Tournée <?php echo $_POST [ 'tournee' ] ; ?> Etape <?php echo $_POST [ 'etape' ] ; ?> </p>
          		<form action="../admin/pages/AC13traitementM.php" method="post">
          			<label for="Lieu" >Lieu</label>
          			<select class="liste1" size="1" name="lieu" id="lieu">
          				<option value="NULL">Selectionnez un lieu</option>
          				<?php
                    include 'connectAD.php';

                    $con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

          					$TRNNUM = $_GET['tournee'];

                    $ETPID = $_POST['etape'];

          					$sql = "SELECT LIEUID, LIEUNOM
          							FROM lieu";

          					$result = mysqli_query($con,$sql);

          					$cpt = mysqli_num_rows($result);

          					if ($cpt>0) {
          						while ($row = mysqli_fetch_array($result)) {
          							echo "<option value=$row[0]>$row[1]</option>";
          						}
          					} else {
          						echo "<select size=\"1\" name=\"numero\" id=\"numero\" disabled=\"disabled\" >";
          						echo "<option>Aucune information...</option>";
          					}
          	    		?>
          	    	</select>

          			<br/>
          			<br/>

          			<label>Rendez-vous entre :</label>
          			<input type="date" class="liste1" name="RDVDebut" id="RDVDebut"/>

                <br/>

          			<label>Et :</label>
          			<input type="date" class="liste1" name="RDVFin" id="RDVFin"/>

          			<br/>
          			<br/>

          			<label>Pris en charge le :</label>
                <input class="form-control" name="prisEnCharge" type="text" value="<?php $date = date("Y/m/d H:i:00"); echo "$date" ?>" readonly size="10" maxlength="8"/>

          			<br/>

          			<label>Commmentaire :</label>
          			<textarea class="commentaire" name="commentaire" id="AC121" rows="5" cols="15"></textarea>

          			<br/>
          			<br/>


                <input id="etape" name="etape" type="hidden" value="<?php echo "$ETPID" ?>"/>
          			<input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
                <button class="btn btn-light pull-left" id="button" name="valider" type="submit" value="Valider"/><img src="/admin/pages/image/valider.png"> valider</button>
          		</form>
              <form class="" action="../admin/index.php?page=dashboard" method="post">
                <input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
                <input id="etape" name="etape" type="hidden" value="<?php echo "$ETPID" ?>"/>
                <button class="btn btn-light pull-left" id="cancel2" type="submit" name="retour" value="Annuler" /><img src="/admin/pages/image/annuler.png"> annuler</button>
              </form>
              </div>
            </div>
           </div>
          <div class="col">
          <div class="box2">
	</body>

</html>
