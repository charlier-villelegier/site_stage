<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		header('Location: ../../index.html'); 
	}
	else{
		$membre=$_SESSION['membre'];
		$bd = new Bd("site_stage");
		$co = $bd->connexion();
		
		//Etudiant
		$resultat = mysqli_query($co,  "SELECT nom,prenom
										FROM appariement_enseignant ae, enseignant e
										WHERE ae.enseignant=e.login
										AND etudiant='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$nom_enseignant = $row[0];
		$prenom_enseignant = $row[1];
		
		
		$resultat = mysqli_query($co,  "SELECT adresse,ville,code_postal,mail_iut,tel_portable
										FROM etudiant 
										WHERE login='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$adresse_etudiant = $row[0];
		$ville_etudiant = $row[1];
		$cp_etudiant = $row[2];
		$mail_iut = $row[3];
		$tel = $row[4];
		
		//Entreprise
		$resultat = mysqli_query($co,  "SELECT nom_entreprise, adresse, ville, code_postal
										FROM appariement_tuteur at, tuteur_entreprise t, entreprise e
										WHERE at.tuteur=t.login
										AND t.entreprise=e.num_entreprise
										AND etudiant='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$nom_entreprise = $row[0];
		$adresse_entreprise = $row[1];
		$ville_entreprise = $row[2];
		$cp_entreprise = $row[3];
		
		//Tuteur
		$resultat = mysqli_query($co,  "SELECT nom, prenom, telephone, mail
										FROM appariement_tuteur at, tuteur_entreprise t
										WHERE at.tuteur=t.login
										AND etudiant='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$nom_tuteur = $row[0];
		$prenom_tuteur = $row[1];
		$tel_tuteur = $row[2];
		$mail_tuteur = $row[3];
		
		//Complément étudiant
		$resultat = mysqli_query($co,  "SELECT tel_entreprise, tel_portable, mail_perso, sujet_stage 
										FROM etudiant 
										WHERE login='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$tel_entreprise = $row[0];
		$tel_portable = $row[1];
		$mail_perso = $row[2];
		$sujet_stage = $row[3];
		
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
                    	Statut : Etudiant
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
    <div class="menu">
		<div class="ConteneurHautPetit"></div>
		<div class="ConteneurPrincipalePetit">
			<div class="ConteneurPetitPlan">
				<div class="PlanMenu">Mes fiches</div>
				<ul>
					<li><div class="TitrePlan"><a href="#">Fiche de localisation</a></div></li>
					<li><div class="TitrePlan"><a href="page_fiche_avis.php">Fiche d'avis sur le stage</a></div></li>
				</ul>
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
						<li><a href="page_fiche_localisation.php" class="PageActive">Mes fiches</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
						<li><a href="page_contact.php">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">LOCALISATION DE STAGE</div>
				<form method="post" action="../../controleurs/etudiant/save_fiche_localisation.php">
				<p>
					<label for="NomEtudiant">Nom : </label>
						<input name="NomEtudiant" type="text" value="<?php echo $membre->nom ?>"/>
					
					<label for="PrenomEtudiant">Prénom : </label>
						<input name="PrenomEtudiant" type="text" value="<?php echo $membre->prenom ?>"/>
					<br/>
					<br/>
						
					<label for="Tuteur">Tuteur/Tutrice : </label>
						<input name="Tuteur" type="text" value="<?php echo $prenom_enseignant." ".$nom_enseignant?>" disabled="disabled"/>
					<br/>
					<br/>
					
					<label for="AdresseEtudiant">Adresse personnelle (hors scolarité) : </label>
						<input name="AdresseEtudiant" type="text"  value="<?php echo $adresse_etudiant?>" size="35"/>
					<br/>
					<br/>
					
					<label for="VilleEtudiant">Ville : </label>
						<input name="VilleEtudiant" type="text"  value="<?php echo $ville_etudiant?>"/>
					<br/>
					<br/>
					
					<label for="CPEtudiant">Code postal : </label>
						<input name="CPEtudiant" type="text"  value="<?php echo $cp_etudiant?>"/>
					<br/>
					<br/>
					
					<label for="MailEtudiant">Courrier IUT : </label>
						<input name="MailEtudiant" type="text"  value="<?php echo $mail_iut?>"/>
						
					<label for="TelEtudiant">Téléphone : </label>
						<input name="TelEtudiant" type="text"  value="<?php echo $tel?>"/>
					<br/>
					<br/>
					
					<div id="entreprise"> </div>
					<h3> Entreprise </h3>
					<label for="NomEntreprise">Nom de l'établissement où s'effectue le stage : </label>
						<input name="NomEntreprise" type="text"  value="<?php echo $nom_entreprise?>"/>
					<br/>
					<br/>
					
					<label for="AdresseEntreprise">Adresse (Lieu du stage) : </label>
						<input name="AdresseEntreprise" type="text" value="<?php echo $adresse_entreprise?>" size="35"/>
					<br/>
					<br/>
					
					<label for="VilleEntreprise">Ville : </label>
						<input name="VilleEntreprise" type="text" value="<?php echo $ville_entreprise?>"/>
					<br/>
					<br/>
					
					<label for="CPEntreprise">Code postal : </label>
						<input name="CPEntreprise" type="text" value="<?php echo $cp_entreprise?>"/>
					<br/>
					<br/>
					
					<label for="NomResponsable">Nom du responsable du stage : </label>
						<input name="NomResponsable" type="text" value="<?php echo $prenom_tuteur." ".$nom_tuteur?>" disabled="disabled"/>
					<br/>
					<br/>
					
					<label for="TelResponsable">Numéro de téléphone où l'on peut le joindre : </label>
						<input name="TelResponsable" type="text" value="<?php echo $tel_tuteur?>" disabled="disabled"/>
					<br/>
					<br/>
					
					<label for="MailResponsable">E-mail : </label>
						<input name="MailResponsable" type="text" value="<?php echo $mail_tuteur?>" disabled="disabled" size="35"/>
					<br/>
					<br/>
					
					<div id="etudiant"> </div>
					<h3> Etudiant </h3>
					
					<label for="TelEntreprise">Numéro de téléphone où l'on peut vous joindre en entreprise : </label>
						<input name="TelEntreprise" type="text" value="<?php echo $tel_entreprise?>"/>
					<br/>
					<br/>
					
					<label for="MailPerso">E-Mail personnel : </label>
						<input name="MailPerso" type="text" value="<?php echo $mail_perso?>" size="35"/>
					<br/>
					<br/>
					
					<label>Sujet du stage : </label> <br/>
						<textarea rows="20" cols="50" name="SujetStage"><?php echo $sujet_stage?></textarea>
					<br/>
					
				
					<p style="text-align: center;">
						<input name="Enregistrer" type="submit" value="Enregistrer"/>
					</p>
					
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
    
     <!-- Affiche la popup de données enregistrées si nécessaire--!>
    <?php
		if(isset($_GET['saved'])){
		echo"
    <script type=\"text/javascript\" src=\"../../js/noty/packaged/jquery.noty.packaged.js\"></script>
    <script type=\"text/javascript\">


        function generate(type, text) {

            var n = noty({
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

        function generateAll() {
            generate('success', '<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> Vos changements ont bien été enregistrés </div> </div>');
        }

        $(document).ready(function () {

            setTimeout(function() {
                generateAll();
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