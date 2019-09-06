<?php
if(admin()!=1){
    header("Location:index.php?page=dashboard");
}

?>

<!--<h2>Poster un article</h2>-->

<?php

    if(isset($_POST['post'])){
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));
        $posted = isset($_POST['public']) ? "1" : "0";

        $errors = [];

        if(empty($title) || empty($content)){
            $errors['empty'] = "Veuillez remplir tous les champs";
        }

        if(!empty($_FILES['image']['name'])){
            $file = $_FILES['image']['name'];
            $extensions = ['.png','.jpg','.jpeg','.gif','.PNG','.JPG','.JPEG','.GIF'];
            $extension = strrchr($file,'.');

            if(!in_array($extension,$extensions)){
                $errors['image'] = "Cette image n'est pas valable";
            }
        }

        if(!empty($errors)){
            ?>
                <div class="card red">
                    <div class="card-content white-text">
                        <?php
                            foreach($errors as $error){
                                echo $error."<br/>";
                            }
                        ?>
                    </div>
                </div>
            <?php
        }else{
            post($title,$content,$posted);
            if(!empty($_FILES['image']['name'])){
                post_img($_FILES['image']['tmp_name'], $extension);
            }else{
                $id = $db->lastInsertId();
                header("Location:index.php?page=post&id=".$id);
            }
        }
    }


?>

<!--<form method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="input-field col s12">
            <input type="text" name="title" id="title"/>
            <label for="title">Titre de l'article</label>
        </div>

        <div class="input-field col s12">
            <textarea name="content" id="content" class="materialize-textarea"></textarea>
            <label for="content">Contenu de l'article</label>
        </div>
        <div class="col s12">
            <div class="input-field file-field">
                <div class="btn col s2">
                    <span>Image de l'article</span>
                    <input type="file" name="image" class="col s12"/>
                </div>
                <input type="text" class="file-path col s10" readonly/>
            </div>
        </div>

        <div class="col s6">
            <p>Public</p>
            <div class="switch">
                <label>
                    Non
                    <input type="checkbox" name="public"/>
                    <span class="lever"></span>
                    Oui
                </label>
            </div>
        </div>

        <div class="col s6 right-align">
            <br/><br/>
            <button class="btn" type="submit" name="post">Publier</button>
        </div>

    </div>

</form>-->

<div class="CHAUFFEUR">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
              $sqlInsert = "INSERT into chauffeur (CHFID,CHFNOM,CHFPRENOM,CHFTEL,CHFMAIL)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [CHAUFFEUR]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM chauffeur";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>CHFID</th>
                      <th>CHFNOM</th>
                      <th>CHFPRENOM</th>
                      <th>CHFTEL</th>
                      <th>CHFMAIL</th>

                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['CHFID']; ?></td>
                      <td><?php  echo $row['CHFNOM']; ?></td>
                      <td><?php  echo $row['CHFPRENOM']; ?></td>
                      <td><?php  echo $row['CHFTEL']; ?></td>
                      <td><?php  echo $row['CHFMAIL']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<!--<div class="COMMUNE">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into COMMUNE (VILID,VILNOM)
                     values ('" . $column[0] . "','" . $column[1] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [COMMUNE]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM COMMUNE";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>VILID</th>
                      <th>VILNOM</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['VILID']; ?></td>
                      <td><?php  echo $row['VILNOM']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>-->

<div class="DOCUMENTATION">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into documentation (DOCID,TRNNUM,TYDOCID,DOCURL)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [DOCUMENTATION]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM documentation";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>DOCID</th>
                      <th>TRNNUM</th>
                      <th>TYPDOCID</th>
                      <th>DOCURL</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['DOCID']; ?></td>
                      <td><?php  echo $row['TRNNUM']; ?></td>
                      <td><?php  echo $row['TYPDOCID']; ?></td>
                      <td><?php  echo $row['DOCURL']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<div class="ETAPE">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into etape (TRNNUM,ETPID,LIEUID,ETPHREMIN,ETPHREMAX,ETPHREDEBUT,ETPHREFIN,ETPNBPALLIV,ETPNBPALLIVEUR,ETPNBPALCHARG,ETPNBPALCHARGEUR,ETPCHEQUE,ETPETATLIV,ETPCOMMENTAIRE,ETPVAL,ETPKM)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "','" . $column[8] . "','" . $column[9] . "'
                       ,'" . $column[10] . "','" . $column[11] . "','" . $column[12] . "','" . $column[13] . "','" . $column[14] . "','" . $column[15] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [ETAPE]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM etape";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>TRNNUM</th>
                      <th>ETPID</th>
                      <th>LIEUID</th>
                      <th>ETPHREMIN</th>
                      <th>ETPHREMAX</th>
					            <th>ETPHREDEBUT</th>
                      <th>ETPHREFIN</th>
                      <th>ETPNBPALLIV</th>
                      <th>ETPNBPALLIVEUR</th>
                      <th>ETPNBPALCHARG</th>
                      <th>ETPNBPALCHARGEUR</th>
                      <th>ETPCHEQUE</th>
                      <th>ETPETATLIV</th>
                      <th>ETPCOMMENTAIRE</th>
                      <th>ETPVAL</th>
                      <th>ETPKM</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['TRNNUM']; ?></td>
                      <td><?php  echo $row['ETPID']; ?></td>
                      <td><?php  echo $row['LIEUID']; ?></td>
                      <td><?php  echo $row['ETPHREMIN']; ?></td>
                      <td><?php  echo $row['ETPHREMAX']; ?></td>
					            <td><?php  echo $row['ETPHREDEBUT']; ?></td>
                      <td><?php  echo $row['ETPHREFIN']; ?></td>
                      <td><?php  echo $row['ETPNBPALLIV']; ?></td>
                      <td><?php  echo $row['ETPNBPALLIVEUR']; ?></td>
                      <td><?php  echo $row['ETPNBPALCHARG']; ?></td>
                      <td><?php  echo $row['ETPNBPALCHARGEUR']; ?></td>
                      <td><?php  echo $row['ETPCHEQUE']; ?></td>
                      <td><?php  echo $row['ETPETATLIV']; ?></td>
                      <td><?php  echo $row['ETPCOMMENTAIRE']; ?></td>
                      <td><?php  echo $row['ETPVAL']; ?></td>
                      <td><?php  echo $row['ETPKM']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<div class="LIEU">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into lieu (LIEUID,VILID,LIEUNOM,LIEUCOORDGPS)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [LIEU]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM lieu";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>LIEUID</th>
                      <th>VILID</th>
                      <th>LIEUNOM</th>
                      <th>LIEUCOORDGPS</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['LIEUID']; ?></td>
                      <td><?php  echo $row['VILID']; ?></td>
                      <td><?php  echo $row['LIEUNOM']; ?></td>
                      <td><?php  echo $row['LIEUCOORDGPS']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<div class="PHOTO">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into photo (PHOID,TRNNUM,ETPID,PHOURL)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [PHOTO]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM photo";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>PHOID</th>
                      <th>TRNNUM</th>
                      <th>ETPID</th>
                      <th>PHOURL</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['PHOID']; ?></td>
                      <td><?php  echo $row['TRNNUM']; ?></td>
                      <td><?php  echo $row['ETPID']; ?></td>
                      <td><?php  echo $row['PHOURL']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<div class="TOURNEE">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into tournee (CHFID,TRNCOMMENTAIRE,TRNDTE,TRNNUM,TRNPECCHAUFFEUR,VEHIMMAT)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [TOURNEE]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM tournee";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>CHFID</th>
                      <th>TRNCOMMENTAIRE</th>
                      <th>TRNDTE</th>
                      <th>TRNNUM</th>
                      <th>TRNPECCHAUFFEUR</th>
					            <th>VEHIMMAT</th>

                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['CHFID']; ?></td>
                      <td><?php  echo $row['TRNCOMMENTAIRE']; ?></td>
                      <td><?php  echo $row['TRNDTE']; ?></td>
                      <td><?php  echo $row['TRNNUM']; ?></td>
                      <td><?php  echo $row['TRNPECCHAUFFEUR']; ?></td>
					            <td><?php  echo $row['VEHIMMAT']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<div class="TYPEDOCUMENTATION">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into typedocumentation (TYPDOCID,TYPDOCLIB)
                     values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [TYPEDOCUMENTATION]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM typedocumentation";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>TYPDOCID</th>
                      <th>TYPDOCLIB</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['TYPDOCID']; ?></td>
                      <td><?php  echo $row['TYPDOCLIB']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>

<div class="VEHICULE">
  <?php
  $conn = mysqli_connect("localhost", "admin", "erodel26", "MLR1");

  if (isset($_POST["import"])) {

      $fileName = $_FILES["file"]["tmp_name"];

      if ($_FILES["file"]["size"] > 0) {

          $file = fopen($fileName, "r");

          while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
              $sqlInsert = "INSERT into vehicule (VEHIMMAT,VEHNOM)
                     values ('" . $column[0] . "','" . $column[1] . "')";
              $result = mysqli_query($conn, $sqlInsert);

              if (! empty($result)) {
                  $type = "success";
                  $message = "CSV Data Imported into the Database";
              } else {
                  $type = "error";
                  $message = "Problem in Importing CSV Data";
              }
          }
      }
  }
  ?>
  <style>

  .outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
  }

  .input-row {
    margin-top: 0px;
    margin-bottom: 20px;
  }

  .btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
  }

  .outer-scontainer table {
    border-collapse: collapse;
    width: 100%;
  }

  .outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  .outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: left;
  }

  #response {
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 2px;
      display:none;
  }

  .success {
      background: #c7efd9;
      border: #bbe2cd 1px solid;
  }

  .error {
      background: #fbcfcf;
      border: #f3c6c7 1px solid;
  }

  div#response.display-block {
      display: block;
  }
  </style>

  <script src="jquery-3.2.1.min.js"></script>

  <script type="text/javascript">
  $(document).ready(function() {
      $("#frmCSVImport").on("submit", function () {

        $("#response").attr("class", "");
          $("#response").html("");
          var fileType = ".csv";
          var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
          if (!regex.test($("#file").val().toLowerCase())) {
                $("#response").addClass("error");
                $("#response").addClass("display-block");
              $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
              return false;
          }
          return true;
      });
  });
  </script>

      <h2>Importer un fichier CSV dans Mysql [VEHICULE]</h2>

      <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
      <div class="outer-scontainer">
          <div class="row">

              <form class="form-horizontal" action="" method="post"
                  name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                  <div class="input-row">
                      <label class="col-md-4 control-label">Choisir un CSV
                          </label> <input type="file" name="file"
                          id="file" accept=".csv">
                      <button type="submit" id="submit" name="import"
                          class="btn-submit">Importer</button>
                      <br />

                  </div>

              </form>

          </div>
                 <?php
              $sqlSelect = "SELECT * FROM vehicule";
              $result = mysqli_query($conn, $sqlSelect);

              if (mysqli_num_rows($result) > 0) {
                  ?>
              <table id='userTable'>
              <thead>
                  <tr>
                      <th>VEHIMMAT</th>
                      <th>VEHNOM</th>
                  </tr>
              </thead>
              <?php

                  while ($row = mysqli_fetch_array($result)) {
                      ?>

                  <tbody>
                  <tr>
                      <td><?php  echo $row['VEHIMMAT']; ?></td>
                      <td><?php  echo $row['VEHNOM']; ?></td>
                  </tr>
                      <?php
                  }
                  ?>
                  </tbody>
          </table>
          <?php } ?>
      </div>
</div>
