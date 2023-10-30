<?php

	namespace Phpunit;

// POUR TESTER CETTE PAGE, on considère qu'on a des nouvelles lignes dans la base :
/*

 INSERT INTO Equipe (ne, nome, pres, noms, dtns, nats) VALUES ('COL', 'Colombie', 'Pablo', 'Esteban', '30/05/1975', 'Colombie');
 INSERT INTO Equipe (ne, nome, pres, noms, dtns, nats) VALUES ('BRE', 'Bresil', 'Diego', 'Paolo', '31/08/1961', 'Bresil');
 
 // on utilise un nj en dur plutot que la sequence ici pour faciliter les tests...
 INSERT INTO Joueur (nj, pst, prej, nomj, ne) VALUES (300, 'Pilier', 'Pierro', 'Toto', 'COL'); 
 INSERT INTO Joueur (nj, pst, prej, nomj, ne) VALUES (301, 'Pilier', 'Eris', 'Titi', 'COL'); 
 
 INSERT INTO Joueur (nj, pst, prej, nomj, ne) VALUES (302, 'Pilier', 'Marco', 'Victory', 'BRE'); 
 INSERT INTO Joueur (nj, pst, prej, nomj, ne) VALUES (303, 'Pilier', 'Laurent', 'Teste', 'BRE'); 
  
  // on utilise un nm en dur plutot que la sequence ici pour faciliter les tests...
 INSERT INTO Match (nm, jrn, stade, ville, na, prea, noma, nata, ne1, ne2) 
 VALUES (20, 1, 'Aviva Stadium', 'Dublin', 1, 'Jaco', 'Peyper', 'Afrique du Sud', 'COL', 'BRE');


*/
	require_once("connect.inc.php");
 
  echo "<p>Veuillez entrer les informations de la nouvelle composition </p><BR/>";
	echo '<form method="post" enctype="multipart/form-data">';
		echo "<p>";
			echo "nm  : <input type='text' value='20' name='nm' /> <BR><BR>";
			echo "nj : <input type='text' value='300' name='nj' /> <BR><BR>";
			echo "prej : <input type='text' value='Pierro' name='prej' /><BR><BR>";
			echo 'nomj : <input type="text" value="Toto" name="nomj" /><BR><BR>';
			echo 'maillot : <input type="text" value="2" name="maillot" /><BR><BR>';
			echo "<input type='submit' name='Envoyer' value='Valider' />";
		echo "</p>";
	echo "</form>";
 
	// si le formulaire est soumis et bien rempli
	If ( isset($_POST['Envoyer']) && isset($_POST['nj']) && isset($_POST['prej'])  
	  && isset($_POST['nomj'])    && isset($_POST['nm']) && isset($_POST['maillot']) ) {

		$req = 'INSERT Into Composer VALUES (:pNm, :pNj, :pPrej, :pNomj, :pMaillot )';
		$insertComp = oci_parse($connect, $req);
		
		// on associe les valeurs aux paramètres de la requête via des variables (sinon ça marche pas !)
		oci_bind_by_name($insertComp, ":pNm", $_POST['nm']);
		oci_bind_by_name($insertComp, ":pNj", $_POST['nj']);
		oci_bind_by_name($insertComp, ":pPreJ", $_POST['prej']);
		oci_bind_by_name($insertComp, ":pNomJ", $_POST['nomj'] );
		oci_bind_by_name($insertComp, ":pMaillot", $_POST['maillot']);

		// on execute la requete
		$result = oci_execute($insertComp);
		// si erreur de requete alors affichage...
		if (!$result) {
			$e = oci_error($insertComp);  // on récupère l'exception liée au pb d'execution de la requete (violation PK par exemple)
			print htmlentities($e['message'].' pour cette requete : '.$e['sqltext']);		
		}	
	}
	
	$req1 = "SELECT * FROM Composer WHERE nj >= 300";

  $lesComp =  oci_parse($connect, $req1);
 	$result = oci_execute($lesComp);
	if (!$result) {
		$e = oci_error($lesComp);  // on récupère l'exception liée au pb d'execution de la requete
		print htmlentities($e['message'].' pour cette requete : '.$e['sqltext']);		
	}
	
	echo "<H1> Les Compositions pour les joueurs de numéro sup. ou égal à 300</H1>";
	echo "<table border='2'>";
		echo "<th>Num Match</th><th>Num Joueur</th><th>Prenom Joueur</th><th>Nom Joueur</th><th>Num Maillot</th>";
		while (($leComp = oci_fetch_assoc($lesComp)) != false) {
			echo '<TR>';
				echo "<TD>".$leComp['NM']."</TD>";
				echo "<TD>".$leComp['NJ']."</TD>";
				echo "<TD>".$leComp['PREJ']."</TD>";
				echo "<TD>".$leComp['NOMJ']."</TD>";
				echo "<TD>".$leComp['MAILLOT']."</TD>";
			echo '</TR>';
		}
	oci_commit($connect);
	oci_free_statement($lesComp);
	oci_close($connect);
	
	/*  Pour lancer ce script x fois il faut alors supprimer la nouvelle ligne insérée en faisant, dans SQL Developer :
		delete from composer where nm = 20;
		commit
	*/
?>
