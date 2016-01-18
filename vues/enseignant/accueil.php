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
						<input name="Deconnexion" type="submit" value="Déconnexion"/>
					</p>
                   
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
				<div id="Ribbon">
					<ul>
						<li><a href="accueil.php" class="PageActive">Accueil</a></li>
						<li><a href="page_mes_etudiants.php" >Gérer mes étudiants</a></li>
						<li><a href="page_etudiant_disponible.php">Etudiants disponibles</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<p>Bienvenue <?php echo $membre->prenom." ".$membre->nom?>.</br>
				Vous pouvez via ce site gérer les étudiants dont vous êtes le tuteur, c'est-à-dire pouvoir remplir leur fiche de visite de stage et supprimer un appariement avec un étudiant. <br/>
				Vous pouvez également grâce à l'onglet "Etudiants disponibles", effectuer des demandes d'appariement avec un étudiant pour devenir son tuteur de stage. <br/>
				Enfin vous pouvez contacter les différents membres du stage via l'onglet "Contacts" (Responsable du stage, étudiants, secrétariat etc.).
				</p>
				<div class="TitrePartie" id="titre1">Vos statistiques : </div>
				
				<?php
					//Je récupère et j'affiche la liste des étudiants sans tuteurs
					$resultat = mysqli_query($co,  "SELECT nom, prenom, login
													FROM etudiant E, appariement_enseignant A
													WHERE E.login=A.etudiant
													AND A.enseignant='$membre->login'
													ORDER BY nom");
													
					
					
					echo"<table class=\"tab\" width=\"100%\" cellpadding=\"10\">";
						echo"<tr>";
							echo"<th align=\"center\"><b><font color=\"white\">Nom</font></b></th>";	
							echo"<th align=\"center\"><b><font color=\"white\">Prenom</font></b></th>";		
							echo"<th align=\"center\"><b><font color=\"white\">Remplissage de sa fiche de visite de stage</font></b></th>";	
						echo"</tr>";	
					if(mysqli_num_rows($resultat)>0){							
						while($row = mysqli_fetch_row($resultat)){
							$nom=$row[0];
							$prenom=$row[1];
							$login=$row[2];
							
							//Remplissage de la fiche de chaque étudiant
							$stat = 0;
							$nb_champ = 5;
							
							$resultat2 = mysqli_query($co,  "SELECT drh, telephone_drh, mail_drh, commentaire_comportement, avis_enseignant
															FROM appariement_enseignant A, etudiant E, fiche_visite F
															WHERE A.etudiant = E.login
															AND F.num_fiche = E.sa_fiche_tuteur
															AND enseignant='$membre->login'
															AND A.etudiant='$login'");
															
							$row2 = mysqli_fetch_row($resultat2);
							$drh = $row2[0];
							$telephone_drh = $row2[1];
							$mail_drh = $row2[2];
							$commentaire_comportement = $row2[3];
							$avis_enseignant = $row2[4];
							
							if($drh!=NULL) $stat+=1;
							if($telephone_drh!=NULL) $stat+=1;
							if($mail_drh!=NULL) $stat+=1;
							if($commentaire_comportement!=NULL) $stat+=1;
							if($avis_enseignant!=NULL) $stat+=1;
							
							$pourcentage_fiche = intval(($stat/$nb_champ)*100);
							
							echo"<tr>";
								echo"<td>$nom</td>";
								echo"<td>$prenom</td>";
								echo"<td align=\"center\">$pourcentage_fiche %</td>";
								?>
                                <?php
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
			'<div class=\"activity-item\"> <i class=\"fa fa-home text-success\"></i> <div class=\"activity\">Bienvenue dans votre espace membre !</div> </div>');
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