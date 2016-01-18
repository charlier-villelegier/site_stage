<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On associe l'élève et l'étudiant
	if(isset($_SESSION['membre']) && isset($_GET['to']) && isset($_GET['objet']) && isset($_GET['corps']) && isset($_GET['page'])){
		
		$membre=$_SESSION['membre'];
		$destinataire=$_GET['to'];
		$objet=$_GET['objet'];
		$corps=$_GET['corps'];
		
		//On spécifie les headers
		$headers = 'From: secretariat@gestionstage.com';

		// Envoi du mail
		mail($destinataire, $objet, $corps, $headers);
								
	}
	
	//On redirige vers la bonnne page
	if(($_GET['page'])=="tuteurs"){
		header("Location: ../../vues/secretariat/statistiques_tuteurs.php?sent=true");
	}
	else{
		header("Location: ../../vues/secretariat/page_stat_fiche.php?sent=true");
	}
	
?>