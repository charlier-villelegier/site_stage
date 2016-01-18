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
			
        </div>
    </div>
    <div class="contenu_page">
		<div class="ConteneurHaut"></div>
		<div class="ConteneurPrincipale">
			<div class="Bleue">
				<div id="Ribbon">
					<ul>
						<li><a href="accueil.php">Accueil</a></li>
						<li><a href="" class="PageActive">Statistiques fiches</a></li>
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
													
					echo"<table border='1' width=\"100%\" cellpadding=\"10\">";
						echo"<tr>";
							echo"<td align=\"center\"><b>Nom</b></td>";	
							echo"<td align=\"center\"><b>Prénom</b></td>";		
							echo"<td align=\"center\"><b>Fiche de localisation</b></td>";
							echo"<td align=\"center\"><b>Fiche d'avis</b></td>";
							echo"<td></td>";
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
								<td ><input style="width:100%" type="button" value="Contacter"/></td>
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