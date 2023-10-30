<?php

namespace Phpunit;
require_once("connect.inc.php");
error_reporting(0);

$reqTest = 'SELECT * FROM JOUEUR';
$req = oci_parse($connect, $reqTest);

$result = oci_execute($req);

if (!$result) {
		$e = oci_error($req);  // on récupère l'exception liée au pb d'execution de la requete
		print htmlentities($e['message'].' pour cette requete : '.$e['sqltext']);		
	}

echo "<H1> Les joueurs : </H1>";
	echo "<table border='2'>";
		echo "<th>Numéro</th><th>Prénom</th><th>Nom</th><th>Poste</th><th>Capitaine</th><th>Numéro equipe</th>";
		while (($leJoueur = oci_fetch_assoc($req)) != false) {
			echo '<TR>';
				echo "<TD>".$leJoueur['NJ']."</TD>";
				echo "<TD>".$leJoueur['PREJ']."</TD>";
				echo "<TD>".$leJoueur['NOMJ']."</TD>";
				echo "<TD>".$leJoueur['PST']."</TD>";
				echo "<TD>".$leJoueur['CAP']."</TD>";
				echo "<TD>".$leJoueur['NE']."</TD>";
			echo '</TR>';
		}
		
?>