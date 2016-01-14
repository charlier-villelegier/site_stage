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
                    	Statut : Professeur
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
				<div class="PlanMenu">Menu</div>
				<ul>
					<li><div class="TitrePlan"><a href="#encadrement">Encadrement de l'étudiant</a></div></li>
					<li><div class="TitrePlan"><a href="#objet">Objet du stage</a></div></li>
					<li><div class="TitrePlan"><a href="#avisEtu">Avis sur l'étudiant</a></div></li>
                    <li><div class="TitrePlan"><a href="#avisIUT">Avis sur l'IUT</a></div></li>
                    <li><div class="TitrePlan"><a href="#avisGeneral">Avis général</a></div></li>
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
						<li><a href="#" class="PageActive">Gérer mes étudiants</a></li>
						<li><a href="#">Etudiants disponibles</a></li>
						<li><a href="#">Mes disponibilités</a></li>
                        <li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">COMPTE-RENDU DE VISITE DE STAGE</div>
	<form method="get" action="faille.php">
		<p>
			<label for="NomEtudiant">Nom de l'étudiant : </label>
				<input name="NomEtudiant" type="text"/>
			<br/>
            <br/>
				
			<label for="Tuteur">Nom du tuteur / de la tutrice : </label>
				<input name="Tuteur" type="text"/>
			<br/>
			<br/>
			
			<label for="TP">TP : </label>
				<input name="TP" type="text"/>
			<br/>
			<br/>
			
			
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
			
			<label for="VilleEntreprise">Ville : </label>
				<input name="VilleEntreprise" type="text"/>
			<br/>
			<br/>
			
			<label>Vous êtes vous rendu sur le lieu du stage pour rencontrer le stagiaire et son responsable de stage ? </label>
				<input name="StagiaireRencontre" type="radio" value="StagiaireRencontre"/><label for="StagiaireRencontre">Oui </label>
				<input name="StagiaireRencontre" type="radio" value="StagiaireNonRencontre"/><label for="StagiaireNonRencontre">Non </label>
			<br/>
			<br/>
			
			<label for="DateRencontre">Si oui, le : </label>
			<input name="DateRencontre" type="text"/>
			<br/>
			<br/>
			
			<label for="NomResponsable">Nom du responsable rencontré : </label>
				<input name="NomResponsable" type="text"/>
            <br/>
            <br/>
			
			<label for="FonctionResponsable">Fonction du responsable : </label>
				<input name="FonctionResponsable" type="text"/>
			<br/>
			<br/>
			
			<label for="NomRH">Nom du responsable des Ressources Humaines ou de la personne à contacter pour la taxe d'apprentissage : </label>
				<input name="NomRH" type="text"/>
			<br/>
			<br/>
			
			<label for="TelRH">Téléphone : </label>
				<input name="TelRH" type="text"/>
				
			<label for="MailRH">E-mail : </label>
				<input name="MailRH" type="text"/>
                
			<div id="encadrement"></div>
			<h3> ENCADREMENT DE L'ETUDIANT : </h3>
			
			<label>L'étudiant a-t-il été encadré directement par un informaticien ? </label>
				<input name="Informaticien" type="radio" value="Informaticien"/><label for="Informaticien">Oui </label>
				<input name="Informaticien" type="radio" value="NonInformaticien"/><label for="NonInformaticien">Non </label>
			<br/>
			<br/>
			
			<label>Si non, en cas de besoin pouvait-il faire appel à un informaticien ? </label>
				<input name="AppelInformaticien" type="radio" value="AppelInformaticien"/><label for="AppelInformaticien">Oui </label>
				<input name="AppelInformaticien" type="radio" value="NonAppelInformaticien"/><label for="NonAppelInformaticien">Non </label>
			<br/>
			<br/>
			
			<label>Dans le cadre de votre stage, l'étudiant a-t-il travaillé seul ? </label>
				<input name="Equipe" type="radio" value="Seul"/><label for="Seul">Oui </label>
				<input name="Equipe" type="radio" value="Groupe"/><label for="Groupe">Non </label>
			<br/>
			<br/>
			
			<label for="TailleEquipe">Si non, taille de l'équipe : </label>
				<input name="TailleEquipe" type="text"/>
			<br/>
			<br/>
			<div id="objet"></div>
			<h3> OBJET PRINCIPAL DU STAGE (2 cases maximum à cocher) : </h3>
			
				<input name="ObjetStage" type="checkbox" value="Systeme"/><label for="Systeme">Système </label>
				<input name="ObjetStage" type="checkbox" value="Multimedia"/><label for="Multimedia">Multimedia </label>
				<input name="ObjetStage" type="checkbox" value="Reseaux"/><label for="Reseaux">Réseaux </label>
				<input name="ObjetStage" type="checkbox" value="DeveloppementWEB"/><label for="DeveloppementWEB">Développement WEB </label> <br/>
				<input name="ObjetStage" type="checkbox" value="AutreDvpt"/><label for="AutreDvpt">Autre Développement </label>
				<input name="ObjetStage" type="checkbox" value="BD"/><label for="BD">Base de données </label>
				<input name="ObjetStage" type="checkbox" value="Autre"/><label for="Autre">Autre (préciser) </label>
				<input name="ObjetStage" type="text"/>
			
            <div id="avisEtu"></div>
			<h3> AVIS DE L’ENTREPRISE SUR LE TRAVAIL ET LE COMPORTEMENT DE L’ETUDIANT </h3>
			
			<label>Globalement, concernant le travail de l'étudiant, êtes-vous : </label> <br/>
				<input name="Satisfaction" type="radio" value="TresSatisfait"/><label for="TresSatisfait">Très satisfait </label> <br/>
				<input name="Satisfaction" type="radio" value="Satisfait"/><label for="Satisfait">Satisfait </label> <br/>
				<input name="Satisfaction" type="radio" value="PeuSatisfait"/><label for="PeuSatisfait">Peu satisfait </label> <br/>
				<input name="Satisfaction" type="radio" value="PasSatisfait"/><label for="PasSatisfait">Pas satisfait </label> <br/>
			<br/>
			
			<label>Commentaires : </label> <br/>
				<textarea rows="10" cols="50"></textarea>
			<br/>
			<br/>
			
            <div id="avisIUT"></div>
			<h3> AVIS DE L’ENTREPRISE SUR LA FORMATION RECUE A L'IUT </h3>
			
			<label>Dans la formation telle que vous l'avez perçue lors de la présence du stagiaire dans votre entreprise avez-vous constaté des manques handicapants pour un futur informaticien ?</label>
            <br/>
				<input name="Manque" type="radio" value="Manque"/><label for="Manque">Oui </label>
				<input name="Manque" type="radio" value="PasDeManque"/><label for="PasDeManque">Non </label>
			<br/>
			<br/>
			
			<label>Si oui, précisez lesquelles : </label> <br/>
				<textarea rows="10" cols="50"></textarea>
			<br/>
			<br/>
			
            <div id="avisGeneral"></div>
			<h3> AVIS DE GENERAL DE L'ENSEIGNANT SUR LE STAGE : </h3>
			
			<textarea rows="20" cols="50"></textarea>
			<br/>
			<br/>
			
			<label>En conclusion, cette entreprise peut-elle les prochaines années accueillir dans des conditions correctes ses étudiants ?</label> <br/>
				<input name="Accueil" type="radio" value="AccueilPossible"/><label for="AccueilPossible">Oui </label> <br/>
				<input name="Accueil" type="radio" value="AccueilImpossible"/><label for="AccueilImpossible">Non </label> <br/>
				<input name="Accueil" type="radio" value="AccueilSousCondition"/><label for="AccueilSousCondition">Oui, mais en prenant quelques précautions. Quelles précautions ?</label> <br/>
				<textarea rows="20" cols="50"></textarea>
			<br/>
			<br/>
		</p>

        <p style="text-align: center;">
			<input name="Enregistrer" type="submit" value="Enregistrer"/>
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