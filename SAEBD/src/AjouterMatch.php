<?php

	namespace Phpunit;

	class AjouterMatch { 
		
		function AjouterMatch() {
			// on inclut le fichier de connexion à la base Oracle
			require_once("connect.inc.php");
			// pour laisser try... catch .. traiter les exceptions levées par Oracle ?
			error_reporting(0);
			
			// appel d'une proc stockée 
			// echo "<H1> Ajout d'un match </H1>";
			
			$req = 'begin AjouterMatch(seq_match.NEXTVAL, :p_jrn, :p_dtm, :p_stade, :p_ville, :p_na, :p_prea, :p_noma, :p_dtna, :p_nata, :p_ne1, :p_ne2, :p_scr1, :p_scr2); end; ';
			//$req = 'begin AjouterMatch(:p_jrn, :p_stade, :p_ville, :p_na, :p_prea, :p_noma, :p_nata, :p_ne1, :p_ne2); end; ';	
			$appelProcStock = oci_parse($connect, $req);
			// on définit la valeur du paramètre en entrée de la fonction
			
			$jrn = 1; 
			$dtm ='03/04/23'; 
			$stade = 'stade arletty' ; 
			$ville = 'Lyon'; 
			$na = 1; 
			$prea = 'Nic'; 
			$noma = 'Berry';
			$nata ='Ecosse'; 
			$ne1 ='FRA'; 
			$ne2 = 'BLA';
			$dtna = '04/12/58'; 
			$scr1 = 12; 
			$scr2 = 7; 
			
			oci_bind_by_name($appelProcStock, ':p_jrn', $jrn);
			oci_bind_by_name($appelProcStock, ':p_dtm', $dtm);
			oci_bind_by_name($appelProcStock, ':p_stade', $stade);
			oci_bind_by_name($appelProcStock, ':p_ville', $ville);
			oci_bind_by_name($appelProcStock, ':p_na', $na);
			oci_bind_by_name($appelProcStock, ':p_prea', $prea);
			oci_bind_by_name($appelProcStock, ':p_noma', $noma);
			oci_bind_by_name($appelProcStock, ':p_dtna', $dtna);
			oci_bind_by_name($appelProcStock, ':p_nata', $nata);
			oci_bind_by_name($appelProcStock, ':p_ne1', $ne1);
			oci_bind_by_name($appelProcStock, ':p_ne2', $ne2);
			oci_bind_by_name($appelProcStock, ':p_scr1', $scr1);
			oci_bind_by_name($appelProcStock, ':p_scr2', $scr2);
			
			$result = oci_execute($appelProcStock);
			
			if (!$result) {
				// on récupère l'exception liée au pb d'execution de la fonction (no data found pour cette équipe)
				$e = oci_error($appelProcStock);  
				// print htmlentities($e['message'].' pour la fonction : '.$e['sqltext']);
				return (htmlentities($e['message'].' pour la fonction : '.$e['sqltext']));
				// echo "</BR></BR></BR></BR>";		
			}
			else {
				// echo "</BR></BR> Match ajouté !</BR>";   
				/// echo "</BR></BR></BR></BR>";
				return "Match ajouté";
			}
			oci_commit($connect);
			oci_free_statement($appelProcStock);
			oci_close($connect);
		}
	
		$res = AjouterMatch();
		echo $res;

	}
	
?>
