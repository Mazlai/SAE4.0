<?php
		namespace Phpunit;

		require_once("connect.inc.php");
		error_reporting(0);
		$req1 = "SELECT * FROM VCARTONS_PAR_ARBITRE";

		$lesCartons =  oci_parse($connect, $req1);
		$result = oci_execute($lesCartons);
		if (!$result) {
			$e = oci_error($lesCartons);  // on récupère l'exception liée au pb d'execution de la requete
			return (htmlentities($e['message'].' pour cette requete : '.$e['sqltext']));		
		}
		
		echo "<H1> Les Cartons distribués par arbitre</H1>";
		echo "<table border='2'>";
			echo "<th>Prenom Arbitre</th><th>Nom Arbitre</th><th>Type Carton</th><th>Num match</th><th>Minute</th><th>Prenom Joueur</th><th>Nom Joueur</th>";
		while (($leCarton = oci_fetch_assoc($lesCartons)) != false) {
			echo '<TR>';
				echo "<TD>".$leCarton['PRENOMARBITRE']."</TD>";
				echo "<TD>".$leCarton['NOMARBITRE']."</TD>";
				echo "<TD>".$leCarton['CARTON']."</TD>";
				echo "<TD>".$leCarton['NUMMATCH']."</TD>";
				echo "<TD>".$leCarton['TEMPS']."</TD>";
				echo "<TD>".$leCarton['PRENOMJOUEUR']."</TD>";
				echo "<TD>".$leCarton['NOMJOUEUR']."</TD>";
			// $var = $leCarton['PRENOMARBITRE']." ".$leCarton['NOMARBITRE']." ".$leCarton['CARTON']." ".$leCarton['NUMMATCH']." ". $leCarton['TEMPS']." ".$leCarton['PRENOMJOUEUR']." ".$leCarton['NOMJOUEUR'];		
			// echo $var."<br/>";
			echo '</TR>';
			// prenomArbitre, nomArbitre, carton, numMatch, temps, prenomJoueur, nomJoueur
		}
		
		oci_free_statement($lesCartonsTrouves);

	// D'autres exemples d'utilisation d'OCI ici :  https://www.php.net/manual/fr/oci8.examples.php
?>
