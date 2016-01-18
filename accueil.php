<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head> 
    <title>Gestion des stages - Accueil</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="js/buttons.css"/>
    <link rel="stylesheet" type="text/css" href="js/animate.css"/>
    <link rel="stylesheet" href="js/font-awesome/css/font-awesome.min.css"/>
	<script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>
  
  <body>
    <div class="ConteneurLogo"></div>
    <div class="ConteneurConnexion">
    	<div class="ConteneurHautPetit"></div>
		<div class="ConteneurPrincipalePetit">
			<div class="ConteneurPetitPlan">
				<div class="PlanMenu">Veuillez vous connecter</div>
                <form method="post" action="controleurs/connexion.php">
                    	<label for="login">Login : </label>
							<input name="login" type="text" size=10 style = "float : right"/>
						<br/>
						<br/>
						<input name="mdp" type="text" size=10 style = "float : right">
						<label for="mdp" style = "margin-left : 5px">Mot de passe : </label>
							
						<br/>
						<br/>
				
						<input name="connect" type="submit" value="Se connecter"/>
				</form>
			</div>
		</div>
		<div class="ConteneurBasPetit">
			
        </div>
    </div>
	<div class="contenu_page">
		<div class="ConteneurHaut"></div>
		<div class="ConteneurPrincipale">
			<div class="Bleue">
				<div class="ConteneurTexte"> 
					<div class="TitrePartie" id="titre1">Bienvenue sur notre site</div>
						<p>Bienvenue sur le site de gestion des stages de fin de de formation des étudiants des étudiants de l'IUT d'Orsay. <br/>
						Ce site s'adresse donc aux personnes concernées par ces stages. Selon votre statut (étudiant, enseignant, responsable en entreprise ou secrétaire),
						vous aurez accès à différentes fonctionnalités comme remplir les diférentes fiches nécessaires, contacter différentes personnes, nous informer de vos disponibilités pour la soutenance de fin de stage, etc. <br/><br/>
						Ce site a été réalisé dans le cadre du projet du semestre 3 de l'IUT d'Orsay par des étudiants du département informatique.
						Il s'agit donc d'un "premier jet". En espérant que vous passerez une agréable navigation.</p>
						
						<p align="center"><img src="images/LogoUPSUD.png" alt="Logo de l'université Paris Sud" width="400" height="250"></p>
				</div>
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
    
    <!--Fonctions javascript pour les popup-->
    <script type="text/javascript" src="js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript">
	
	function generatePopup(type, text) {

            var popup = noty({
                text        : text,
                type        : type,
                dismissQueue: true,
                layout      : 'center',
                theme       : 'relax',
                maxVisible  : 10,
                animation   : {
                    open  : 'animated flipInX',
                    close : 'animated flipOutX',
                    easing: 'swing',
                    speed : 500
                }
            });
            console.log('html: ' + n.options.id);
			
        }
		
		function generateFailed() {
			 
            generatePopup('error', '<div class=\"activity-item\"> <i class=\"fa fa-times text-error\"></i> <div class=\"activity\"> Login ou mot de passe incorrect </div> </div>');
			
		 }
		 
		 function generateGoodbye() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-power-off text-success\"></i> <div class=\"activity\"> Merci de votre visite, à bientôt ! </div> </div>');
		 }
		 
	</script>
    
    <!-- Affiche la popup de la connexion échouée-->
    <?php
		if(isset($_GET['failed'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateFailed();
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    	</script>
    ";
    }
    ?>
    
    <!-- Affiche la popup Au revoir-->
    <?php
		if(isset($_GET['deconnect'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateGoodbye();
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