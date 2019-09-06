
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../css/tableau.css">
    <link rel="stylesheet" href="../admin/pages/style.css">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="content-language" content="fr" />
		<title>MESGUEN - AC12</title>
	</head>

	<body>
    <h2>Ajouter une Tournée</h2>
    <p class="full-width-borders">AC12 - Organiser les tournées - Ajouter une Tournée </p>
    <div class="container">
      <div class="row">
        <div class="col">
         <div class="box1">
      		<form id="formulaire" action="/admin/pages/AC12traitement.php" method="get">
      			<label for="date">Date :</label>
      			<input id="example-date-input" class="liste1" name="date" type="text" value="<?php $date=date("Y/m/d H:i"); echo "$date" ?>" size="15" maxlength="8"/>

      			<br/>
      			<br/>

      			<label for="chauffeur" >Chauffeur :</label>

      			<?php
      				include 'connectAD.php';

              $con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

      				$sql = "SELECT CHFNOM FROM chauffeur";

      				$result = mysqli_query($con,$sql);

      				$cpt = mysqli_num_rows($result);

      				if ($cpt>0) {
      					echo "<select class=\"liste1\" size=\"1\" name=\"chauffeur\" id=\"numero\">";

      					while ($row = mysqli_fetch_array($result)) {
      						echo "<option value=$row[0]>$row[0]</option>";
      					}

      				} else {
      					echo "<select class=\"liste1\" size=\"1\" name=\"chauffeur\" id=\"chauffeur\" disabled=\"disabled\" >";
      					echo "<option>Aucune information...</option>";
      				}

      				echo "</select>";
          		?>

          		<br/>
          		<br/>

      			<label for="voiture">Véhicule :</label>

      			<?php
      				$sql = "SELECT VEHIMMAT FROM vehicule";

      				$result = mysqli_query($con,$sql);

      				$cpt = mysqli_num_rows($result);

      				if ($cpt>0) {
      					echo "<select class=\"liste1\" size=\"1\" name=\"voiture\" id=\"voiture\">";

      					while ($row = mysqli_fetch_array($result)) {
      						echo "<option value=$row[0]>$row[0]</option>";
      					}

      				} else {
      					echo "<select class=\"liste1\" size=\"1\" name=\"voiture\" id=\"voiture\" disabled=\"disabled\" >";
      					echo "<option>Aucune information...</option>";
      				}

      				echo "</select>";
          		?>

      			<br/><br/>

            <label for="remorque">Remorque :</label>

            <?php
              $sql = "SELECT REMMAT FROM remorque";

              $result = mysqli_query($con,$sql);

              $cpt = mysqli_num_rows($result);

              if ($cpt>0) {
                echo "<select class=\"liste1\" size=\"1\" name=\"remorque\" id=\"remorque\">";

                while ($row = mysqli_fetch_array($result)) {
                  echo "<option value=$row[0]>$row[0]</option>";
                }

              } else {
                echo "<select class=\"liste1\" size=\"1\" name=\"remorque\" id=\"remorque\" disabled=\"disabled\" >";
                echo "<option>Aucune information...</option>";
              }

              echo "</select>";
              ?>

            <br/><br/>

      			<label for="prisEnCharge">Pris en charge le :</label>
      			<input class="form-control" name="prisEnCharge" type="text" value="<?php $date = date("Y/m/d H:i:00"); echo "$date" ?>" readonly size="10" maxlength="8"/>

      			<label for="commentaire">Tapez un commentaire :</label>
      			<textarea id="AC121" name="commentaire" rows="5" cols="15"></textarea>

            <br/>
            <br/>


      	    	<button id="button" name="valider" type="submit" value="Valider" class="btn btn-light pull-left"
      				<?php
      					$sql = "SELECT * FROM etape";

      					$result = mysqli_query($con,$sql);

      					$cpt = mysqli_num_rows($result);

      					/*if ($cpt==0){
      						echo("disabled=\"disabled\"");
      					}*/
      				?>
      			/> <img src="/admin/pages/image/valider.png"> valider</button>

      			<button id="cancel" class="btn btn-light pull-left" type="button" name="retour" value="Annuler" onclick="location.href='/admin/index.php?page=dashboard'" /><img src="/admin/pages/image/annuler.png"> annuler</button>
      	   	</form>
          </div>
         </div>
 <hr class="separation" />
     <div class="col">
      <div class="box2">

 		<table border="0" style="width:80%" >
 			<h2>Etapes :</h2>

		<table border="0" style="width:80%" >
			<?php
				//si il recois un numero il regarde si il y a des etapes associer .
				if (@$TRNNUM = $_GET['tournee']) {
					echo "<tr>
							<td>Numero de l'etape</td>
							<td>Nom du lieu</td>";

					//selection id de la ville
					$sql = "SELECT ETPID, LIEUNOM FROM commune, lieu, etape WHERE commune.VILID = lieu.VILID AND etape.LIEUID = lieu.LIEUID AND TRNNUM = $TRNNUM";

					$result = mysqli_query($con,$sql);

					$cpt = compteSQL($sql);

					while ($row = mysqli_fetch_array($result)) {
						echo "<tr>";
						echo "<td>$row[0]</td>";
						echo "<td>$row[1]</td>";
						echo "<td>
								<form id='supprimer' action='supprimer-etape.php'>
									<input id='idetape' name='idetape' type='hidden' value='$row[0]' />
									<input id='tournee' name='tournee' type='hidden' value='$TRNNUM'/>
									<input id='supprimer' name='supprimer' type='submit' value='Supprimer' />
								</form> </td>";

						echo"<td><img src=\"/admin/pages/image/modif02.png\" alt=\"erreur\" onclick=\"location.href='index.php?page=AC13'\" style=\"cursor:pointer;\" ></td>";
						echo"</tr>";
					}
				} else {
					//selection l'id de la nouvelle tournÃ©e
					$sql = "SELECT max(TRNNUM) FROM tournee";

					$result = executeSQL($sql);

					$IdTournee = mysqli_fetch_row($result);

					echo"</tr>";
					echo "<p>Aucune etape en cour...</p>";
				}
    		?>

		</table>


		<form id="AC13" action="/admin/pages/AC13.php" method="get">
			<input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
			<button class="btn btn-light" id="ajouter" name="ajouter" type="submit" value="Ajouter" disabled="disabled" /><img src="/admin/pages/image/add.png"> AJOUTER</button>
		</form>

		<?php
			if (isset($_GET['message']))
				echo $_GET['message'];
			else
				echo "&nbsp;";
		?>
	</body>
</html>
