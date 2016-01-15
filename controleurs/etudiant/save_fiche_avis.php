<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$membre=$_SESSION['membre'];
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	//Nom, prénom, TP, et mail perso
	if(isset($_POST['NomEtudiant']) && isset($_POST['PrenomEtudiant']) && isset($_POST['TP']) && isset($_POST['AdressePerso'])){
		$nom_etudiant=$_POST['NomEtudiant'];
		$prenom_etudiant=$_POST['PrenomEtudiant'];
		$tp=$_POST['TP'];
		$adresse_perso=$_POST['AdressePerso'];
		
		mysqli_query($co,  "UPDATE etudiant
							SET nom='$nom_etudiant', prenom='$prenom_etudiant',tp='$tp',mail_perso='$adresse_perso'
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
	
	//On vérifie s'il a déjà une fiche_avis dans la base de donnée
	$resultat = mysqli_query($co,  "SELECT sa_fiche_avis
									FROM etudiant e
									WHERE e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$num_fiche_avis=$row[0];
	//S'il n'en a pas on en créer une et on lui associe
	if($num_fiche_avis==0){
		mysqli_query($co,  "INSERT INTO fiche_avis VALUES()");
		$resultat=mysqli_query($co,  "SELECT MAX(num_fiche) FROM fiche_avis");
		$row = mysqli_fetch_row($resultat);
		$num_fiche_avis=$row[0];
		mysqli_query($co,  "UPDATE etudiant SET sa_fiche_avis=$num_fiche_avis WHERE login='$membre->login' AND mdp='$membre->mdp'");
	}
	
	//Rémunération
	if(isset($_POST['Remuneration']) && isset($_POST['Salaire'])){
		$remuneration = ($_POST['Remuneration']=="Remunere"? true : false);
		$salaire = ($remuneration? $_POST['Salaire'] : 0);
		
		mysqli_query($co,  "UPDATE fiche_avis
							SET remuneration='$remuneration', salaire='$salaire'
							WHERE num_fiche='$num_fiche_avis'");	
	}
	
	
	//Encadrement
	if(isset($_POST['Informaticien']) && isset($_POST['AppelInformaticien'])&& isset($_POST['Equipe'])&& isset($_POST['TailleEquipe'])){
		$encadre_informaticien = ($_POST['Informaticien']=="Informaticien"? true : false);
		$appel_informaticien = ($_POST['AppelInformaticien']=="AppelInformaticien"? true : false);
		$travail_seul = ($_POST['Equipe']=="Seul"? true : false);
		$taille_equipe = ($travail_seul? 0 : $_POST['TailleEquipe']);
		
		mysqli_query($co,  "UPDATE fiche_avis
							SET encadre_informaticien='$encadre_informaticien', appel_informaticien='$appel_informaticien',travail_seul='$travail_seul',
								taille_equipe='$taille_equipe'
							WHERE num_fiche='$num_fiche_avis'");	
	}
	
	//Environnement général
	if(isset($_POST['Materiel'])){							 	 
		$type_materiel = ($_POST['Materiel']=="PC"? $_POST['Materiel'] : $_POST['MaterielText']);
		$unix = (isset($_POST['UNIX']) ? true : false);
		$linux = (isset($_POST['LINUX']) ? true : false);
		$nt = (isset($_POST['NT']) ? true : false);
		$windows = (isset($_POST['WINDOWS']) ? true : false);
		$autre = ((isset($_POST['Autre']) ? $_POST['AutreSystemeText'] : NULL));
		$langage = ($_POST['Langage']);
		
		mysqli_query($co,  "UPDATE fiche_avis
							SET type_materiel='$type_materiel', unix='$unix',linux='$linux',
								nt='$nt', windows='$windows', autre_systeme='$autre', langage='$langage'
							WHERE num_fiche='$num_fiche_avis'");	
	}
	
	//Objet du stage
	if(isset($_POST['AutreObjetText'])){
		echo("c'est good");				 
		$systeme = (isset($_POST['Systeme']) ? true : false);
		$multimedia = (isset($_POST['Multimedia']) ? true : false);
		$reseau = (isset($_POST['Reseaux']) ? true : false);
		$dev_web = (isset($_POST['DeveloppementWEB']) ? true : false);
		$autre_dev = (isset($_POST['AutreDvpt']) ? true : false);
		$bd = (isset($_POST['BD']) ? true : false);
		$autre_objet = ((isset($_POST['AutreObjet']) ? $_POST['AutreObjetText'] : NULL));
		
		mysqli_query($co,  "UPDATE fiche_avis
							SET systeme='$systeme', multimedia='$multimedia',reseau='$reseau',
								web='$dev_web', autre_dev='$autre_dev', bd='$bd', autre_objet='$autre_objet'
							WHERE num_fiche='$num_fiche_avis'");	
	}
	
	
	//Objet du stage
	if(isset($_POST['Satisfait']) && isset($_POST['ExplicationSatisfaction'])){
		$satisfait_condition = ($_POST['Satisfait']=="Satisfait"? true : false);
		$explication_satisfaction = ($satisfait_condition? NULL : $_POST['ExplicationSatisfaction']);
		
		mysqli_query($co,  "UPDATE fiche_avis
							SET satisfait_condition='$satisfait_condition', explication_satisfaction='$explication_satisfaction'
							WHERE num_fiche='$num_fiche_avis'");	
	}
	
	//On met à jour le membre et on redirige vers le forumaire
	$membre->maj();
	header("Location: ../../vues/etudiant/page_fiche_avis.php?saved=true");
	
?>

 
		