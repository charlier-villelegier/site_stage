<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		echo"pas de membre";
		header('Location: ../../index.html'); 
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head> 
    <title>Gestion des stages - Accueil</title>
    <link href="../../style.css" rel="stylesheet" type="text/css" />
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
						<li><a href="page_fiche_localisation.html" class="PageActive">Mes fiches</a></li>
						<li><a href="#">Disponibilités</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">AVIS ETUDIANT</div>
					<form method="post" action="faille.php">
					<p>
						<label for="NomEtudiant">Nom : </label>
							<input name="NomEtudiant" type="text"/>
						
							
						<label for="Tuteur">Nom du tuteur / de la tutrice : </label>
							<input name="Tuteur" type="text"/>
						<br/>
						<br/>
						
						<label for="TP">TP : </label>
							<input name="TP" type="text"/>
						
						<label for="AdressePerso">Adresse électronique autre que IUT : </label>
							<input name="AdressePerso" type="text"/>
						<br/>
						<br/>
						
						<h3>ENTREPRISE :</h3>
						<label for="NomEntreprise">ENTREPRISE (Raison Sociale) : </label>
							<input name="NomEntreprise" type="text"/>
						<br/>
						<br/>
						
						<label for="AdresseEntreprise">Adresse : </label>
							<input name="AdresseEntreprise" type="text"/>
						<br/>
						<br/>
						
						<label for="CPEntreprise">Code Postal : </label>
							<input name="CPEntreprise" type="text"/>
						<br/>
						<br/>
						
						<label for="VilleEntreprise">Ville : </label>
							<input name="VilleEntreprise" type="text"/>
						<br/>
						<br/>
						
						<label for="NomResponsable">Nom du responsable du stage : </label>
							<input name="NomResponsable" type="text"/>
						<br/>
						<br/>
						
						<label for="FonctionResponsable">Fonction du responsable : </label>
							<input name="FonctionResponsable" type="text"/>
						<br/>
						<br/>
						
						<div id="remuneration"> </div>
						<h3> REMUNERATION : </h3>
						
						<label>Votre stage a-t-il été rémunéré ? </label>
							<input name="Remuneration" type="radio" value="Remunere"/><label for="Remunere">Oui </label>
							<input name="Remuneration" type="radio" value="NonRemunere"/><label for="NonRemunere">Non </label>
						<br/>
						<br/>
						
						<label for="Salaire">Si oui, combien ? </label>
							<input name="Salaire" type="text"/>
						<br/>
						<br/>
						
						<div id="encadrement"> </div>
						<h3> ENCADREMENT : </h3>
						
						<label>Avez-vous été encadré directement par un informaticien ? </label>
							<input name="Informaticien" type="radio" value="Informaticien"/><label for="Informaticien">Oui </label>
							<input name="Informaticien" type="radio" value="NonInformaticien"/><label for="NonInformaticien">Non </label>
						<br/>
						<br/>
						
						<label>Si non, en cas de besoin pouviez-vous faire appel à un informaticien ? </label>
							<input name="AppelInformaticien" type="radio" value="AppelInformaticien"/><label for="AppelInformaticien">Oui </label>
							<input name="AppelInformaticien" type="radio" value="NonAppelInformaticien"/><label for="NonAppelInformaticien">Non </label>
						<br/>
						<br/>
						
						<label>Dans le cadre de votre stage, avez-vous travaillé seul ? </label>
							<input name="Equipe" type="radio" value="Seul"/><label for="Seul">Oui </label>
							<input name="Equipe" type="radio" value="Groupe"/><label for="Groupe">Non </label>
						<br/>
						<br/>
						
						<label for="TailleEquipe">Si non, taille de l'équipe : </label>
							<input name="TailleEquipe" type="text"/>
						<br/>
						<br/>
						
						<div id="environnement"> </div>
						<h3> ENVIRONNEMENT GENERAL : </h3>
						
						<label>Type de matériel : </label>
							<input name="Materiel" type="radio" value="PC"/><label for="PC">PC </label>
							<input name="Materiel" type="radio" value="Autre"/><label for="Autre">Autre (préciser) </label>
							<input name="Materiel" type="text"/>
						<br/>
						<br/>
						
						<label>Système : </label>
							<input name="Systeme" type="checkbox" value="UNIX"/><label for="UNIX">UNIX </label>
							<input name="Systeme" type="checkbox" value="LINUX"/><label for="LINUX">LINUX </label>
							<input name="Systeme" type="checkbox" value="NT"/><label for="UNIX">NT </label>
							<input name="Systeme" type="checkbox" value="WINDOWS"/><label for="LINUX">WINDOWS </label> <br/>
							<input name="Systeme" type="checkbox" value="Autre"/><label for="Autre">Autre (préciser) </label>
							<input name="Systeme" type="text"/>
						<br/>
						<br/>
						
						<label for="Language">Language : </label>
							<input name="Language" type="text"/>
						<br/>
						<br/>
						
						<div id="objet"> </div>
						<h3> OBJET PRINCIPAL DU STAGE (2 cases maximum à cocher) : </h3>
						
							<input name="ObjetStage" type="checkbox" value="Systeme"/><label for="Systeme">Système </label>
							<input name="ObjetStage" type="checkbox" value="Multimedia"/><label for="Multimedia">Multimedia </label>
							<input name="ObjetStage" type="checkbox" value="Reseaux"/><label for="Reseaux">Réseaux </label>
							<input name="ObjetStage" type="checkbox" value="DeveloppementWEB"/><label for="DeveloppementWEB">Développement WEB </label> <br/>
							<input name="ObjetStage" type="checkbox" value="AutreDvpt"/><label for="AutreDvpt">Autre Développement </label>
							<input name="ObjetStage" type="checkbox" value="BD"/><label for="BD">Base de données </label>
							<input name="ObjetStage" type="checkbox" value="Autre"/><label for="Autre">Autre (préciser) </label>
							<input name="ObjetStage" type="text"/>
						
						<div id="avis_stage"> </div>
						<h3> AVIS DE L'ETUDIANT SUR LE STAGE : </h3>
						
						<label>Etes-vous totalement satisfait des conditions dans lesquelles ce sont déroulées votre stage : </label>
							<input name="Satisfait" type="radio" value="Satisfait"/><label for="Satisfait">Oui </label>
							<input name="Satisfait" type="radio" value="NonSatisfait"/><label for="NonSatisfait">Non </label>
						<br/>
						<br/>
						
						<label>Si non expliquez en quelques mots pourquoi : </label> <br/>
							<textarea rows="10" cols="50"></textarea>
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
							<input name="ObjectifAtteint" type="radio" value="ObjectifAtteint"/><label for="ObjectifAtteint">Oui </label>
							<input name="ObjectifAtteint" type="radio" value="ObjectifNonAtteint"/><label for="ObjectifNonAtteint">Non </label>
						<br/>
						<br/>
						
						<label>Si non expliquez en quelques mots pourquoi : </label> <br/>
							<textarea rows="10" cols="50"></textarea>
						<br/>
						<br/>
						
						<div id="avis_enseignement"> </div>
						<h3> AVIS DE L'ETUDIANT SUR LES ENSEIGNEMENTS DISPENSES A L'IUT : </h3>
						
						<label>Après cette expérience dans l'entreprise, estimez-vous que certaines matières enseignées n'ont pas été assez développées ? </label>
							<input name="AvisIUT" type="radio" value="AvisIUTPositif"/><label for="AvisIUTPositif">Oui </label>
							<input name="AvisIUT" type="radio" value="AvisIUTNegatif"/><label for="AvisIUTNegatif">Non </label>
						<br/>
						<br/>
						
						<label>Si oui, précisez lesquelles : </label> <br/>
							<textarea rows="10" cols="50"></textarea>
						<br/>
						<br/>
						
						<div id="apport"> </div>
						<h3> APPORT DU STAGE DANS VOTRE PROJET PERSONNEL ET PROFESSIONNEL : </h3>
						
						<label> Précisez en quelques lignes comment le stage a enrichi ou modifié votre projet personnel et professionnel :</label> <br/>
							<textarea rows="20" cols="50"></textarea>
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