<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		echo"pas de membre";
		header('Location: ../../index.html'); 
	}
	else{
		$membre=$_SESSION['membre'];
		$bd = new Bd("site_stage");
		$co = $bd->connexion();
	}
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
	<style type="text/css">
		.tab  {border-collapse:collapse;border-spacing:0;}
		.tab td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tab th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; background-color:#26ade4;}
	</style>
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
						<input name="Deconnexion" type="submit" value="Déconnexion"/><br/>
					</p>
                   
				</form>
			</div>
		</div>
		<div class="ConteneurBasPetit">
			<a href="change_mdp.php" style="font-size:11">Changer mon mot de passe</a>
        </div>
    </div>
    <div class="contenu_page">
		<div class="ConteneurHaut"></div>
		<div class="ConteneurPrincipale">
			<div class="Bleue">
				<div id="Ribbon">
					<ul>
						<li><a href="accueil.php">Accueil</a></li>
						<li><a href="page_mes_etudiants.php" >Gérer mes étudiants</a></li>
						<li><a href="page_etudiant_disponible.php">Etudiants disponibles</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">Changer votre mot de passe : </div>
				
				<p>Vous pouvez sur cette page <b>modifier votre mot de passe.</b></p><br/><br/>
                <form method="post" action="../../controleurs/enseignant/change_mdp.php">
			<p>
			<label for="AncienMdp">Ancien mot de passe : </label>
				<input name="AncienMdp" type="password"/>
			<br/>
            <br/>
				
			<label for="NouveauMdp">Nouveau mot de passe : </label>
				<input name="NouveauMdp" type="password"/>
			<br/>
			<br/>
			
			<label for="NouveauMdpConfirm">Confirmation du nouveau mot de passe : </label>
				<input name="NouveauMdpConfirm" type="password"/>
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
    
    <script type="text/javascript" src="../../js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript">
	
	function generatePopup(type, text) {

            var popup = noty({
                text        : text,
                type        : type,
                dismissQueue: true,
                layout      : 'bottomRight',
                theme       : 'relax',
                maxVisible  : 10,
                animation   : {
                    open  : 'animated bounceInUp',
                    close : 'animated bounceOutDown',
                    easing: 'swing',
                    speed : 500
                }
            });
            console.log('html: ' + n.options.id);
			
        }
		 
		 function generateSuccess() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-lock text-success\"></i> <div class=\"activity\">Votre mot de passe a bien été changé</div> </div>');
		 }
		 
		 function generateFillAll() {
			 
            generatePopup('error', '<div class=\"activity-item\"> <i class=\"fa fa-times text-error\"></i> <div class=\"activity\"> Remplissez tous les champs </div> </div>');
			
		 }
		 
		 function generateBadOldMdp() {
			 
            generatePopup('error', '<div class=\"activity-item\"> <i class=\"fa fa-times text-error\"></i> <div class=\"activity\"> Ancien mot de passe non valide </div> </div>');
			
		 }
		 
		 function generateNotSame() {
			 
            generatePopup('error', '<div class=\"activity-item\"> <i class=\"fa fa-times text-error\"></i> <div class=\"activity\"> Le nouveau mot de passe et sa confirmation sont différents  </div> </div>');
			
		 }
		 
	</script>
    
    <!-- Affiche la popup succès-->
    <?php
		if(isset($_GET['success'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateSuccess();
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    	</script>
    ";
    }
    ?>
    
    <!-- Affiche la popup fillAll-->
    <?php
		if(isset($_GET['fillall'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateFillAll();
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    	</script>
    ";
    }
    ?>
    
    <!-- Affiche la popup succès-->
    <?php
		if(isset($_GET['badoldmdp'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateBadOldMdp();
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    	</script>
    ";
    }
    ?>
    
    <!-- Affiche la popup NotSame-->
    <?php
		if(isset($_GET['notsame'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateNotSame();
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