<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	$membre=$_SESSION['membre'];
	
	if(isset($_POST['objet']) && isset($_POST['corps'])){
		
		$resultat=mysqli_query($co,  "SELECT mail_iut
									  FROM appariement_tuteur A, etudiant E
									  WHERE A.etudiant = E.login
									  AND tuteur='$membre->login'");
		$row=mysqli_fetch_row($resultat);
		$destinataire=$row[0];
		$objet=$_POST['objet'];
		$corps=$_POST['corps'];
		
		//On spécifie les headers
		$resultat=mysqli_query($co,  "SELECT mail
									  FROM tuteur_entreprise
									  WHERE login='$membre->login'");
		$row=mysqli_fetch_row($resultat);
		$mail=$row[0];
		$headers = 'From: '.$mail;

		// Envoi du mail
		mail($destinataire, $objet, $corps, $headers);				
	}
	
	//On redirige vers la bonnne page
	header("Location: ../../vues/tuteur/page_contact.php");
?>