<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		header('Location: ../../index.html'); 
	}
	$membre=$_SESSION['membre'];
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	//Professeur tuteur
	$resultat = mysqli_query($co, "SELECT en.nom,en.prenom 
									FROM etudiant e, appariement_enseignant ae, enseignant en
									WHERE e.login=ae.etudiant
									AND ae.enseignant=en.login
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$nom_prof_tuteur=$row[0]." ".$row[1];
	
	//TP et mail perso
	$resultat = mysqli_query($co, "SELECT e.tp,e.mail_perso 
									FROM etudiant e
									WHERE e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$tp=$row[0];
	$mail_perso=$row[1];
	
	//Entreprise
	$resultat = mysqli_query($co, "SELECT en.nom_entreprise, en.adresse, en.code_postal, en.ville 
									FROM etudiant e, appariement_tuteur at, tuteur_entreprise t, entreprise en 
									WHERE e.login=at.etudiant 
									AND at.tuteur=t.login 
									AND t.entreprise=en.num_entreprise 
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$nom_entreprise=$row[0];
	$adresse_entreprise=$row[1];
	$code_postal_entreprise=$row[2];
	$ville_entreprise=$row[3];
	
	//Tuteur en entreprise
	$resultat = mysqli_query($co, "SELECT t.nom,t.prenom, t.fonction 
									FROM etudiant e, appariement_tuteur at, tuteur_entreprise t
									WHERE e.login=at.etudiant
									AND at.tuteur=t.login
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$nom_tuteur_entreprise=$row[0]." ".$row[1];
	$fonction_tuteur_entreprise=$row[2];
	
	//Rémunération
	$resultat = mysqli_query($co, "SELECT f.remuneration, f.salaire 
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$remuneration=$row[0];
	$salaire=$row[1];
	
	//Encadrement
	$resultat = mysqli_query($co, "SELECT f.encadre_informaticien, f.appel_informaticien, f.travail_seul, f.taille_equipe 
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$encadre_informaticien=$row[0];
	$appel_informaticien=$row[1];
	$travail_seul=$row[2];
	$taille_equipe=$row[3];
	
	//Environnement
	$resultat = mysqli_query($co, "SELECT f.type_materiel, f.unix, f.linux, f.nt, f.windows, f.autre_systeme, f.langage 
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$type_materiel=$row[0];
	$unix=$row[1];
	$linux=$row[2];
	$nt=$row[3];
	$windows=$row[4];
	$autre_systeme=$row[5];
	$langage=$row[6];
	
	//Objet du stage
	$resultat = mysqli_query($co, "SELECT f.systeme, f.multimedia, f.reseau, f.web, f.autre_dev, f.bd, f.autre_objet 
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$systeme=$row[0];
	$multimedia=$row[1];
	$reseau=$row[2];
	$web=$row[3];
	$autre_dev=$row[4];
	$bd=$row[5];
	$autre_objet=$row[6];
	
	//Avis de l'étudiant sur le stage
	$resultat = mysqli_query($co, "SELECT f.satisfait_condition, f.explication_satisfaction
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$satisfait_condition=$row[0];
	$explication_satisfaction=$row[1];
	
	//Objectifs du stage
	$resultat = mysqli_query($co, "SELECT f.objectif_atteint, f.explication_objectif
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$objectif_atteint=$row[0];
	$explication_objectif=$row[1];
	
	//Matières à développer
	$resultat = mysqli_query($co, "SELECT f.matiere_dev, f.explication_matiere
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$matiere_dev=$row[0];
	$explication_matiere=$row[1];
	
	//Appport du stage
	$resultat = mysqli_query($co, "SELECT f.apport_stage
									FROM etudiant e, fiche_avis f
									WHERE e.sa_fiche_avis=f.num_fiche
									AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
	$row = mysqli_fetch_row($resultat);
	$apport_stage=$row[0];
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head> 
    <title>Gestion des stages - Accueil</title>
    <link href="../../style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../js/buttons.css"/>
    <link rel="stylesheet" type="text/css" href="../../js/animate.css"/>
    <link rel="stylesheet" href="../../js/font-awesome/css/font-awesome.min.css"/>
	<script src="../../js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  
  <body>
    <div class="ConteneurLogo"></div>
    <div class="ConteneurConnexion">
    	<div class="ConteneurHautPetit"></div>
		<div class="ConteneurPrincipalePetit">
			<div class="ConteneurPetitPlan">
				<div class="PlanMenu">Votre compte</div>
                <form method="post" action="../../controleurs/deconnexion.php">
					<div class="TexteBonjour">
                    	<p>
							<?php $membre=$_SESSION['membre']; echo "Bonjour ".strtoupper($membre->nom)." ".$membre->prenom; ?> 
						</p>
                    </div>
              
                    <p>
                    	Statut : Etudiant
                    </p>
                    <p>
						<input name="Deconnexion" type="submit" value="Déconnexion"/>
					</p>
                   
				</form>
			</div>
		</div>
		<div class="ConteneurBasPetit">
			<a href="change_mdp.php" style="font-size:11">Changer mon mot de passe</a>
        </div>
    </div>
    <div class="menu">
		<div class="ConteneurHautPetit"></div>
		<div class="ConteneurPrincipalePetit">
			<div class="ConteneurPetitPlan">
				<div class="PlanMenu">Mes fiches</div>
				<ul>
					<li><div class="TitrePlan"><a href="page_fiche_localisation.php">Fiche de localisation</a></div></li>
					<li><div class="TitrePlan"><a href="#">Fiche d'avis sur le stage</a></div></li>
				</ul>
			</div>
		</div>
		<div class="ConteneurBasPetit"></div>
    </div>
    <div class="contenu_page">
		<div class="ConteneurHaut"></div>
		<div class="ConteneurPrincipale">
			<div class="Bleue">
				<div id="Ribbon">
					<ul>
						<li><a href="accueil.php">Accueil</a></li>
						<li><a href="page_fiche_localisation.php" class="PageActive">Mes fiches</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">AVIS ETUDIANT</div>
					<form method="post" action="../../controleurs/etudiant/save_fiche_avis.php">
					<p>
						<label for="NomEtudiant">Nom : </label>
							<input name="NomEtudiant" type="text" value="<?php echo $membre->nom ?>"/>
							
						<label for="PrenomEtudiant">Prénom : </label>
							<input name="PrenomEtudiant" type="text" value="<?php echo $membre->prenom ?>"/>
						<br/>
						<br/>
						
							
						<label for="Tuteur">Nom du tuteur / de la tutrice : </label>
							<input name="Tuteur" type="text" disabled="disabled" value="<?php echo $nom_prof_tuteur ?>"/>
						<br/>
						<br/>
						
						<label for="TP">TP : </label>
							<input name="TP" type="text" value="<?php echo $tp ?>"/>
						
						<label for="AdressePerso">Adresse électronique autre que IUT : </label>
							<input name="AdressePerso" type="text" value="<?php echo $mail_perso ?>"/>
						<br/>
						<br/>
						
						<h3>ENTREPRISE :</h3>
						<label for="NomEntreprise">ENTREPRISE (Raison Sociale) : </label>
							<input name="NomEntreprise" type="text" value="<?php echo $nom_entreprise ?>"/>
						<br/>
						<br/>
						
						<label for="AdresseEntreprise">Adresse : </label>
							<input name="AdresseEntreprise" type="text" value="<?php echo $adresse_entreprise ?>"/>
						<br/>
						<br/>
						
						<label for="CPEntreprise">Code Postal : </label>
							<input name="CPEntreprise" type="text" value="<?php echo $code_postal_entreprise ?>"/>
						<br/>
						<br/>
						
						<label for="VilleEntreprise">Ville : </label>
							<input name="VilleEntreprise" type="text" value="<?php echo $ville_entreprise ?>"/>
						<br/>
						<br/>
						
						<label for="NomResponsable">Nom du responsable du stage : </label>
							<input name="NomResponsable" type="text" disabled="disabled" value="<?php echo $nom_tuteur_entreprise ?>"/>
						<br/>
						<br/>
						
						<label for="FonctionResponsable">Fonction du responsable : </label>
							<input name="FonctionResponsable" type="text" disabled="disabled" value="<?php echo $fonction_tuteur_entreprise ?>"/>
						<br/>
						<br/>
						
						<div id="remuneration"> </div>
						<h3> REMUNERATION : </h3>
						
						<label>Votre stage a-t-il été rémunéré ? </label>
							<input name="Remuneration" type="radio" id="Remuneration" onclick=remuneration() value="Remunere" 
							<?php if($remuneration)echo "checked=\"checked\"" ?>/><label for="Remunere">Oui </label>
							<input name="Remuneration" type="radio" id="NonRemuneration" onclick=remuneration() value="NonRemunere" 
							<?php if(!$remuneration)echo "checked=\"checked\"" ?>/><label for="NonRemunere">Non </label>
						<br/>
						<br/>
						
						<label for="Salaire" id="LabelSalaire">Si oui, combien ? </label>
							<input name="Salaire" type="text" id="Salaire" value="<?php echo $salaire ?>"/>
						<br/>
						<br/>
						
						<div id="encadrement"> </div>
						<h3> ENCADREMENT : </h3>
						
						<label>Avez-vous été encadré directement par un informaticien ? </label>
							<input name="Informaticien" type="radio" id="Informaticien" onclick=informaticien() value="Informaticien" 
							<?php if($encadre_informaticien)echo "checked=\"checked\"" ?>/><label for="Informaticien">Oui </label>
							<input name="Informaticien" type="radio" id="NonInformaticien" onclick=informaticien() value="NonInformaticien" 
							<?php if(!$encadre_informaticien)echo "checked=\"checked\"" ?>/><label for="NonInformaticien">Non </label>
						<br/>
						<br/>
						
						<label id="LabelAppelInfo">Si non, en cas de besoin pouviez-vous faire appel à un informaticien ? </label>
							<input name="AppelInformaticien" type="radio" id="Appel" value="AppelInformaticien" 
							<?php if($appel_informaticien)echo "checked=\"checked\"" ?>/><label id="LabelAppel" for="AppelInformaticien">Oui </label>
							<input name="AppelInformaticien" type="radio" id="NonAppel" value="NonAppelInformaticien" 
							<?php if(!$appel_informaticien)echo "checked=\"checked\"" ?>/><label id="LabelNonAppel" for="NonAppelInformaticien">Non </label>
						<br/>
						<br/>
						
						<label>Dans le cadre de votre stage, l'étudiant a-t-il travaillé seul ? </label>
							<input name="Equipe" type="radio" value="Seul" id="Seul" onclick="tailleEquipe()" <?php if($travail_seul)echo "checked=\"checked\"" ?>/><label for="Seul">Oui </label>
							<input name="Equipe" type="radio" value="Groupe" id="Groupe" onclick="tailleEquipe()" <?php if(!$travail_seul)echo "checked=\"checked\"" ?>/><label for="Groupe">Non </label>
						<br/>
						<br/>
						
						<label for="TailleEquipe" id="LabelTailleEquipe">Si non, taille de l'équipe : </label>
							<input name="TailleEquipe" id="TailleEquipe" type="text" value="<?php echo $taille_equipe?>"/>
						<br/>
						<br/>
									
						<div id="environnement"> </div>
						<h3> ENVIRONNEMENT GENERAL : </h3>
						
						<label>Type de matériel : </label>
							<input name="Materiel" type="radio" value="PC" onclick="autreMateriel()"
							<?php if($type_materiel=="PC")echo "checked=\"checked\"" ?>/><label for="PC">PC </label>
							<input name="Materiel" type="radio" value="Autre" onclick="autreMateriel()" id="AutreMateriel"
                            <?php if($type_materiel!="PC")echo "checked=\"checked\"" ?>/><label for="Autre">Autre (préciser) </label>
							<input name="MaterielText" type="text" id="TextAutreMateriel" value="<?php if($type_materiel!="PC")echo $type_materiel ?>"/>
						<br/>
						<br/>
						
						<label>Système : </label>
							<input name="UNIX" type="checkbox" value="UNIX"
                            <?php if($unix)echo "checked=\"checked\"" ?>/><label for="UNIX">UNIX </label>
							<input name="LINUX" type="checkbox" value="LINUX"
                            <?php if($linux)echo "checked=\"checked\"" ?>/><label for="LINUX">LINUX </label>
							<input name="NT" type="checkbox" value="NT"
                            <?php if($nt)echo "checked=\"checked\"" ?>/><label for="UNIX">NT </label>
							<input name="WINDOWS" type="checkbox" value="WINDOWS"
                            <?php if($windows)echo "checked=\"checked\"" ?>/><label for="LINUX">WINDOWS </label> <br/>
							<input name="Autre" type="checkbox" value="Autre" onclick="autreSysteme()" id="AutreSysteme"
                            <?php if($autre_systeme)echo "checked=\"checked\"" ?>/><label for="Autre">Autre (préciser) </label>
							<input name="AutreSystemeText" id="AutreSystemeText" type="text" value="<?php echo $autre_systeme ?>"/>
						<br/>
						<br/>
						
						<label for="Langage">Langage : </label>
							<input name="Langage" type="text" value="<?php echo $langage ?>"/>
						<br/>
						<br/>
						
						<div id="objet"> </div>
						<h3> OBJET PRINCIPAL DU STAGE (2 cases maximum à cocher) : </h3>
						
							<input name="Systeme" type="checkbox" value="Systeme"
								<?php if($systeme)echo "checked=\"checked\"" ?>/><label for="Systeme">Système </label>
							<input name="Multimedia" type="checkbox" value="Multimedia"
								<?php if($multimedia)echo "checked=\"checked\"" ?>/><label for="Multimedia">Multimedia </label>
							<input name="Reseaux" type="checkbox" value="Reseaux"
								<?php if($reseau)echo "checked=\"checked\"" ?>/><label for="Reseaux">Réseaux </label>
							<input name="DeveloppementWEB" type="checkbox" value="DeveloppementWEB"
								<?php if($web)echo "checked=\"checked\"" ?>/><label for="DeveloppementWEB">Développement WEB </label> <br/>
							<input name="AutreDvpt" type="checkbox" value="AutreDvpt"
								<?php if($autre_dev)echo "checked=\"checked\"" ?>/><label for="AutreDvpt">Autre Développement </label>
							<input name="BD" type="checkbox" value="BD"
								<?php if($bd)echo "checked=\"checked\"" ?>/><label for="BD">Base de données </label>
							<input name="AutreObjet" id="AutreObjet" onclick="autreObjet()" type="checkbox" value="Autre"
								<?php if($autre_objet)echo "checked=\"checked\"" ?>/><label for="Autre">Autre (préciser) </label>
							<input name="AutreObjetText" id="AutreObjetText" type="text" value="<?php echo $autre_objet ?>"/>
						
						<div id="avis_stage"> </div>
						<h3> AVIS DE L'ETUDIANT SUR LE STAGE : </h3>
						
						<label>Etes-vous totalement satisfait des conditions dans lesquelles ce sont déroulées votre stage : </label>
                        <br/>
							<input name="Satisfait" type="radio" value="Satisfait" id="Satisfait" onclick="avisEtudiant()"
                            <?php if($satisfait_condition)echo "checked=\"checked\"" ?>/><label for="Satisfait">Oui </label>
							<input name="Satisfait" type="radio" value="NonSatisfait" id="NonSatisfait" onclick="avisEtudiant()"
                            <?php if(!$satisfait_condition)echo "checked=\"checked\"" ?>/><label for="NonSatisfait">Non </label>
						<br/>
						<br/>
						
						<label id="LabelSatisfait">Si non expliquez en quelques mots pourquoi : </label> <br/>
							<textarea name="ExplicationSatisfaction" rows="10" cols="50" id="TextSatisfait"><?php echo $explication_satisfaction ?></textarea>
						<br/>
						<br/>
						
						<div id="objectif"> </div>
						<h3> LE STAGE OBLIGATOIRE DE FIN D'ÉTUDES DOIT RÉPONDRE À PLUSIEURS OBJECTIFS : </h3>
						
						<p>D'abord, il vous introduit dans le monde du travail, dans une ambiance que le futur professionnel de
								l'Informatique doit connaître avec ses contraintes de temps, de budget, de fonctionnement d'équipe, etc... <br/>
								Il vous permet d'être confronté, non plus à des exercices scolaires dont l'intérêt est souvent purement
								pédagogique, mais à des applications concrètes dans les domaines les plus variés. <br/>
								Il vous permet, soit d'approfondir les connaissances acquises à l'IUT en étant confronté à des problèmes
								en vraie grandeur, soit de découvrir des environnements de travail, des méthodes d'analyse, des langages
								nouveaux. <br/> 
						</p>
						<br/>
						
						<label>Ces objectifs ont-ils été atteints : </label>
							<input name="ObjectifAtteint" type="radio" value="ObjectifAtteint" id="ObjectifAtteint" onclick="objectif()"
                            <?php if($objectif_atteint)echo "checked=\"checked\"" ?>/><label for="ObjectifAtteint">Oui </label>
							<input name="ObjectifAtteint" type="radio" value="ObjectifNonAtteint" id="ObjectifNonAtteint" onclick="objectif()"
                            <?php if(!$objectif_atteint)echo "checked=\"checked\"" ?>/><label for="ObjectifNonAtteint">Non </label>
						<br/>
						<br/>
						
						<label id="LabelObjectif">Si non expliquez en quelques mots pourquoi : </label> <br/>
							<textarea rows="10" cols="50" name="ExplicationObjectif" id="TextObjectif"><?php echo $explication_objectif ?></textarea>
						<br/>
						<br/>
						
						<div id="avis_enseignement"> </div>
						<h3> AVIS DE L'ETUDIANT SUR LES ENSEIGNEMENTS DISPENSES A L'IUT : </h3>
						
						<label>Après cette expérience dans l'entreprise, estimez-vous que certaines matières enseignées n'ont pas été assez développées ? </label>
							<input name="AvisIUT" type="radio" value="AvisIUTPositif" id="Manque" onclick="formation()"
                            <?php if($matiere_dev)echo "checked=\"checked\"" ?>/><label for="AvisIUTPositif">Oui </label>
							<input name="AvisIUT" type="radio" value="AvisIUTNegatif" id="PasManque" onclick="formation()"
                            <?php if(!$matiere_dev)echo "checked=\"checked\"" ?>/><label for="AvisIUTNegatif">Non </label>
						<br/>
						<br/>
						
						<label id="LabelManque">Si oui, précisez lesquelles : </label> <br/>
							<textarea rows="10" cols="50" name="ExplicationAvis" id="TextManque"><?php echo $explication_matiere ?></textarea>
						<br/>
						<br/>
						
						<div id="apport"> </div>
						<h3> APPORT DU STAGE DANS VOTRE PROJET PERSONNEL ET PROFESSIONNEL : </h3>
						
						<label> Précisez en quelques lignes comment le stage a enrichi ou modifié votre projet personnel et professionnel :</label> <br/>
							<textarea rows="20" cols="50" name="ApportStage"><?php echo $apport_stage ?></textarea>
						<br/>
						<br/>
						
						<p style="text-align: center;">
							<input name="Enregistrer" type="submit" value="Enregistrer"/>
						</p>
						
					</p>
				</form>
			</div>
	</div>
    
		<div class="ConteneurBas">
			<p>Copyright © 2015 - IUT Orsay (Léo Charlier, Xavier Villelegier)</p>
			<!--
            A enlever du commentaire quand la page sera valide CSS et XHTML
            <p>
				<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
				<a href="http://jigsaw.w3.org/css-validator/check/referer"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valide !" /></a>
			</p>
            -->
		</div>
	</div>
    
	<!-- Script pour activer ou non les text input-->
    <script type="text/javascript">
		function remuneration(){
			if(document.getElementById('Remuneration').checked==true){
				document.getElementById('Salaire').hidden=false;
				document.getElementById('LabelSalaire').hidden=false;
				
			}
			else{
				document.getElementById('LabelSalaire').hidden=true;
				document.getElementById('Salaire').hidden=true;
				
			}
			
		}
		
		function informaticien(){
			if(document.getElementById('Informaticien').checked==true){
				document.getElementById('LabelAppelInfo').hidden=true;
				document.getElementById('LabelAppel').hidden=true;
				document.getElementById('Appel').hidden=true;
				document.getElementById('LabelNonAppel').hidden=true;
				document.getElementById('NonAppel').hidden=true;
			}
			else{
				document.getElementById('LabelAppelInfo').hidden=false;
				document.getElementById('LabelAppel').hidden=false;
				document.getElementById('Appel').hidden=false;
				document.getElementById('LabelNonAppel').hidden=false;
				document.getElementById('NonAppel').hidden=false;
			}
			
		}
		
		function tailleEquipe(){
			if(document.getElementById('Seul').checked==true){
				document.getElementById('TailleEquipe').hidden=true;
				document.getElementById('LabelTailleEquipe').hidden=true;
			}
			else{
				document.getElementById('TailleEquipe').hidden=false;
				document.getElementById('LabelTailleEquipe').hidden=false;
			}
			
		}
		
		function autreMateriel(){
			if(document.getElementById('AutreMateriel').checked==true){
				document.getElementById('TextAutreMateriel').hidden=false;
			}
			else{
				document.getElementById('TextAutreMateriel').hidden=true;
			}
			
		}
		
		function autreSysteme(){
			if(document.getElementById('AutreSysteme').checked==true){
				document.getElementById('AutreSystemeText').hidden=false;
			}
			else{
				document.getElementById('AutreSystemeText').hidden=true;
			}
		}
		
		function autreObjet(){
			if(document.getElementById('AutreObjet').checked==true){
				document.getElementById('AutreObjetText').hidden=false;
			}
			else{
				document.getElementById('AutreObjetText').hidden=true;
			}
			
		}
		
		function avisEtudiant(){
			if(document.getElementById('Satisfait').checked==true){
				document.getElementById('LabelSatisfait').hidden=true;
				document.getElementById('TextSatisfait').hidden=true;
			}
			else{
				document.getElementById('LabelSatisfait').hidden=false;
				document.getElementById('TextSatisfait').hidden=false;
			}
			
		}
		
		function objectif(){
			if(document.getElementById('ObjectifAtteint').checked==true){
				document.getElementById('LabelObjectif').hidden=true;
				document.getElementById('TextObjectif').hidden=true;
			}
			else{
				document.getElementById('LabelObjectif').hidden=false;
				document.getElementById('TextObjectif').hidden=false;
			}
			
		}
		
		function formation(){
			if(document.getElementById('Manque').checked==false){
				document.getElementById('LabelManque').hidden=true;
				document.getElementById('TextManque').hidden=true;
			}
			else{
				document.getElementById('LabelManque').hidden=false;
				document.getElementById('TextManque').hidden=false;
			}
			
		}
		
		
		
		$(document).ready(function(e) {
                verifyAll();
           });
		   
		function verifyAll(){
			remuneration();
			informaticien();
			tailleEquipe();
			autreMateriel();
			autreSysteme();
			autreObjet();
			avisEtudiant();
			objectif();
			formation();
		}
	</script>
	
    <!-- Affiche la popup de données enregistrées si nécessaire--!>
    <?php
		if(isset($_GET['saved'])){
		echo"
    <script type=\"text/javascript\" src=\"../../js/noty/packaged/jquery.noty.packaged.js\"></script>
    <script type=\"text/javascript\">


        function generate(type, text) {

            var n = noty({
                text        : text,
                type        : type,
                dismissQueue: true,
                layout      : 'bottomRight',
                theme       : 'relax',
                maxVisible  : 10,
                animation   : {
                    open  : 'animated bounceInRight',
                    close : 'animated bounceOutRight',
                    easing: 'swing',
                    speed : 500
                }
            });
            console.log('html: ' + n.options.id);
        }

        function generateAll() {
            generate('success', '<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> Vos changements ont bien été enregistrés </div> </div>');
        }

        $(document).ready(function () {

            setTimeout(function() {
                generateAll();
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    </script>
    ";
    }
    ?>
    <!--Scripte pour que le menu verticale suive le scroll-->
	<script type="text/javascript">
		// listen for scroll
		var positionElementInPage = $('.menu').offset().top;
		$(window).scroll(
			function() {
				if ($(window).scrollTop() >= positionElementInPage) {
					// fixed
					$('.menu').addClass("floatable");
				} else {
					// relative
					$('.menu').removeClass("floatable");
				}
			}
		);
	</script>
  </body>
</html>