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
		
		$stat_localisation = 0;
		$stat_avis = 0;
		//Remplissage de la fiche de localisation
		$nb_champ_localisation = 14;
		$resultat=mysqli_query($co,  "SELECT nom, prenom, adresse, ville, code_postal, mail_iut,
									  mail_perso, tel_portable, tel_entreprise, sujet_stage, tp
									  FROM etudiant
									  WHERE login='$membre->login' AND mdp='$membre->mdp'");
		$row = mysqli_fetch_row($resultat);
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
		
		$resultat=mysqli_query($co,  "SELECT nom_entreprise, adresse, ville, code_postal
									  FROM appariement_tuteur at, tuteur_entreprise t, entreprise e
									  WHERE at.tuteur=t.login
									  AND t.entreprise=e.num_entreprise
									  AND etudiant='$membre->login'");
		$row = mysqli_fetch_row($resultat);
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
		$resultat = mysqli_query($co, "SELECT f.langage, f.apport_stage 
									   FROM etudiant e, fiche_avis f
									   WHERE e.sa_fiche_avis=f.num_fiche
									   AND e.login='$membre->login' AND e.mdp='$membre->mdp'");
		$row = mysqli_fetch_row($resultat);
		$langage=$row[0];
		$apport_stage=$row[1];
		
		if($tp!=NULL) $stat_avis+=1;
		if($langage!=NULL) $stat_avis+=1;
		if($apport_stage!=NULL) $stat_avis+=1;
		
		$pourcentage_avis = intval(($stat_avis/$nb_champ_avis)*100);
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

    <div class="contenu_page">
		<div class="ConteneurHaut"></div>
		<div class="ConteneurPrincipale">
			<div class="Bleue">
				<div id="Ribbon">
					<ul>
						<li><a href="accueil.php" class="PageActive">Accueil</a></li>
						<li><a href="page_fiche_localisation.php" >Mes fiches</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">
				<p>Bienvenue <?php echo $membre->prenom." ".$membre->nom?>.</br>
				Vous pouvez via ce site remplir les fiches concernant votre stage du dernier semestre de l'IUT grâce à l'onglet "Mes fiches" ci-dessus. </br>
				Vous pouvez également saisir vos différentes disponibilités pour la soutenance de votre rapport de stage via l'onglet "Mes disponibilités". </br>
				Enfin, vous pourrez contacter les différents membres qui concerne votre stage (tuteur, reponsable en entreprise, secrétariat, etc.) via l'onglet "Contact".
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