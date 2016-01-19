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
		
		$resultat=mysqli_query($co,  "SELECT COUNT(*)
									  FROM etudiant");
		$row = mysqli_fetch_row($resultat);
		$nb_etudiant = $row[0];
		
		$resultat=mysqli_query($co,  "SELECT COUNT(*)
									  FROM enseignant");
		$row = mysqli_fetch_row($resultat);
		$nb_enseignant = $row[0];
		
		$resultat=mysqli_query($co,  "SELECT COUNT(*)
									  FROM appariement_enseignant");
		$row = mysqli_fetch_row($resultat);
		$nb_etudiant_tuteur = $row[0];
		
		$resultat=mysqli_query($co,  "SELECT COUNT(DISTINCT enseignant)
									  FROM appariement_enseignant");
		$row = mysqli_fetch_row($resultat);
		$nb_tuteur_different = $row[0];
		
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
						<li><a href="accueil.php" class="PageActive">Accueil</a></li>
						<li><a href="page_stat_fiche.php">Statistiques fiches</a></li>
						<li><a href="session_appariement.php">Session d'appariement</a></li>
						<li><a href="statistiques_tuteurs.php">statistiques Tuteurs</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">  
            <p>Bienvenue <b><?php echo $membre->prenom." ".$membre->nom?></b>.</br>
				Vous pouvez via ce site, voir les statistiques des stages de S4, ainsi que gérer les sessions de demande d'appariement, afin d'autoriser les professeurs à choisir des élèves pour être leur professeur référant. <br/><br/>
				Vous pouvez donc consulter les statistiques des fiches de étudiants, ou encore regarder les étudiants qui n'ont pas encore de tuteur. <br/><br/>
				Enfin vous pouvez contacter les différents élèves.
				</p> 
				<div class="TitrePartie" id="titre1">Statistiques générales : </div>
				<p> Nombre d'étudiants total : <b><?php echo $nb_etudiant ?></b></p>
                <p> Nombre d'étudiants <b>avec</b> professeur tuteur : <b><?php echo $nb_etudiant_tuteur ?></b></p>
                <p> Nombre d'étudiants <b>sans</b> professeur tuteur : <b><?php echo intval($nb_etudiant)-intval($nb_etudiant_tuteur); ?></b></p>
                <p> Nombre d'enseignants total : <b><?php echo $nb_enseignant ?></b></p>
                <p> Nombre d'enseignants tuteurs différents : <b><?php echo $nb_tuteur_different ?></b></p>
				
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
		 
		 function generateHello() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-home text-success\"></i> <div class=\"activity\"> Bienvenue dans votre espace membre ! </div> </div>');
		 }
		 
	</script>
    
    <!-- Affiche la popup Bienvenue-->
    <?php
		if(isset($_GET['welcome'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateHello();
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