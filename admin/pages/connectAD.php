<?php
include "AccesDonnees.php";

$ip=explode(".",$_SERVER['SERVER_NAME']);

switch ($ip[0]) {
    case 51 :
        //serveurSkylway
        $host = "localhost";
        $user = "18feyraud";
        $password = "Iroise29";
        $dbname = "MLR1";
        $port='3306';
        break;
    default :
        exit ("Serveur non reconnu...");
        break;
}

	$connexion=connexion($host,$port,$dbname,$user,$password);

	if ($connexion) {
		//echo "Connexion reussie $host:$port<br />";
		//echo "Base $dbname selectionnee... <br />";
		//echo "Mode acces : $modeacces<br />";
	}

	//deconnexion();
?>
