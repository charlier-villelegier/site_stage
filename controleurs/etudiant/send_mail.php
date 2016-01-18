<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	$membre=$_SESSION['membre'];
	
	if(isset($_POST['objet']) && isset($_POST['corps'])){
		
		$resultat=mysqli_query($co,  "SELECT t.mail
									  FROM etudiant e, appariement_tuteur at, tuteur_entreprise t
									  WHERE e.login=at.etudiant
									  AND at.tuteur=t.login
									  AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
		$row=mysqli_fetch_row($resultat);
		$destinataire=$row[0];
		$objet=$_POST['objet'];
		$corps=$_POST['corps'];
		
		//On spécifie les headers
		$resultat=mysqli_query($co,  "SELECT mail_iut
									  FROM etudiant
									  WHERE login='$membre->login'");
		$row=mysqli_fetch_row($resultat);
		$mail=$row[0];
		$headers = 'From: '.$mail;

		// Envoi du mail
		mail($destinataire, $objet, $corps, $headers);				
	}
	
	//On redirige vers la bonnne page
	header("Location: ../../vues/etudiant/page_contact.php");
?>