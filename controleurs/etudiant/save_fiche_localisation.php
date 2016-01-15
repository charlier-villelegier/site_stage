<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$membre=$_SESSION['membre'];
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	//Etudiant
	if(isset($_POST['NomEtudiant']) && isset($_POST['PrenomEtudiant']) && isset($_POST['AdresseEtudiant']) 
		&& isset($_POST['VilleEtudiant']) && isset($_POST['CPEtudiant']) && isset($_POST['MailEtudiant']) 
		&& isset($_POST['TelEtudiant']) && isset($_POST['TelEntreprise']) && isset($_POST['MailPerso']) && isset($_POST['SujetStage'])){
			$nom_etudiant=$_POST['NomEtudiant'];
			$prenom_etudiant=$_POST['PrenomEtudiant'];
			$adresse_etudiant=$_POST['AdresseEtudiant'];
			$ville_etudiant=$_POST['VilleEtudiant'];
			$cp_etudiant=$_POST['CPEtudiant'];
			$mail_etudiant=$_POST['MailEtudiant'];
			$tel_etudiant=$_POST['TelEtudiant'];
			$tel_entreprise=$_POST['TelEntreprise'];
			$mail_perso=$_POST['MailPerso'];
			$sujet_stage=$_POST['SujetStage'];
			
			
			mysqli_query($co,  "UPDATE etudiant
								SET nom='$nom_etudiant', prenom='$prenom_etudiant',adresse='$adresse_etudiant',ville='$ville_etudiant',
								code_postal='$cp_etudiant', mail_iut='$mail_etudiant', tel_portable='$tel_etudiant', tel_entreprise='$tel_entreprise',
								mail_perso='$mail_perso', sujet_stage='$sujet_stage'
								WHERE login='$membre->login' AND mdp='$membre->mdp'");
	}
	
	//Entreprise
	if(isset($_POST['NomEntreprise']) && isset($_POST['AdresseEntreprise']) && isset($_POST['CPEntreprise']) && isset($_POST['VilleEntreprise'])){
		$nom_entreprise=$_POST['NomEntreprise'];
		$adresse_entreprise=$_POST['AdresseEntreprise'];
		$cp_entreprise=$_POST['CPEntreprise'];
		$ville_entreprise=$_POST['VilleEntreprise'];
		
		mysqli_query($co,  "UPDATE entreprise
							SET nom_entreprise='$nom_entreprise', adresse='$adresse_entreprise',code_postal='$cp_entreprise',ville='$ville_entreprise'
							WHERE num_entreprise IN (SELECT num_entreprise
													 FROM appariement_tuteur at, tuteur_entreprise t
													 WHERE at.tuteur=t.login
													 AND at.etudiant='$membre->login')");
	}
	
	//On met à jour le membre et on redirige vers le forumaire
	$membre->maj();
	header("Location: ../../vues/etudiant/page_fiche_localisation.php");
?>
