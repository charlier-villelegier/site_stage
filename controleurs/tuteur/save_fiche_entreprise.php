<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$membre=$_SESSION['membre'];
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	//Tuteur
	if(isset($_POST['NomResponsableStage']) && isset($_POST['PrenomResponsableStage'])){
		$nom=mysqli_real_escape_string($co,$_POST['NomResponsableStage']);
		$prenom=mysqli_real_escape_string($co,$_POST['PrenomResponsableStage']);
		
		mysqli_query($co,  "UPDATE tuteur_entreprise
							SET nom='$nom', prenom='$prenom'
							WHERE login='$membre->login' AND mdp='$membre->mdp'");	
	}
	
	//Entreprise
	if(isset($_POST['entrepriseRaisonSociale'])){
		$nom_entreprise=mysqli_real_escape_string($co,$_POST['entrepriseRaisonSociale']);
		
		mysqli_query($co,  "UPDATE entreprise
							SET nom_entreprise='$nom_entreprise'
							WHERE num_entreprise IN (SELECT entreprise
													FROM tuteur_entreprise
													WHERE login='$membre->login' AND mdp='$membre->mdp')");	
	}
	
	//On vérifie s'il a déjà une fiche_tuteur dans la base de données
	$resultat = mysqli_query($co,  "SELECT sa_fiche_tuteur
									FROM etudiant E, appariement_tuteur A, tuteur_entreprise T
									WHERE T.login='$membre->login' AND T.mdp='$membre->mdp'
									AND A.tuteur=T.login
									AND E.login=A.etudiant");
	$row = mysqli_fetch_row($resultat);
	$num_fiche_tuteur=$row[0];
	//S'il n'en a pas on en créer une et on lui associe
	if($num_fiche_tuteur==0){
		mysqli_query($co,  "INSERT INTO fiche_tuteur VALUES()");
		$resultat=mysqli_query($co,  "SELECT MAX(num_fiche) FROM fiche_tuteur");
		$row = mysqli_fetch_row($resultat);
		$num_fiche_tuteur=$row[0];
		mysqli_query($co,  "UPDATE etudiant SET sa_fiche_tuteur=$num_fiche_tuteur 
							WHERE login IN (SELECT etudiant
											FROM appariement_tuteur	A, tuteur_entreprise T
											WHERE A.tuteur = T.login
											AND T.login='$membre->login' AND T.mdp='$membre->mdp')");
	}
	
	//Jury
	if(isset($_POST['NumJury'])){
		$num_jury=$_POST['NumJury'];
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET num_jury='$num_jury'
							WHERE num_fiche ='$num_fiche_tuteur'");	
		
	}
	
	//Méthodes de travail et aptitudes
	if(isset($_POST['niveauConnaisance']) && isset($_POST['organisation']) && isset($_POST['initiative']) && isset($_POST['perseverance'])
		&& isset($_POST['efficacite']) && isset($_POST['interet'])){
		$niveau_connaissance=$_POST['niveauConnaisance'];
		$organisation=$_POST['organisation'];
		$initiative=$_POST['initiative'];
		$perseverance=$_POST['perseverance'];
		$efficacite=$_POST['efficacite'];
		$interet=$_POST['interet'];
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET niveau_connaissance='$niveau_connaissance',
							organisation='$organisation',
							initiative='$initiative',
							perseverance='$perseverance',
							efficacite='$efficacite',
							interet_travail='$interet'
							WHERE num_fiche ='$num_fiche_tuteur'");	
	}
	
	//Comportement général
	if(isset($_POST['presentation']) && isset($_POST['ponctualite']) && isset($_POST['assiduite']) && isset($_POST['expression'])
		&& isset($_POST['sociabilite']) && isset($_POST['communication'])){
		$presentation=$_POST['presentation'];
		$ponctualite=$_POST['ponctualite'];
		$assiduite=$_POST['assiduite'];
		$expression=$_POST['expression'];
		$sociabilite=$_POST['sociabilite'];
		$communication=$_POST['communication'];
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET presentation='$presentation',
							ponctualite='$ponctualite',
							assiduite='$assiduite',
							expression='$expression',
							sociabilite='$sociabilite',
							communication='$communication'
							WHERE num_fiche ='$num_fiche_tuteur'");	
	}
	
	//RH
	if(isset($_POST['nomContactRH']) && isset($_POST['mailContactRH']) && isset($_POST['telContactRH'])){
		$nom_rh=mysqli_real_escape_string($co,$_POST['nomContactRH']);
		$mail_rh=mysqli_real_escape_string($co,$_POST['mailContactRH']);
		$telephone_rh=mysqli_real_escape_string($co,$_POST['telContactRH']);
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET nom_rh='$nom_rh',
							mail_rh='$mail_rh',
							telephone_rh='$telephone_rh'
							WHERE num_fiche ='$num_fiche_tuteur'");
	}
	
	//Taxe
	if(isset($_POST['nomContactTaxe']) && isset($_POST['mailContactTaxe']) && isset($_POST['telContactTaxe'])){
		$nom_taxe=mysqli_real_escape_string($co,$_POST['nomContactTaxe']);
		$mail_taxe=mysqli_real_escape_string($co,$_POST['mailContactTaxe']);
		$telephone_taxe=mysqli_real_escape_string($co,$_POST['telContactTaxe']);
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET nom_taxe='$nom_taxe',
							mail_taxe='$mail_taxe',
							telephone_taxe='$telephone_taxe'
							WHERE num_fiche ='$num_fiche_tuteur'");
	}
	
	//Ecole
	if(isset($_POST['nomContactEcole']) && isset($_POST['mailContactEcole']) && isset($_POST['telContactEcole'])){
		$nom_relation=mysqli_real_escape_string($co,$_POST['nomContactEcole']);
		$mail_relation=mysqli_real_escape_string($co,$_POST['mailContactEcole']);
		$telephone_relation=mysqli_real_escape_string($co,$_POST['telContactEcole']);
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET nom_relation='$nom_relation',
							mail_relation='$mail_relation',
							telephone_relation='$telephone_relation'
							WHERE num_fiche ='$num_fiche_tuteur'");
	}
	
	//Embauche
	if(isset($_POST['embauche']) && isset($_POST['raisonEmbauche'])){
		$embauche=mysqli_real_escape_string($co,$_POST['embauche']);
		$raison_embauche=mysqli_real_escape_string($co,$_POST['raisonEmbauche']);

		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET embauche='$embauche',
							raison_embauche='$raison_embauche'
							WHERE num_fiche ='$num_fiche_tuteur'");
	}
	
	//Presence soutenance
	if(isset($_POST['PresenceSoutenance'])){
		$presence_soutenance=($_POST['PresenceSoutenance']=="Present" ? true : false);
		
		mysqli_query($co,  "UPDATE fiche_tuteur
							SET presence_soutenance='$presence_soutenance'
							WHERE num_fiche ='$num_fiche_tuteur'");
	}
	//On met à jour le membre et on redirige vers le forumaire
	$membre->maj();
	header("Location: ../../vues/tuteur/page_fiche_entreprise.php?saved=true");
?>