<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On enlève l'association l'élève et l'étudiant
	if(isset($_SESSION['membre']) && isset($_GET['etudiant'])){
		
		$membre=$_SESSION['membre'];
		$etudiant=$_GET['etudiant'];
		
		mysqli_query($co,  "DELETE FROM appariement_enseignant
							WHERE etudiant='$etudiant'
							AND enseignant='$membre->login'");	
							
		$resultat=mysqli_query($co,  "SELECT nom,prenom
									  FROM etudiant
									  WHERE login='$etudiant'");
		$row=mysqli_fetch_row($resultat);
		$nom=$row[0];
		$prenom=$row[1];										
							
	}
	
	
	header("Location: ../../vues/enseignant/page_mes_etudiants.php?deleted=true&nom=$nom&prenom=$prenom");
?>