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
						<li><a href="page_mes_etudiants.php" class="PageActive">Gérer mes étudiants</a></li>
						<li><a href="page_etudiant_disponible.php">Etudiants disponibles</a></li>
						<li><a href="#">Mes disponibilités</a></li>
                        <li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">Etudiants dont vous êtes le tuteur : </div>
                <p>Voici la liste des étudiants <b>dont vous êtes le tuteur.</b></p>
                <p>Vous pouvez sur cette page remplir leur fiche, ou bien les supprimer afin qu'un autre professeur puisse être son tuteur.</p>
                <?php
					//Je récupère et j'affiche la liste des étudiants sans tuteurs
					$resultat = mysqli_query($co,  "SELECT nom, prenom, tp, login
													FROM etudiant E, appariement_enseignant A
													WHERE E.login=A.etudiant
													AND A.enseignant='$membre->login'
													ORDER BY nom");
													
					
					
					echo"<table border='1' width=\"100%\" cellpadding=\"10\">";
						echo"<tr>";
							echo"<td><b>NOM</b></td>";	
							echo"<td><b>PRENOM</b></td>";		
							echo"<td><b>TP</b></td>";
						echo"</tr>";	
					if(mysqli_num_rows($resultat)>0){							
						while($row = mysqli_fetch_row($resultat)){
							$nom=$row[0];
							$prenom=$row[1];
							$tp=($row[2]==NULL? "Non renseigné" : $row[2]);
							$login=$row[3];
						
							echo"<tr>";
								echo"<td>$nom</td>";
								echo"<td>$prenom</td>";
								echo"<td>$tp</td>";
								echo"<form>";
								?>
                                <td><input type="button" value="Remplir sa fiche de visite" 
                                	onclick="self.location.href='page_fiche_visite.php?etudiant=<?php echo $login ?>'"/></td>
								<td><input type="button" value="Supprimer" onclick="generate('<?php echo $nom.' '.$prenom?>','<?php echo $login ?>')"/></td>
                                <?php
								echo"</form>";
							echo"</tr>";
						}
					}
					else{
						echo"<tr>";
							echo"<td colspan=\"3\" align=\"center\">Vous n'êtes tuteur d'aucun étudiant</td>";
						echo"</tr>";
					}
						
					echo"</table>";
					
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

    function generate(name,login) {
        var n = noty({
            text        : 'Voulez vous vraiment ne plus être le tuteur de <b>' + name  + ' </b> ?',
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
                {addClass: 'btn btn-danger', text: 'Oui', onClick: function ($noty) {
                    $noty.close();
					document.location.href="../../controleurs/enseignant/delete_etudiant.php?etudiant="+login
                    
                }
                },
                {addClass: 'btn btn-primary', text: 'Annuler', onClick: function ($noty) {
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
		
		 function generateDeleted(nom,prenom) {
			
			
            generatePopup('success', '<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> Vous n\'êtes plus le tuteur de <b>'+nom+' '+ prenom+'</b> </div> </div>');
		 }
		 
		 function generateAdded(nom,prenom) {
			
			
            generatePopup('success', '<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> Vous êtes maintenant le tuteur de <b>'+nom+' '+ prenom+'</b> </div> </div>');
		 }
	

</script>
	
	
    <!-- Affiche la popup de l'étudiant supprimé-->
    <?php
		if(isset($_GET['deleted'])){
			$nom=$_GET['nom'];
			$prenom=$_GET['prenom'];
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateDeleted('$nom','$prenom');
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    	</script>
    ";
    }
    ?>
    
     <!-- Affiche la popup de l'étudiant ajouté-->
    <?php
		if(isset($_GET['added'])){
			$nom=$_GET['nom'];
			$prenom=$_GET['prenom'];
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateAdded('$nom','$prenom');
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