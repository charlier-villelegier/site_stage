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
		$resultat = mysqli_query($co,  "SELECT num_jury
										FROM appariement_tuteur A, etudiant E, fiche_tuteur F
										WHERE A.etudiant = E.login
										AND F.num_fiche = E.sa_fiche_tuteur
										AND tuteur='$membre->login'");
										
		$row = mysqli_fetch_row($resultat);
		$num_jury = $row[0];
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
                    	Statut : Tuteur
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
						<li><a href="page_fiche_entreprise.html" class="PageActive">Mes fiches</a></li>
						<li><a href="#">Disponibilités</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">FICHE D'APPRECIATION DU STAGIAIRE</div>
					<form method="post" action="faille.php">
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
							
						<label for="ResponsableStage"> Responsable du stage : </label>
							<input type="text" name="ResponsableStage" value="<?php echo $prenom_tuteur." ".$nom_tuteur?>"/>
					
						<h3>APPRÉCIATIONS SUR LE STAGIAIRE : </h3>
						
						<TABLE BORDER>
			
							<TR>
								<td name="methodeTitre"> <label for="methodeTitre"> METHODE DE TRAVAIL ET APTITUDES </label> </td>
								<td name="excellentTitre"> <label for="excellentTitre"> EXCELLENT </label> </td>
								<td name="bonTitre"> <label for="bonTitre"> BON </label> </td>
								<td name="moyenTitre"> <label for="moyenTitre"> MOYEN </label> </TD>
								<td name="insuffisantTitre"> <label for="insuffisantTitre"> INSUFFISANT </label> </td>
							</TR>
							
							<TR>
								<TD name="niveauConnaisanceTitre"> <label for="niveauConnaisanceTitre">  NIVEAU DE CONNAISSANCE </label> </TD>
								<TD> <input type="radio" name="niveauConnaisance" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="niveauConnaisance" value="Bon"/> </TD>
								<TD> <input type="radio" name="niveauConnaisance" value="Moyen"/> </TD>
								<TD> <input type="radio" name="niveauConnaisance" value="Insuffisant"/></TD>
							</TR>
							
							<TR>
								<TD name="organisationTitre"> <label for="organisationTitre">  ORGANISATION </label> </TD>
								<TD> <input type="radio" name="organisation" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="organisation" value="Bon"/> </TD>
								<TD> <input type="radio" name="organisation" value="Moyen"/> </TD>
								<TD> <input type="radio" name="organisation" value="Insuffisant"/></TD>
							</TR>
							
							<TR>
								<TD name="initiativeTitre"> <label for="initiativeTitre"> INITIATIVE </label> </TD>
								<TD> <input type="radio" name="initiative" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="initiative" value="Bon"/> </TD>
								<TD> <input type="radio" name="initiative" value="Moyen"/> </TD>
								<TD> <input type="radio" name="initiative" value="Insuffisant"/></TD>
							</TR>
							
							<TR>
								<TD name="perseveranceTitre"> <label for="perseveranceTitre"> PERSÉVÉRANCE </label> </TD>
								<TD> <input type="radio" name="perseverance" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="perseverance" value="Bon"/> </TD>
								<TD> <input type="radio" name="perseverance" value="Moyen"/> </TD>
								<TD> <input type="radio" name="perseverance" value="Insuffisant"/></TD>
							</TR>
							
							<TR>
								<TD name="efficaciteTitre"> <label for="efficaciteTitre">  EFFICACITÉ </label> </TD>
								<TD> <input type="radio" name="efficacite" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="efficacite" value="Bon"/> </TD>
								<TD> <input type="radio" name="efficacite" value="Moyen"/> </TD>
								<TD> <input type="radio" name="efficacite" value="Insuffisant"/></TD>
							</TR>
							
							<TR>
								<TD name="interetTitre"> <label for="interetTitre"> INTÉRÊT PORTÉ AU TRAVAIL </label> </TD>
								<TD> <input type="radio" name="interet" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="interet" value="Bon"/> </TD>
								<TD> <input type="radio" name="interet" value="Moyen"/> </TD>
								<TD> <input type="radio" name="interet" value="Insuffisant"/></TD>
							</TR>
							
						</TABLE>
						</br>
						
						
						
						<TABLE BORDER>
							
							<TR>
								<td name="comportementTitre"> <label for="comportementTitre"> COMPORTEMENT GENERAL </label> </td>
								<td name="excellentTitre"> <label for="excellentTitre"> EXCELLENT </label> </td>
								<td name="bonTitre"> <label for="bonTitre"> BON </label> </td>
								<td name="moyenTitre"> <label for="moyenTitre">  MOYEN </label> </TD>
								<td name="insuffisantTitre"> <label for="insuffisantTitre"> INSUFFISANT </label> </td>
							</TR>
								
							<TR>
								<TD name="presentationTitre"> <label for="presentationTitre"> PRÉSENTATION</label> </TD>
								<TD> <input type="radio" name="presentation" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="presentation" value="Bon"/> </TD>
								<TD> <input type="radio" name="presentation" value="Moyen"/> </TD>
								<TD> <input type="radio" name="presentation" value="Insuffisant"/></TD>
							</TR>
								
							<TR>
								<TD name ="ponctualiteTitre"> <label for="ponctualiteTitre"> PONCTUALITÉ </label> </TD>
								<TD> <input type="radio" name="ponctualite" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="ponctualite" value="Bon"/> </TD>
								<TD> <input type="radio" name="ponctualite" value="Moyen"/> </TD>
								<TD> <input type="radio" name="ponctualite" value="Insuffisant"/></TD>
							</TR>
								
							<TR>
								<TD name="assiduiteTitre"> <label for="assiduiteTitre"> ASSIDUITÉ </label> </TD>
								<TD> <input type="radio" name="assiduite" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="assiduite" value="Bon"/> </TD>
								<TD> <input type="radio" name="assiduite" value="Moyen"/> </TD>
								<TD> <input type="radio" name="assiduite" value="Insuffisant"/></TD>
							</TR>
								
							<TR>
								<TD name="expressionTitre"> <label for="expressionTitre"> EXPRESSION </label> </TD>
								<TD> <input type="radio" name="expression" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="expression" value="Bon"/> </TD>
								<TD> <input type="radio" name="expression" value="Moyen"/> </TD>
								<TD> <input type="radio" name="expression" value="Insuffisant"/></TD>
							</TR>
								
							<TR>
								<TD name ="sociabiliteTitre"> <label for="sociabiliteTitre">  SOCIABILITÉ </label> </TD>
								<TD> <input type="radio" name="sociabilite" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="sociabilite" value="Bon"/> </TD>
								<TD> <input type="radio" name="sociabilite" value="Moyen"/> </TD>
								<TD> <input type="radio" name="sociabilite" value="Insuffisant"/></TD>
							</TR>
								
							<TR>
								<TD name="communicationTitre"> <label for="communicationTitre"> COMMUNICATION </label> </TD>
								<TD> <input type="radio" name="communication" value="Excellent"/>   </TD>
								<TD> <input type="radio" name="communication" value="Bon"/> </TD>
								<TD> <input type="radio" name="communication" value="Moyen"/> </TD>
								<TD> <input type="radio" name="communication" value="Insuffisant"/></TD>
							</TR>
						</TABLE> 
						
						
						<h3>CONTACTS DANS L’ENTREPRISE :</h3>						
						<TABLE BORDER>
							
							<TR>
								<TD></TD>
								<TD name="nomTitre"> <label for="nomTitre"> NOM </label> </TD>
								<TD name="mailTitre"> <label for="mailTitre"> E-mail</label> </TD>
								<TD name="telephoneTitre> <label for="telephoneTitre"> Téléphone(s) </label> </TD>
							</TR>
							
							<TR>
								<TD name="contactTitre"> <label for="contactTitre"> Contact RH  </label> </TD>
								<TD> <input type="text" name="nomContactRH"/>  </TD>
								<TD> <input type="text" name="mailContactRH"/> </TD>
								<TD> <input type="text" name="telContactRH"/> </TD>
							</TR>
							
							<TR>
								<TD name="contactTextTitre"> <label for="contactTextTitre"> Contact Taxe d’Apprentissage </label> </TD>
								<TD> <input type="text" name="nomContactTaxe"/>  </TD>
								<TD> <input type="text" name="mailContactTaxe"/> </TD>
								<TD> <input type="text" name="telContactTaxe"/> </TD>
							</TR>
							
							<TR>
								<TD name="contactRelationTitre"> <label for="contactRelationTitre"> Contact Relations Ecoles </label> </TD>
								<TD> <input type="text" name="nomContactEcole"/>  </TD>
								<TD> <input type="text" name="mailContactEcole"/> </TD>
								<TD> <input type="text" name="telContactEcole"/> </TD>
							</TR>
						</TABLE>
						
						<br/>
				
						<label for="projetProfessionel"> 	Embaucheriez-vous le stagiaire si vous en aviez la possibilité ? (Ceci n'a pour but que
						d'apprécier les services que pourrait rendre le candidat dans une entreprise) .</label>	
						</br>
						<input type="radio" name="remarque" value="news"/> Oui
						<input type="radio" name="remarque" value="news"/> Peut-être
						<input type="radio" name="remarque" value="news"/> Non
						</br>
						</br>
						
						
						<label for="experience"> Pour quelles raisons ?</label> </br>
						<textarea name="projetProfessionel" id="projetProfessionel" rows="10" cols="50"> </textarea></br>
						</br>
						
						<label for="projetProfessionel"> Seriez-vous présent lors de la soutenance de votre stagiaire ou un autre représentant de l’entreprise ?</label>	
						<input type="radio" name="remarque" value="news"/> Oui
						<input type="radio" name="remarque" value="news"/> Non
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