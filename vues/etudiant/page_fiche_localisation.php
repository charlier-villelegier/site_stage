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
					<li><div class="TitrePlan"><a href="#">Fiche de localisation</a></div></li>
					<li><div class="TitrePlan"><a href="page_fiche_avis.php">Fiche d'avis sur le stage</a></div></li>
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
						<li><a href="#">Accueil</a></li>
						<li><a href="page_fiche_localisation.html" class="PageActive">Mes fiches</a></li>
						<li><a href="#">Disponibilités</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">LOCALISATION DE STAGE</div>
				<form method="get" action="faille.php">
				<p>
					<label for="NomEtudiant">Nom : </label>
						<input name="NomEtudiant" type="text"/>
					
					<label for="PrenomEtudiant">Prénom : </label>
						<input name="PrenomEtudiant" type="text"/>
					<br/>
					<br/>
						
					<label for="Tuteur">Tuteur/Tutrice : </label>
						<input name="Tuteur" type="text"/>
					<br/>
					<br/>
					
					<label for="AdresseEtudiant">Adresse personnelle (hors scolarité) : </label>
						<input name="AdresseEtudiant" type="text"/>
					<br/>
					<br/>
					
					<label for="MailEtudiant">Courrier IUT : </label>
						<input name="Tuteur" type="text"/>
						
					<label for="TelFixe">Téléhphone : </label>
						<input name="TelFixe" type="text"/>
					<br/>
					<br/>
					
					<div id="entreprise"> </div>
					<h3> Entreprise </h3>
					<label for="NomEntreprise">Nom de l'établissement où s'effectue le stage : </label>
						<input name="NomEntreprise" type="text"/>
					<br/>
					<br/>
					
					<label for="AdresseEntreprise">Adresse (Lieu du stage) : </label>
						<input name="AdresseEntreprise" type="text"/>
					<br/>
					<br/>
					
					<label for="NomResponsable">Nom du responsable du stage : </label>
						<input name="NomResponsable" type="text"/>
					<br/>
					<br/>
					
					<label for="TelResponsable">Numéro de téléphone où l'on peut le joindre : </label>
						<input name="TelResponsable" type="text"/>
					<br/>
					<br/>
					
					<label for="MailResponsable">E-mail : </label>
						<input name="MailResponsable" type="text"/>
					<br/>
					<br/>
					
					<label for="JourRencontre">Jour de la semaine où il est possible de le rencontrer : </label>
						<input name="JourRencontre" type="text"/>
					<br/>
					<br/>
					
					<div id="etudiant"> </div>
					<h3> Etudiant </h3>
					
					<label for="TelEntreprise">Numéro de téléphone où l'on peut vous joindre en entreprise : </label>
						<input name="TelEntreprise" type="text"/>
					<br/>
					<br/>
					
					<label for="TelEtudiant">Numéro de téléphone portable : </label>
						<input name="TelEtudiant" type="text"/>
					<br/>
					<br/>
					
					<label for="MailPerso">E-Mail personnel : </label>
						<input name="MailPerso" type="text"/>
					<br/>
					<br/>
					
					<label>Sujet du stage : </label> <br/>
						<textarea rows="20" cols="50"></textarea>
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