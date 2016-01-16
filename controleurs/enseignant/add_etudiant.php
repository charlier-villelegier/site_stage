<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On associe l'élève et l'étudiant
	if(isset($_SESSION['membre']) && isset($_GET['etudiant'])){
		
		$membre=$_SESSION['membre'];
		$etudiant=$_GET['etudiant'];
		
		mysqli_query($co,  "INSERT INTO appariement_enseignant
							VALUES('$etudiant','$membre->login', CURDATE())");	
							
		$resultat=mysqli_query($co,  "SELECT nom,prenom
									  FROM etudiant
									  WHERE login='$etudiant'");
		$row=mysqli_fetch_row($resultat);
		$nom=$row[0];
		$prenom=$row[1];	
	}
	
	//On redirige vers ses étudiants
	header("Location: ../../vues/enseignant/page_mes_etudiants.php?added=true&nom=$nom&prenom=$prenom");
?>