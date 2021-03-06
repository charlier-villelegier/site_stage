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
	<style type="text/css">
		.tab  {border-collapse:collapse;border-spacing:0;}
		.tab td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tab th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; background-color:#26ade4;}
	</style>
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
						<li><a href="accueil.php">Accueil</a></li>
						<li><a href="page_stat_fiche.php" class="PageActive">Statistiques fiches</a></li>
						<li><a href="session_appariement.php">Session d'appariement</a></li>
						<li><a href="statistiques_tuteurs.php">statistiques Tuteurs</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<p>
				</p>
				<div class="TitrePartie" id="titre1">Statistiques de la promotion : </div>
				
				<?php
					//Je récupère et j'affiche la liste des étudiants sans tuteurs
					$resultat = mysqli_query($co,  "SELECT nom, prenom, login
													FROM etudiant
													ORDER BY nom");
													
					echo"<table class=\"tab\" width=\"100%\" cellpadding=\"10\">";
						echo"<tr>";
							echo"<th align=\"center\"><b><font color=\"white\">Nom</font></b></th>";	
							echo"<th align=\"center\"><b><font color=\"white\">Prénom</font></b></th>";		
							echo"<th align=\"center\"><b><font color=\"white\">Fiche de localisation</font></b></th>";
							echo"<th align=\"center\"><b><font color=\"white\">Fiche d'avis</font></b></th>";
							echo"<th></th>";
						echo"</tr>";	
					if(mysqli_num_rows($resultat)>0){							
						while($row = mysqli_fetch_row($resultat)){
							$nom=$row[0];
							$prenom=$row[1];
							$login=$row[2];
							
							$stat_localisation = 0;
							$stat_avis = 0;
							//Remplissage de la fiche de localisation
							$nb_champ_localisation = 14;
							$resultat2=mysqli_query($co,  "SELECT nom, prenom, adresse, ville, code_postal, mail_iut,
														  mail_perso, tel_portable, tel_entreprise, sujet_stage, tp
														  FROM etudiant
														  WHERE login='$login'");
							$row = mysqli_fetch_row($resultat2);
							$nom = $row[0];
							$prenom = $row[1];
							$adresse = $row[2];
							$ville = $row[3];
							$code_postal = $row[4];
							$mail_iut = $row[5];
							$mail_perso = $row[6];
							$tel_portable = $row[7];
							$tel_entreprise = $row[8];
							$sujet_stage = $row[9];
							$tp = $row[10];
							
							if($nom!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							if($prenom!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							if($adresse!=NULL) $stat_localisation+=1;
							if($ville!=NULL) $stat_localisation+=1;
							if($code_postal!=NULL) $stat_localisation+=1;
							if($mail_iut!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							if($mail_perso!=NULL) $stat_localisation+=1;
							if($tel_portable!=NULL) $stat_localisation+=1;
							if($tel_entreprise!=NULL) $stat_localisation+=1;
							if($sujet_stage!=NULL) $stat_localisation+=1;
							
							$resultat2=mysqli_query($co,  "SELECT nom_entreprise, adresse, ville, code_postal
														  FROM appariement_tuteur at, tuteur_entreprise t, entreprise e
														  WHERE at.tuteur=t.login
														  AND t.entreprise=e.num_entreprise
														  AND etudiant='$login'");
							$row = mysqli_fetch_row($resultat2);
							$nom_entreprise = $row[0];
							$adresse_entreprise = $row[1];
							$ville_entreprise = $row[2];
							$cp_entreprise = $row[3];
							
							if($nom_entreprise!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							if($adresse_entreprise!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							if($ville_entreprise!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							if($cp_entreprise!=NULL) {$stat_localisation+=1; $stat_avis+=1;}
							
							$pourcentage_localisation = intval(($stat_localisation/$nb_champ_localisation)*100);
							
							//Remplissage de la fiche d'avis
							$nb_champ_avis = 10;
							$resultat2 = mysqli_query($co, "SELECT f.langage, f.apport_stage 
														   FROM etudiant e, fiche_avis f
														   WHERE e.sa_fiche_avis=f.num_fiche
														   AND e.login='$login'");
							$row = mysqli_fetch_row($resultat2);
							$langage=$row[0];
							$apport_stage=$row[1];
							
							if($tp!=NULL) $stat_avis+=1;
							if($langage!=NULL) $stat_avis+=1;
							if($apport_stage!=NULL) $stat_avis+=1;
							
							$pourcentage_avis = intval(($stat_avis/$nb_champ_avis)*100);
							
							echo"<tr>";
								echo"<td>$nom</td>";
								echo"<td>$prenom</td>";
								echo"<td align=\"center\">$pourcentage_localisation %</td>";
								echo"<td align=\"center\">$pourcentage_avis %</td>";
								?>
								<td ><input style="width:100%" type="button" onclick="generateContact('<?php echo $nom?>','<?php echo $prenom ?>','<?php echo $mail_iut ?>')" value="Contacter"/></td>
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
    
    <!--Fonctions javascript pour les popup-->
    <script type="text/javascript" src="../../js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript">
	
	//Contact d'un étudiant
	 function generateContact(nom,prenom,mail) {
        var n = noty({
            text        : 'Contacter <b>'+ nom + ' ' + prenom + '</b> : <br/> <br/>'
							+ '<div align="left">Objet :'
							+ '<input type="text" id="objet"/></div> <br/>'
							+ '<div align="left">Corps : </label> <br/>'
							+ '<textarea rows="10" cols="40" name="corps" id="corps"></textarea></div>',
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
                {addClass: 'btn btn-primary', text: 'Envoyer', onClick: function ($noty) {
                    $noty.close();
					var objet=document.getElementById("objet").value;
					var corps=document.getElementById("corps").value;
					document.location.href="../../controleurs/secretariat/send_mail.php?to="+mail+"&objet="+objet+"&corps="+corps+"&page=fiches";
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
		
		function generateSent() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-envelope-o text-success\"></i> <div class=\"activity\"> Votre message à bien été envoyé </div> </div>');
		 }
		 
	
	</script>
    
    <!-- Affiche la popup du message envoyé-->
    <?php
		if(isset($_GET['sent'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateSent();
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