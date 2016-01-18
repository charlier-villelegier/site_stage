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
		$resultat=mysqli_query($co,  "SELECT mail
									  FROM enseignant
									  WHERE login='$membre->login'");
		$row=mysqli_fetch_row($resultat);
		$mail=$row[0];
		$headers = 'From: '.$mail;

		// Envoi du mail
		mail($destinataire, $objet, $corps, $headers);
								
	}
	
	//On redirige vers la bonnne page
	if(($_GET['page'])=="dispo"){
		header("Location: ../../vues/enseignant/page_etudiant_disponible.php?sent=true");
	}
	else{
		header("Location: ../../vues/enseignant/page_mes_etudiants.php?sent=true");
	}
	
?>