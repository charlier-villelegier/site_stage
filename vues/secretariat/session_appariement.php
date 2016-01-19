<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		echo"pas de membre";
		header('Location: ../../index.html'); 
	}
	//J'ouvre la connexion pour plus tard
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
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
                    	Statut : Secrétariat
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
    
    <div class="contenu_page">
		<div class="ConteneurHaut"></div>
		<div class="ConteneurPrincipale">
			<div class="Bleue">
				<div id="Ribbon">
					<ul>
						<li><a href="accueil.php" >Accueil</a></li>
						<li><a href="page_stat_fiche.php">Statistiques fiches</a></li>
						<li><a href="session_appariement.php" class="PageActive">Session d'appariement</a></li>
						<li><a href="statistiques_tuteurs.php">Statistiques Tuteurs</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">Session d'appariement : </div>
                <p>Vous pouvez ici ouvrir ou fermer les sessions d'appariement, afin que les enseignants puissent choisir d'être le tuteur des élèves.</p><br/>
                <?php
					//Je récupère et j'affiche la liste des disponibilités
					$resultat = mysqli_query($co,  "SELECT session_appariement
													FROM secretariat
													WHERE login='$membre->login'");
													
					$row=mysqli_fetch_row($resultat);
					
					if($row[0]){
						echo "<p>Les appariements sont actuellement <b>ouverts</b></p>";
						echo "<p>Vous pouvez les fermer en appuyant ici : </p>";
						echo "<input type=\"button\" value=\"Fermer les appariements\" onclick=\"confirmClose()\"/>";
					}
					else{
						echo "<p>Les appariements sont actuellement <b>fermés</b></p>";
						echo "<p>Vous pouvez les ouvrir en appuyant ici : </p>";
						echo "<input type=\"button\" value=\"Ouvrir les appariements\" onclick=\"confirmOpen()\"/>";
					}
					
				?>
                
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
    <script type="text/javascript" src="../../js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript">
	
	//Ouvrir les appariements
	function confirmOpen() {
        var n = noty({
            text        : 'Voulez vous vraiment <b>ouvrir</b> les appariements ?',
            type        : 'information',
            dismissQueue: true,
            layout      : 'center',
            theme       : 'defaultTheme',
			 animation   : {
                    open  : 'animated flipInX',
                    close : 'animated flipOutX',
                    easing: 'swing',
                    speed : 1000
                },
            buttons     : [
                {addClass: 'btn btn-primary', text: 'Oui', onClick: function ($noty) {
                    $noty.close();
					document.location.href="../../controleurs/secretariat/appariement.php?state=open";
                }
                },
                {addClass: 'btn btn-danger', text: 'Annuler', onClick: function ($noty) {
                    $noty.close();
                    
                }
                }
            ]
        });
		
		
        console.log('html: ' + n.options.id);
    }
	
	//Fermer les appariements
	function confirmClose() {
        var n = noty({
            text        : 'Voulez vous vraiment <b>fermer</b> les appariements ?',
            type        : 'information',
            dismissQueue: true,
            layout      : 'center',
            theme       : 'defaultTheme',
			 animation   : {
                    open  : 'animated flipInX',
                    close : 'animated flipOutX',
                    easing: 'swing',
                    speed : 1000
                },
            buttons     : [
                {addClass: 'btn btn-primary', text: 'Oui', onClick: function ($noty) {
                    $noty.close();
					document.location.href="../../controleurs/secretariat/appariement.php?state=close";
                }
                },
                {addClass: 'btn btn-danger', text: 'Annuler', onClick: function ($noty) {
                    $noty.close();
                    
                }
                }
            ]
        });
		
		
        console.log('html: ' + n.options.id);
    }
	
	function generatePopup(type, text) {

            var popup = noty({
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
		
		function generateOpened() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> Les appariements ont bien été <b>ouverts</b> </div> </div>');
			
		 }
		 
		 function generateClosed() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> Les appariements ont bien été <b>fermés</b> </div> </div>');
		 }
	
	</script>
    
     <!-- Affiche la popup de la appariements ouverts ou fermés-->
    <?php
		if(isset($_GET['state'])){
			if($_GET['state']=="open"){
				echo"
		 
   				 <script type=\"text/javascript\">

					$(document).ready(function () {

           			 setTimeout(function() {
              			 generateOpened();
           			 }, 200);
			
					setTimeout(function () {
           				$.noty.closeAll();
        			}, 3000);
		
       			 });

    		</script>
   			";
			}
			else{
				echo"
		 
   				 <script type=\"text/javascript\">

					$(document).ready(function () {

           			 setTimeout(function() {
              			 generateClosed();
           			 }, 200);
			
					setTimeout(function () {
           				$.noty.closeAll();
        			}, 3000);
		
       			 });

    		</script>
   			";
			}
		
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