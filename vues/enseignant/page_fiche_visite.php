<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		header('Location: ../../index.html'); 
	}
	else{
		$membre=$_SESSION['membre'];
		$etudiant = $_GET['etudiant'];
		$bd = new Bd("site_stage");
		$co = $bd->connexion();
		
		//Etudiant
		$resultat = mysqli_query($co,  "SELECT prenom, nom, tp
										FROM appariement_enseignant A, etudiant E
										WHERE A.etudiant = E.login
										AND enseignant='$membre->login'
										AND A.etudiant='$etudiant'");
		$row = mysqli_fetch_row($resultat);
		$prenom_etudiant = $row[0];
		$nom_etudiant = $row[1];
		$tp_etudiant = $row[2];
		
		//Enseignant
		$resultat = mysqli_query($co,  "SELECT prenom, nom
										FROM enseignant
										WHERE login='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$prenom_enseignant = $row[0];
		$nom_enseignant = $row[1];
		
		//Entreprise
		$resultat = mysqli_query($co,  "SELECT nom_entreprise, adresse, ville, code_postal
										FROM tuteur_entreprise T, entreprise E, appariement_enseignant A, appariement_tuteur AE, enseignant EN
										WHERE T.entreprise = E.num_entreprise
										AND A.etudiant = AE.etudiant
										AND AE.tuteur = T.login
										AND A.enseignant = EN.login
										AND EN.login='$membre->login'
										AND A.etudiant='$etudiant'");
		$row = mysqli_fetch_row($resultat);
		$nom_entreprise = $row[0];
		$adresse_entreprise = $row[1];
		$ville_entreprise = $row[2];
		$cp_entreprise = $row[3];
		
		//Tuteur
		$resultat = mysqli_query($co,  "SELECT prenom, nom, fonction
										FROM tuteur_entreprise T, appariement_enseignant A, appariement_tuteur AE
										WHERE A.etudiant = AE.etudiant
										AND AE.tuteur = T.login
										AND A.enseignant='$membre->login'
										AND A.etudiant='$etudiant'");
		$row = mysqli_fetch_row($resultat);
		$prenom_tuteur = $row[0];
		$nom_tuteur = $row[1];
		$fonction_tuteur = $row[2];
		
		//Fiche
		$resultat = mysqli_query($co,  "SELECT visite_stage, date_visite, drh, telephone_drh, mail_drh,
										encadre_informaticien, appel_informaticien, travail_seul, taille_equipe,
										systeme, multimedia, reseau, web, autre_dev, bd, autre_objet,
										avis_comportement, commentaire_comportement,
										manque_formation, explication_formation, avis_enseignant, accueil_entreprise, precaution
										FROM appariement_enseignant A, etudiant E, fiche_visite F
										WHERE A.etudiant = E.login
										AND F.num_fiche = E.sa_fiche_visite
										AND enseignant='$membre->login'
										AND A.etudiant='$etudiant'");
										
		$row = mysqli_fetch_row($resultat);
		$visite_stage = $row[0];
		$date_visite = $row[1];
		$drh = $row[2];
		$telephone_drh = $row[3];
		$mail_drh = $row[4];
		$encadre_informaticien = $row[5];
		$appel_informaticien = $row[6];
		$travail_seul = $row[7];
		$taille_equipe = $row[8];
		$systeme = $row[9];
		$multimedia = $row[10];
		$reseau = $row[11];
		$web = $row[12];
		$autre_dev = $row[13];;
		$bd = $row[14];
		$autre_objet = $row[15];
		$avis_comportement = $row[16];
		$commentaire_comportement = $row[17];
		$manque_formation = $row[18];
		$explication_formation = $row[19];
		$avis_enseignant = $row[20];
		$accueil_entreprise = $row[21];
		$precaution = $row[22];
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
                    	Statut : Professeur
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
				<div class="PlanMenu">Menu</div>
				<ul>
					<li><div class="TitrePlan"><a href="#encadrement">Encadrement de l'étudiant</a></div></li>
					<li><div class="TitrePlan"><a href="#objet">Objet du stage</a></div></li>
					<li><div class="TitrePlan"><a href="#avisEtu">Avis sur l'étudiant</a></div></li>
                    <li><div class="TitrePlan"><a href="#avisIUT">Avis sur l'IUT</a></div></li>
                    <li><div class="TitrePlan"><a href="#avisGeneral">Avis général</a></div></li>
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
						<li><a href="page_mes_etudiants.php" class="PageActive">Gérer mes étudiants</a></li>
						<li><a href="page_etudiant_disponible.php">Etudiants disponibles</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">COMPTE-RENDU DE VISITE DE STAGE</div>
	<form method="post" action="../../controleurs/enseignant/save_fiche_visite.php?etudiant=<?php echo $etudiant ?>">
		<p>
			<label for="NomEtudiant">Nom de l'étudiant : </label>
				<input name="NomEtudiant" type="text" value="<?php echo $prenom_etudiant." ".$nom_etudiant?>" disabled="disabled"/>
			<br/>
            <br/>
				
			<label for="Tuteur">Nom du tuteur / de la tutrice : </label>
				<input name="Tuteur" type="text" value="<?php echo $prenom_enseignant." ".$nom_enseignant?>" disabled="disabled"/>
			<br/>
			<br/>
			
			<label for="TP">TP : </label>
				<input name="TP" type="text" value="<?php echo $tp_etudiant?>"disabled="disabled"/>
			<br/>
			<br/>
			
			
			<label for="NomEntreprise">ENTREPRISE (Raison Sociale) : </label>
				<input name="NomEntreprise" type="text" value="<?php echo $nom_entreprise?>"disabled="disabled"/>
			<br/>
			<br/>
			
			<label for="AdresseEntreprise">Adresse : </label>
				<input name="AdresseEntreprise" type="text" value="<?php echo $adresse_entreprise?>"disabled="disabled"/>
			<br/>
			<br/>
			
			
			<label for="VilleEntreprise">Ville : </label>
				<input name="VilleEntreprise" type="text" value="<?php echo $ville_entreprise?>" disabled="disabled"/>
				
			<label for="CPEntreprise">Code Postal : </label>
				<input name="CPEntreprise" type="text" value="<?php echo $cp_entreprise?>" disabled="disabled"/>
			<br/>
			<br/>
			
			<label>Vous êtes vous rendu sur le lieu du stage pour rencontrer le stagiaire et son responsable de stage ? </label>
				<input name="StagiaireRencontre" type="radio" id="StagiaireRencontre" onclick="stagiaireRencontre()" value="StagiaireRencontre" <?php if($visite_stage)echo "checked=\"checked\"" ?>/><label for="StagiaireRencontre">Oui </label>
				<input name="StagiaireRencontre" type="radio" id="StagiaireNonRencontre" onclick="stagiaireRencontre()" value="StagiaireNonRencontre" <?php if(!$visite_stage)echo "checked=\"checked\"" ?>/><label for="StagiaireNonRencontre">Non </label>
			<br/>
			<br/>
			
			<label for="DateRencontre" id="LabelDateRencontre">Si oui, le : </label>
			<input name="DateRencontre" id="DateRencontre" type="date" value="<?php if($date_visite)echo $date_visite?>"/>
			<br/>
			<br/>
			
			<label for="NomResponsable">Nom du responsable rencontré : </label>
				<input name="NomResponsable" type="text" value="<?php echo $prenom_tuteur." ".$nom_tuteur?>" disabled="disabled"/>
            <br/>
            <br/>
			
			<label for="FonctionResponsable">Fonction du responsable : </label>
				<input name="FonctionResponsable" type="text" value="<?php echo $fonction_tuteur?>" disabled="disabled"/>
			<br/>
			<br/>
			
			<label for="NomRH">Nom du responsable des Ressources Humaines ou de la personne à contacter pour la taxe d'apprentissage : </label>
				<input name="NomRH" type="text" value="<?php echo $drh?>"/>
			<br/>
			<br/>
			
			<label for="TelRH">Téléphone : </label>
				<input name="TelRH" type="text" value="<?php echo $telephone_drh?>"/>
				
			<label for="MailRH">E-mail : </label>
				<input name="MailRH" type="email" value="<?php echo $mail_drh?>"/>
                
			<div id="encadrement"></div>
			<h3> ENCADREMENT DE L'ETUDIANT : </h3>
			
			<label>L'étudiant a-t-il été encadré directement par un informaticien ? </label>
				<input name="Informaticien" type="radio" value="Informaticien" <?php if($encadre_informaticien)echo "checked=\"checked\"" ?>/><label for="Informaticien">Oui </label>
				<input name="Informaticien" type="radio" value="NonInformaticien" <?php if(!$encadre_informaticien)echo "checked=\"checked\"" ?>/><label for="NonInformaticien">Non </label>
			<br/>
			<br/>
			
			<label>Si non, en cas de besoin pouvait-il faire appel à un informaticien ? </label>
				<input name="AppelInformaticien" type="radio" value="AppelInformaticien" <?php if($appel_informaticien)echo "checked=\"checked\"" ?>/><label for="AppelInformaticien">Oui </label>
				<input name="AppelInformaticien" type="radio" value="NonAppelInformaticien" <?php if(!$appel_informaticien)echo "checked=\"checked\"" ?>/><label for="NonAppelInformaticien">Non </label>
			<br/>
			<br/>
			
			<label>Dans le cadre de votre stage, l'étudiant a-t-il travaillé seul ? </label>
				<input name="Equipe" type="radio" value="Seul" id="Seul" onclick="tailleEquipe()" <?php if($travail_seul)echo "checked=\"checked\"" ?>/><label for="Seul">Oui </label>
				<input name="Equipe" type="radio" value="Groupe" id="Groupe" onclick="tailleEquipe()" <?php if(!$travail_seul)echo "checked=\"checked\"" ?>/><label for="Groupe">Non </label>
			<br/>
			<br/>
			
			<label for="TailleEquipe" id="LabelTailleEquipe">Si non, taille de l'équipe : </label>
				<input name="TailleEquipe" id="TailleEquipe" type="text" value="<?php echo $taille_equipe?>"/>
			<br/>
			<br/>
			
			<div id="objet"></div>
			<h3> OBJET PRINCIPAL DU STAGE (2 cases maximum à cocher) : </h3>
			
				<input name="Systeme" type="checkbox" value="Systeme"
                    <?php if($systeme)echo "checked=\"checked\"" ?>/><label for="Systeme">Système </label>
				<input name="Multimedia" type="checkbox" value="Multimedia"
                    <?php if($multimedia)echo "checked=\"checked\"" ?>/><label for="Multimedia">Multimedia </label>
				<input name="Reseaux" type="checkbox" value="Reseaux"
                    <?php if($reseau)echo "checked=\"checked\"" ?>/><label for="Reseaux">Réseaux </label>
				<input name="DeveloppementWEB" type="checkbox" value="DeveloppementWEB"
                    <?php if($web)echo "checked=\"checked\"" ?>/><label for="DeveloppementWEB">Développement WEB </label> <br/>
				<input name="AutreDvpt" type="checkbox" value="AutreDvpt"
                    <?php if($autre_dev)echo "checked=\"checked\"" ?>/><label for="AutreDvpt">Autre Développement </label>
				<input name="BD" type="checkbox" value="BD"
                    <?php if($bd)echo "checked=\"checked\"" ?>/><label for="BD">Base de données </label>
				<input name="AutreObjet" id="AutreObjet" onclick="autreObjet()" type="checkbox" value="Autre"
                    <?php if($autre_objet)echo "checked=\"checked\"" ?>/><label for="Autre">Autre (préciser) </label>
				<input name="AutreObjetText" id="AutreObjetText" type="text" value="<?php echo $autre_objet ?>"/>
			
            <div id="avisEtu"></div>
			<h3> AVIS DE L’ENTREPRISE SUR LE TRAVAIL ET LE COMPORTEMENT DE L’ETUDIANT </h3>
			
			<label>Globalement, concernant le travail de l'étudiant, êtes-vous : </label> <br/>
				<input name="Satisfaction" type="radio" value="TresSatisfait" <?php if($avis_comportement == "Très satisfait")echo "checked=\"checked\"" ?>/><label for="TresSatisfait">Très satisfait </label> <br/>
				<input name="Satisfaction" type="radio" value="Satisfait" <?php if($avis_comportement == "Satisfait")echo "checked=\"checked\"" ?>/><label for="Satisfait">Satisfait </label> <br/>
				<input name="Satisfaction" type="radio" value="PeuSatisfait" <?php if($avis_comportement == "Peu satisfait")echo "checked=\"checked\"" ?>/><label for="PeuSatisfait">Peu satisfait </label> <br/>
				<input name="Satisfaction" type="radio" value="PasSatisfait" <?php if($avis_comportement == "Pas satisfait")echo "checked=\"checked\"" ?>/><label for="PasSatisfait">Pas satisfait </label> <br/>
			<br/>
			
			<label>Commentaires : </label> <br/>
				<textarea rows="10" cols="50" name="CommentaireAvis"><?php echo $commentaire_comportement?></textarea>
			<br/>
			<br/>
			
            <div id="avisIUT"></div>
			<h3> AVIS DE L’ENTREPRISE SUR LA FORMATION RECUE A L'IUT </h3>
			
			<label>Dans la formation telle que vous l'avez perçue lors de la présence du stagiaire dans votre entreprise avez-vous constaté des manques handicapants pour un futur informaticien ?</label>
            <br/>
				<input name="Manque" type="radio" value="Manque" id="Manque" onclick="avisEntreprise()" <?php if($manque_formation)echo "checked=\"checked\"" ?>/><label for="Manque">Oui </label>
				<input name="Manque" type="radio" value="PasDeManque" id="PasDeManque" onclick="avisEntreprise()" <?php if(!$manque_formation)echo "checked=\"checked\"" ?>/><label for="PasDeManque">Non </label>
			<br/>
			<br/>
			
			<label id="LabelAvis">Si oui, précisez lesquelles : </label> <br/>
				<textarea rows="10" cols="50" name="CommentaireManque" id="CommentaireManque"><?php echo $explication_formation?></textarea>
			<br/>
			<br/>
			
            <div id="avisGeneral"></div>
			<h3> AVIS DE GENERAL DE L'ENSEIGNANT SUR LE STAGE : </h3>
			
			<textarea rows="20" cols="50" name="AvisEnseignant"><?php echo $avis_enseignant?></textarea>
			<br/>
			<br/>
			
			<label>En conclusion, cette entreprise peut-elle les prochaines années accueillir dans des conditions correctes ses étudiants ?</label> <br/>
				<input name="Accueil" type="radio" value="AccueilPossible" id="AccueilPossible" onclick="accueilCondition()"
                 <?php if($accueil_entreprise == "AccueilPossible")echo "checked=\"checked\"" ?>/><label for="AccueilPossible">Oui </label> <br/>
                 
				<input name="Accueil" type="radio" value="AccueilImpossible" id="AccueilImpossible" onclick="accueilCondition()" 
				<?php if($accueil_entreprise == "AccueilImpossible")echo "checked=\"checked\"" ?>/><label for="AccueilImpossible">Non </label> <br/>
                
				<input name="Accueil" type="radio" value="AccueilSousCondition" id="AccueilSousCondition" onclick="accueilCondition()"
                 <?php if($accueil_entreprise == "AccueilSousCondition") echo "checked=\"checked\"" ?>/>
                 <label for="AccueilSousCondition">Oui, mais en prenant quelques précautions.</label><br/>
                 
                 <label for="AccueilSousCondition" id="LabelAccueilSousCondition">Quelles précautions ?</label> <br/>
				<textarea rows="20" cols="50" name="Precaution" id="Precaution"><?php echo $precaution?></textarea>
			<br/>
			<br/>
		</p>

        <p style="text-align: center;">
			<input name="Enregistrer" type="submit" value="Enregistrer"/>
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
    
    <!-- Script pour activer ou non les text input-->
    <script type="text/javascript">
		function stagiaireRencontre(){
			if(document.getElementById('StagiaireRencontre').checked==true){
				document.getElementById('DateRencontre').hidden=false;
				document.getElementById('LabelDateRencontre').hidden=false;
				
			}
			else{
				document.getElementById('DateRencontre').hidden=true;
				document.getElementById('LabelDateRencontre').hidden=true;
				
			}
			
		}
		
		function tailleEquipe(){
			if(document.getElementById('Seul').checked==true){
				document.getElementById('TailleEquipe').hidden=true;
				document.getElementById('LabelTailleEquipe').hidden=true;
			}
			else{
				document.getElementById('TailleEquipe').hidden=false;
				document.getElementById('LabelTailleEquipe').hidden=false;
			}
			
		}
		
		function autreObjet(){
			if(document.getElementById('AutreObjet').checked==true){
				document.getElementById('AutreObjetText').hidden=false;
			}
			else{
				document.getElementById('AutreObjetText').hidden=true;
			}
			
		}
		
		function avisEntreprise(){
			if(document.getElementById('PasDeManque').checked==true){
				document.getElementById('CommentaireManque').hidden=true;
				document.getElementById('LabelAvis').hidden=true;
			}
			else{
				document.getElementById('CommentaireManque').hidden=false;
				document.getElementById('LabelAvis').hidden=false;
			}
			
		}
		
		function accueilCondition(){
			if(document.getElementById('AccueilSousCondition').checked==true){
				document.getElementById('Precaution').hidden=false;
				document.getElementById('LabelAccueilSousCondition').hidden=false;
			}
			else{
				document.getElementById('Precaution').hidden=true;
				document.getElementById('LabelAccueilSousCondition').hidden=true;
			}
			
		}
		
		
		
		$(document).ready(function(e) {
                verifyAll();
           });
		   
		function verifyAll(){
			stagiaireRencontre();
			tailleEquipe();
			autreObjet();
			avisEntreprise();
			accueilCondition();
		}
	</script>
    
    
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