<?php

if(hasnt_password() == 1){
    header("Location:../admin/index.php?pVéhicule=password");
}

?>

<head>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
<link rel="stylesheet" href="../css/tableau.css">
<link rel="stylesheet" href="../admin/pages/style.css">
</head>
<body>
  <h2>Tableau de bord</h2>

  <p class="full-width-borders">AC11 - Organiser les tournées - Listes des tournées </p>

  <!-- création du tableau des tourée  -->
  <div class="tableau responsive-table-line" style="margin:0px auto;max-width:1110px;">
  	<table class="table table-bordered table-condensed table-body-center" style="margin:0px auto;max-width:1110px;">
      <thead>
        <!-- titre des colones -->
        <tr height="30">
          <th>Tourn&eacute;e</th>
          <th>Date</th>
          <th>Chauffeur</th>
          <th>V&eacute;hicule</th>
          <th>Remorque</th>
          <th>D&eacute;part</th>
          <th>Arriv&eacute;e</th>
          <th>Supprimer</th>
          <th>Modifier</th>
        </tr>
      </thead>

      <?php
        //insertion de la connection a la base de données
        include 'connectAD.php';

        $con=mysqli_connect("localhost","18feyraud","Iroise29","MLR1");

        //selection les infos pour la tournée
        $sql = "SELECT TRNNUM,TRNDTE,CHFNOM,VEHIMMAT,REMMAT
            FROM tournee,chauffeur
            WHERE tournee.CHFID=chauffeur.CHFID;";

        $result = mysqli_query($con,$sql);

        if($result) {
          while ($row = mysqli_fetch_array($result)) {
      ?>

      <!-- creation des ligne des tournée -->
        <tr>
          <td><?php echo $row['TRNNUM']; ?></td>
          <td><?php echo $row['TRNDTE']; ?></td>
          <td><?php echo $row['CHFNOM']; ?></td>
          <td><?php echo $row['VEHIMMAT']; ?></td>
          <!-- Nouveauté remorque -->
          <td><?php
            $REMMAT = $row['REMMAT'];
            if ($REMMAT = $REMMAT ) {
              echo $row['REMMAT'];
            }
            else {
              echo "AUCUNE";
            }
          ?></td>
          <td>
            <?php
              //ajout de l'info "depart"
              $TRNNUM = $row['TRNNUM'];

              $depart_sql =  "SELECT LIEUNOM
                      FROM lieu,etape
                      WHERE etape.LIEUID = lieu.LIEUID
                      AND etape.TRNNUM = ".$TRNNUM."
                      ORDER BY ETPHREDEBUT ASC;";

              $depart = mysqli_query($con,$depart_sql);
              $depart = mysqli_fetch_array($depart);

              echo $depart[0];
            ?>
          </td>

          <td>
            <?php
            //ajout de l'info "arrivee"
              $arrivee_sql =  "SELECT LIEUNOM
                      FROM lieu,etape
                      WHERE etape.LIEUID = lieu.LIEUID
                      AND etape.TRNNUM = ".$TRNNUM."
                      ORDER BY ETPHREDEBUT DESC;";

              $arrivee = mysqli_query($con,$arrivee_sql);
              $arrivee = mysqli_fetch_array($arrivee);

              echo $arrivee[0];
            ?>
          </td>

          <td>
            <form id="form_effacer" action="/admin/pages/supprimer.php" method="get">
              <input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
              <button id="effacer" name="effacer" type="submit" onclick="if(confirm('Voulez vous vraiment suprimer ?'))
                       show_alert('On suprime');
                       else show_alert('On ne fait rien') ;"
                       value="Supprimer" /><img src="/admin/pages/image/supr.png"></button>
            </form>
          </td>

          <td>
            <form id="AC12" action="index.php?page=AC12_modifier" method="post">
              <input id="tournee" name="tournee" type="hidden" value="<?php echo "$TRNNUM" ?>" />
              <button id="modifier" name="modifier" type="submit" value="Modifier" /><img src="/admin/pages/image/edit2.png"></button>
            </form>
          </td>
        <tr />
      <?php
          }
        }
      ?>
    </table>
  </div>

  <br/>
  <button id="add" class="btn btn-light" type="button" name="add" value="Ajouter"  onclick="location.href='index.php?page=AC12'" /><img src="/admin/pages/image/add.png"> ajouter</button>
  <button id="back" class="btn btn-light" type="button" name="retour" value="Retour" onclick="location.href='index.php?page=home'" /><img src="/admin/pages/image/annuler.png"> retour</button>

  <?php

  if (isset($_SESSION["Ajout"])) {
      echo $_SESSION["Ajout"];
      unset($_SESSION["Ajout"]);
  }

  if (isset($_SESSION["Supression"])) {
      echo $_SESSION["Supression"];
      unset($_SESSION["Supression"]);
  }

  if (isset($_SESSION["Modification"])) {
      echo $_SESSION["Modification"];
      unset($_SESSION["Modification"]);
  }

  if (isset($_SESSION["Error"])) {
      echo $_SESSION["Error"];
      unset($_SESSION["Error"]);
  }

  if (isset($_SESSION["Renseigner"])) {
      echo $_SESSION["Renseigner"];
      unset($_SESSION["Renseigner"]);
  }
      else
        echo "&nbsp;";

  ?>
</body>
