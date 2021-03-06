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
		
		//Stagiaire
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
		
		//Tuteur
		$resultat = mysqli_query($co,  "SELECT prenom, nom
										FROM tuteur_entreprise
										WHERE login='$membre->login'");
		$row = mysqli_fetch_row($resultat);
		$prenom_tuteur = $row[0];
		$nom_tuteur = $row[1];
		
		//Fiche
		$resultat = mysqli_query($co,  "SELECT num_jury, niveau_connaissance, organisation, initiative, 
										perseverance, efficacite, interet_travail, presentation, ponctualite, assiduite, 
										expression, sociabilite, communication
										FROM appariement_tuteur A, etudiant E, fiche_tuteur F
										WHERE A.etudiant = E.login
										AND F.num_fiche = E.sa_fiche_tuteur
										AND tuteur='$membre->login'");
										
		$row = mysqli_fetch_row($resultat);
		$num_jury = $row[0];
		$niveau_connaissance = $row[1];
		$organisation = $row[2];
		$initiative = $row[3];
		$perseverance = $row[4];
		$efficacite = $row[5];
		$interet_travail = $row[6];
		$presentation = $row[7];
		$ponctualite = $row[8];
		$assiduite = $row[9];
		$expression = $row[10];
		$sociabilite = $row[11];
		$communication = $row[12];
		
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
		
		//Embaucheriez et soutenance
		$resultat = mysqli_query($co,  "SELECT embauche, raison_embauche, presence_soutenance
										FROM appariement_tuteur A, etudiant E, fiche_tuteur F
										WHERE A.etudiant = E.login
										AND F.num_fiche = E.sa_fiche_tuteur
										AND tuteur='$membre->login'");				
		$row = mysqli_fetch_row($resultat);
		$embauche = $row[0];
		$raison_embauche = $row[1];
		$presence_soutenance = $row[2];
		
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
						<li><a href="accueil.php">Accueil</a></li>
						<li><a href="page_fiche_entreprise.php" class="PageActive">Mes fiches</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
						<li><a href="page_contact.php">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">FICHE D'APPRECIATION DU STAGIAIRE</div>
					<form method="post" action="../../controleurs/tuteur/save_fiche_entreprise.php">
					<p>
						<label for="NomEtudiant"> Nom du stagiaire : </label>
							<input type="text" name="nomEtudiant" value="<?php echo $prenom_etudiant." ".$nom_etudiant?>" disabled="disabled"/>
						<br/>
						<br/>
							
						<label for="NumJury"> Jury N° : </label>
							<input type="text" name="NumJury" value="<?php echo $num_jury?>"/>
							
						<label for="entrepriseRaisonSociale"> Entreprise (raison sociale) : </label>
							<input type="text" name="entrepriseRaisonSociale" value="<?php echo $nom_entreprise?>"/>
						<br/>
						<br/>
							
						<label for="PrenomResponsableStage">Prénom du responsable du stage : </label>
							<input type="text" name="PrenomResponsableStage" value="<?php echo $prenom_tuteur?>"/>
						<br/>
						<br/>
						
						<label for="NomResponsableStage">Nom du responsable du stage : </label>
							<input type="text" name="NomResponsableStage" value="<?php echo $nom_tuteur?>"/>
					
						<h3>APPRÉCIATIONS SUR LE STAGIAIRE : </h3>
						
						<TABLE class="tab"  width="100%" cellpadding=\"10\">
			
							<TR>
								<th name="methodeTitre"> <label for="methodeTitre"><font color="white"> METHODE DE TRAVAIL ET APTITUDES </font></label> </th>
								<th name="excellentTitre"> <label for="excellentTitre"><font color="white"> Excellent </font></label> </th>
								<th name="bonTitre"> <label for="bonTitre"><font color="white"> Bon </font></label> </th>
								<th name="moyenTitre"> <label for="moyenTitre"><font color="white"> Moyen </font></label> </th>
								<th name="insuffisantTitre"> <label for="insuffisantTitre"><font color="white"> Insuffisant </font></label> </th>
							</TR>
							
							<TR>
								<th name="niveauConnaisanceTitre"> <label for="niveauConnaisanceTitre"><font color="white">  Niveau de connaissance </font></label> </th>
								<TD align="center"> <input type="radio" name="niveauConnaisance" value="Excellent" <?php if($niveau_connaissance == "Excellent")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="niveauConnaisance" value="Bon" <?php if($niveau_connaissance == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="niveauConnaisance" value="Moyen" <?php if($niveau_connaissance == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="niveauConnaisance" value="Insuffisant" <?php if($niveau_connaissance =="Insuffisant")echo "checked=\"checked\"" ?>/> </TD>
							</TR>
							
							<TR>
								<th name="organisationTitre"> <label for="organisationTitre"><font color="white">  Organisation </font></label> </th>
								<TD align="center"> <input type="radio" name="organisation" value="Excellent" <?php if($organisation == "Excellent")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="organisation" value="Bon" <?php if($organisation == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="organisation" value="Moyen" <?php if($organisation == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="organisation" value="Insuffisant" <?php if($organisation == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
							
							<TR>
								<th name="initiativeTitre"> <label for="initiativeTitre"><font color="white"> Initiative </font></label> </th>
								<TD align="center"> <input type="radio" name="initiative" value="Excellent" <?php if($initiative == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="initiative" value="Bon" <?php if($initiative == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center" > <input type="radio" name="initiative" value="Moyen" <?php if($initiative == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="initiative" value="Insuffisant" <?php if($initiative == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
							
							<TR>
								<th name="perseveranceTitre"> <label for="perseveranceTitre"><font color="white"> Persévérence </font></label> </th>
								<TD align="center"> <input type="radio" name="perseverance" value="Excellent" <?php if($perseverance == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="perseverance" value="Bon" <?php if($perseverance == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="perseverance" value="Moyen" <?php if($perseverance == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="perseverance" value="Insuffisant" <?php if($perseverance == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
							
							<TR>
								<th name="efficaciteTitre"> <label for="efficaciteTitre"><font color="white">  Efficacité </font></label> </th>
								<TD align="center"> <input type="radio" name="efficacite" value="Excellent" <?php if($efficacite == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="efficacite" value="Bon" <?php if($efficacite == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="efficacite" value="Moyen" <?php if($efficacite == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="efficacite" value="Insuffisant" <?php if($efficacite == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
							
							<TR>
								<th name="interetTitre"> <label for="interetTitre"><font color="white"> Intérêt porté au travail </font></label> </th>
								<TD align="center"> <input type="radio" name="interet" value="Excellent" <?php if($interet_travail == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="interet" value="Bon" <?php if($interet_travail == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="interet" value="Moyen" <?php if($interet_travail == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="interet" value="Insuffisant" <?php if($interet_travail == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
							
						</TABLE>
						</br>
						
						
						
						<TABLE class="tab"  width="100%" cellpadding=\"10\">
							
							<TR>
								<th name="comportementTitre"> <label for="comportementTitre"><font color="white"> Comportement général </font></label> </th>
								<th name="excellentTitre"> <label for="excellentTitre"><font color="white"> Excellent </font></label> </th>
								<th name="bonTitre"> <label for="bonTitre"><font color="white"> Bon </font></label> </th>
								<th name="moyenTitre"> <label for="moyenTitre"><font color="white">  Moyen </font></label> </th>
								<th name="insuffisantTitre"> <label for="insuffisantTitre"><font color="white"> Insuffisant </font></label> </th>
							</TR>
								
							<TR>
								<th name="presentationTitre"> <label for="presentationTitre"><font color="white"> Présentation </font></label> </th>
								<TD align="center"> <input type="radio" name="presentation" value="Excellent" <?php if($presentation == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="presentation" value="Bon" <?php if($presentation == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="presentation" value="Moyen" <?php if($presentation == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="presentation" value="Insuffisant" <?php if($presentation == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
								
							<TR>
								<th name ="ponctualiteTitre"> <label for="ponctualiteTitre"><font color="white"> Ponctualité </font></label> </th>
								<TD align="center"> <input type="radio" name="ponctualite" value="Excellent" <?php if($ponctualite == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="ponctualite" value="Bon" <?php if($ponctualite == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="ponctualite" value="Moyen" <?php if($ponctualite == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="ponctualite" value="Insuffisant" <?php if($ponctualite == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
								
							<TR>
								<th name="assiduiteTitre"> <label for="assiduiteTitre"><font color="white"> Assiduité </font></label> </th>
								<TD align="center"> <input type="radio" name="assiduite" value="Excellent" <?php if($assiduite == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="assiduite" value="Bon" <?php if($assiduite == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="assiduite" value="Moyen" <?php if($assiduite == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="assiduite" value="Insuffisant" <?php if($assiduite == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
								
							<TR>
								<th name="expressionTitre"> <label for="expressionTitre"><font color="white"> Expression </font></label> </th>
								<TD align="center"> <input type="radio" name="expression" value="Excellent" <?php if($expression == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="expression" value="Bon" <?php if($expression == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="expression" value="Moyen" <?php if($expression == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="expression" value="Insuffisant" <?php if($expression == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
								
							<TR>
								<th name ="sociabiliteTitre"> <label for="sociabiliteTitre"><font color="white">  Sociabilité </font></label> </th>
								<TD align="center"> <input type="radio" name="sociabilite" value="Excellent" <?php if($sociabilite == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="sociabilite" value="Bon" <?php if($sociabilite == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="sociabilite" value="Moyen" <?php if($sociabilite == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="sociabilite" value="Insuffisant" <?php if($sociabilite == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
								
							<TR>
								<th name="communicationTitre"> <label for="communicationTitre"><font color="white"> Communication </font></label> </th>
								<TD align="center"> <input type="radio" name="communication" value="Excellent" <?php if($communication == "Excellent")echo "checked=\"checked\"" ?>/>   </TD>
								<TD align="center"> <input type="radio" name="communication" value="Bon" <?php if($communication == "Bon")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="communication" value="Moyen" <?php if($communication == "Moyen")echo "checked=\"checked\"" ?>/> </TD>
								<TD align="center"> <input type="radio" name="communication" value="Insuffisant" <?php if($communication == "Insuffisant")echo "checked=\"checked\"" ?>/></TD>
							</TR>
						</TABLE> 
						
						
						<h3>CONTACTS DANS L’ENTREPRISE :</h3>						
						<TABLE class="tab"  width="100%" cellpadding=\"10\">
							
							<TR>
								<td></td>
								<th name="nomTitre"> <label for="nomTitre"><font color="white"> Nom </font></label> </th>
								<th name="mailTitre"> <label for="mailTitre"><font color="white"> E-mail</font></label> </th>
								<th name="telephoneTitre"> <label for="telephoneTitre"><font color="white"> Téléphone(s)</font> </label> </th>
							</TR>
							
							<TR>
								<th name="contactTitre"> <label for="contactTitre"><font color="white"> Contact RH </font> </label> </th>
								<TD> <input type="text" name="nomContactRH" value="<?php echo $nom_rh?>"/>  </TD>
								<TD> <input type="text" name="mailContactRH" value="<?php echo $mail_rh?>"/> </TD>
								<TD> <input type="text" name="telContactRH" value="<?php echo $telephone_rh?>"/> </TD>
							</TR>
							
							<TR>
								<th name="contactTextTitre"> <label for="contactTextTitre"><font color="white"> Contact Taxe d’Apprentissage </font></label> </th>
								<TD> <input type="text" name="nomContactTaxe" value="<?php echo $nom_taxe?>"/> </TD>
								<TD> <input type="text" name="mailContactTaxe" value="<?php echo $mail_taxe?>"/> </TD>
								<TD> <input type="text" name="telContactTaxe" value="<?php echo $telephone_taxe?>"/> </TD>
							</TR>
							
							<TR>
								<th name="contactRelationTitre"> <label for="contactRelationTitre"><font color="white"> Contact Relations Ecoles </label> </th>
								<TD> <input type="text" name="nomContactEcole" value="<?php echo $nom_relation?>"/> </TD>
								<TD> <input type="text" name="mailContactEcole" value="<?php echo $mail_relation?>"/> </TD>
								<TD> <input type="text" name="telContactEcole" value="<?php echo $telephone_relation?>"/> </TD>
							</TR>
						</TABLE>
						
						<br/>
				
						<label for="projetProfessionel"> 	Embaucheriez-vous le stagiaire si vous en aviez la possibilité ? (Ceci n'a pour but que
						d'apprécier les services que pourrait rendre le candidat dans une entreprise.)</label>	
						</br>
						<input type="radio" name="embauche" value="Oui" <?php if($embauche == "Oui")echo "checked=\"checked\"" ?>/> Oui
						<input type="radio" name="embauche" value="Peut-être" <?php if($embauche == "Peut-être")echo "checked=\"checked\"" ?>/> Peut-être
						<input type="radio" name="embauche" value="Non" <?php if($embauche == "Non")echo "checked=\"checked\"" ?>/> Non
						</br>
						</br>
						
						
						<label for="experience"> Pour quelles raisons ?</label> </br>
						<textarea name="raisonEmbauche" rows="10" cols="50"><?php echo $raison_embauche ?></textarea></br>
						</br>
						
						<label for="projetProfessionel"> Seriez-vous présent lors de la soutenance de votre stagiaire ou un autre représentant de l’entreprise ?</label>	
						<input type="radio" name="PresenceSoutenance" value="Present"  <?php if($presence_soutenance)echo "checked=\"checked\"" ?>/> Oui
						<input type="radio" name="PresenceSoutenance" value="Absent" <?php if(!$presence_soutenance)echo "checked=\"checked\"" ?>/> Non
						</br>
						
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