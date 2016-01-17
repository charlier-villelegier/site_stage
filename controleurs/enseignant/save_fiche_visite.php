<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$membre=$_SESSION['membre'];
	$etudiant=$_GET['etudiant'];
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	//On vérifie s'il a déjà une fiche_avis dans la base de donnée
	$resultat = mysqli_query($co,  "SELECT sa_fiche_visite
									FROM etudiant e
									WHERE e.login='$etudiant'");
	$row = mysqli_fetch_row($resultat);
	$num_fiche_visite=$row[0];
	//S'il n'en a pas on en créer une et on lui associe
	if($num_fiche_visite==0){
		mysqli_query($co,  "INSERT INTO fiche_visite VALUES()");
		$resultat=mysqli_query($co,  "SELECT MAX(num_fiche) FROM fiche_visite");
		$row = mysqli_fetch_row($resultat);
		$num_fiche_visite=$row[0];
		mysqli_query($co,  "UPDATE etudiant SET sa_fiche_visite=$num_fiche_visite WHERE login='$etudiant'");
	}
	
	//Visite stage
	if(isset($_POST['StagiaireRencontre'])){
		$visite_stage = ($_POST['StagiaireRencontre']=="StagiaireRencontre"? true : false);
		$date_visite = ($visite_stage ? $_POST['DateRencontre'] : NULL);
		
		mysqli_query($co,  "UPDATE fiche_visite
							SET visite_stage='$visite_stage',
							date_visite='$date_visite'
							WHERE num_fiche='$num_fiche_visite'");	
	}
	
	//Contact
	if(isset($_POST['NomRH']) && isset($_POST['TelRH']) && isset($_POST['MailRH'])){
		$drh = mysqli_real_escape_string($co,$_POST['NomRH']);
		$telephone_drh = mysqli_real_escape_string($co,$_POST['TelRH']);
		$mail_drh = mysqli_real_escape_string($co,$_POST['MailRH']);
		
		mysqli_query($co,  "UPDATE fiche_visite
							SET drh='$drh',
							telephone_drh='$telephone_drh',
							mail_drh='$mail_drh'
							WHERE num_fiche='$num_fiche_visite'");	
	}
	
	//Encadrement
	if(isset($_POST['Informaticien']) && isset($_POST['AppelInformaticien'])&& isset($_POST['Equipe'])){
		$encadre_informaticien = ($_POST['Informaticien']=="Informaticien"? true : false);
		$appel_informaticien = ($_POST['AppelInformaticien']=="AppelInformaticien"? true : false);
		$travail_seul = ($_POST['Equipe']=="Seul"? true : false);
		$taille_equipe = ($travail_seul? 0 : mysqli_real_escape_string($co,$_POST['TailleEquipe']));
		
		mysqli_query($co,  "UPDATE fiche_visite
							SET encadre_informaticien='$encadre_informaticien', 
							appel_informaticien='$appel_informaticien',
							travail_seul='$travail_seul',
							taille_equipe='$taille_equipe'
							WHERE num_fiche='$num_fiche_visite'");	
	}
	
	//Objet du stage
	
	$systeme = (isset($_POST['Systeme']) ? true : false);
	$multimedia = (isset($_POST['Multimedia']) ? true : false);
	$reseau = (isset($_POST['Reseaux']) ? true : false);
	$dev_web = (isset($_POST['DeveloppementWEB']) ? true : false);
	$autre_dev = (isset($_POST['AutreDvpt']) ? true : false);
	$bd = (isset($_POST['BD']) ? true : false);
	$autre_objet = ((isset($_POST['AutreObjet']) ? mysqli_real_escape_string($co,$_POST['AutreObjetText']) : NULL));
		
	mysqli_query($co,  "UPDATE fiche_visite
						SET systeme='$systeme', 
						multimedia='$multimedia',
						reseau='$reseau',
						web='$dev_web', 
						autre_dev='$autre_dev', 
						bd='$bd',
						autre_objet='$autre_objet'
						WHERE num_fiche='$num_fiche_visite'");	
	
	
	//Avis entreprise
	if(isset($_POST['Satisfaction']) && isset($_POST['CommentaireAvis'])){
		$avis_comportement = $_POST['Satisfaction'];
		$commentaire_comportement = mysqli_real_escape_string($co,$_POST['CommentaireAvis']);
		
		mysqli_query($co,  "UPDATE fiche_visite
							SET avis_comportement='$avis_comportement',
							commentaire_comportement='$commentaire_comportement'
							WHERE num_fiche='$num_fiche_visite'");	
	}
	
	//Avis formation
	if(isset($_POST['Manque'])){
		$manque_formation = (($_POST['Manque']=="Manque") ? true : false);
		$explication_formation = ($manque_formation? mysqli_real_escape_string($co,$_POST['CommentaireManque']) : NULL);
		
		mysqli_query($co,  "UPDATE fiche_visite
							SET manque_formation='$manque_formation',
							explication_formation='$explication_formation'
							WHERE num_fiche='$num_fiche_visite'");	
	}
	
	//Avis enseignant
	if(isset($_POST['AvisEnseignant']) && isset($_POST['Accueil'])){
		$avis_enseignant = mysqli_real_escape_string($co,$_POST['AvisEnseignant']);
		$accueil_entreprise = $_POST['Accueil'];
		$precaution = ($accueil_entreprise == 'AccueilSousCondition'? $precaution=$_POST['Precaution'] : NULL);
		
		
		mysqli_query($co,  "UPDATE fiche_visite
							SET avis_enseignant='$avis_enseignant',
							accueil_entreprise='$accueil_entreprise',
							precaution='$precaution'
							WHERE num_fiche='$num_fiche_visite'");	
	}
	
	//On met à jour le membre et on redirige vers le forumaire
	$membre->maj();
	header("Location: ../../vues/enseignant/page_fiche_visite.php?saved=true&etudiant=".$etudiant);
?>