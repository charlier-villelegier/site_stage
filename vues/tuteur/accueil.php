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
		$nb_champ = 14;
		
		//Remplissage de la fiche d'appreciation sur le stagiaire
		//Etudiant
		$resultat = mysqli_query($co,  "SELECT prenom, nom
										FROM appariement_tuteur A, etudiant E
										WHERE A.etudiant = E.login
										AND tuteur='$membre->login'");
		$row = mysqli_fetch_row($resultat);
	   	$prenom_etudiant = $row[0];
		$nom_etudiant = $row[1];
		
		//Entreprise
		$resultat = mysqli_query($co,  "SELECT E.nom_entreprise
										FROM tuteur_entreprise T, entreprise E
										WHERE T.entreprise = E.num_entreprise
										AND T.login='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$nom_entreprise = $row[0];
		
		if($nom_entreprise!=NULL) $stat+=1;
		
		//Tuteur
		$resultat = mysqli_query($co,  "SELECT prenom, nom
										FROM tuteur_entreprise
										WHERE login='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$prenom_tuteur = $row[0];
		$nom_tuteur = $row[1];
		
		if($prenom_tuteur!=NULL) $stat+=1;
		if($nom_tuteur!=NULL) $stat+=1;
		
		//NumJury
		$resultat = mysqli_query($co,  "SELECT num_jury, raison_embauche
										FROM appariement_tuteur A, etudiant E, fiche_tuteur F
										WHERE A.etudiant = E.login
										AND F.num_fiche = E.sa_fiche_tuteur
										AND tuteur='$membre->login'");
										
		$row = mysqli_fetch_row($resultat);
		$num_jury = $row[0];
		$raison_embauche = $row[1];
		
		if($num_jury!=NULL) $stat+=1;
		if($raison_embauche!=NULL) $stat+=1;
		
		//Contacts
		$resultat = mysqli_query($co,  "SELECT nom_rh, mail_rh, telephone_rh,
										nom_taxe, mail_taxe, telephone_taxe,
										nom_relation, mail_relation, telephone_relation
										FROM appariement_tuteur A, etudiant E, fiche_tuteur F
										WHERE A.etudiant = E.login
										AND F.num_fiche = E.sa_fiche_tuteur
										AND tuteur='$membre->login'");				
		$row = mysqli_fetch_row($resultat);
		$nom_rh = $row[0];
		$mail_rh = $row[1];
		$telephone_rh = $row[2];
		$nom_taxe = $row[3];
		$mail_taxe = $row[4];
		$telephone_taxe = $row[5];
		$nom_relation = $row[6];
		$mail_relation = $row[7];
		$telephone_relation = $row[8];
		
		if($nom_rh!=NULL) $stat+=1;
		if($mail_rh!=NULL) $stat+=1;
		if($telephone_rh!=NULL) $stat+=1;
		if($nom_taxe!=NULL) $stat+=1;
		if($mail_taxe!=NULL) $stat+=1;
		if($telephone_taxe!=NULL) $stat+=1;
		if($nom_relation!=NULL) $stat+=1;
		if($mail_relation!=NULL) $stat+=1;
		if($telephone_relation!=NULL) $stat+=1;
		
		$pourcentage_fiche = intval(($stat/$nb_champ)*100);
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
                    	Statut : Tuteur
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
						<li><a href="page_fiche_entreprise.php">Mes fiches</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
						<li><a href="page_contact.php">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<p>Bienvenue <?php echo $membre->prenom." ".$membre->nom?>.</br>
				Vous êtes le tuteur en entreprise de <b><?php echo $prenom_etudiant." ".$nom_etudiant?></b>. 
				Grâce à votre espace, vous pourrez saisir la fiche d'appréciation sur votre stagiaire dans l'onglet "Mes fiches"
				Si vous pensez venir assister à la soutenance de fin de stage de l'étudiant, nous vous demanderons également de saisir vos disponibilités (via l'onglet "Mes disponibilités") pour établir un planning des soutenances.
				Vous pouvez également contacter votre étudiant par mail via l'onglet "Contacts".<br/><br/>
				Pour le moment, la fiche concernant votre stagiaire est rempli à <b><?php echo $pourcentage_fiche?>%</b>.
				</p> 
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
			'<div class=\"activity-item\"> <i class=\"fa fa-home text-success\"></i> <div class=\"activity\"> Bienvenue dans votre espace membre !</div> </div>');
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