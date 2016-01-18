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
		
		$stat = 0;
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
                        <li><a href="#">Contacts</a></li>
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
				
				<TABLE BORDER align="center">
			
						<TR>
							<TD name="FicheTitre" align="center"><b>Vos fiches</b></TD>
							<TD name="RemplissageTitre" align="center"><b>Remplissage</b></TD>
						</TR>
						
						<TR>
							<TD name="LabelFicheLocalisation">Fiche de localisation</p> </TD>
							<TD align="center"><?php echo $pourcentage_localisation?>%</TD>
						</TR>
						
						<TR>
							<TD name="LabelFicheAvis">Fiche d'avis sur le stage</TD>
							<TD name="PourcentageFicheAvis" align="center">Environ <?php echo $pourcentage_avis?>%</TD>
						</TR>
				</TABLE>	
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