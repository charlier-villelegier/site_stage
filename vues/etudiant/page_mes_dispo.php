<!--Si l'utilisateur accède a la page alors qu'il n'est pas connecté, on le redirige -->
<?php
	include("../../modeles/membre.php");
	session_start();
	if(!isset($_SESSION['membre'])){
		echo"pas de membre";
		header('Location: ../../index.html'); 
	}
	//J'ouvre la connexion pour plus tard
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
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
			
        </div>
    </div>
    <div class="menu">
		<div class="ConteneurHautPetit"></div>
		<div class="ConteneurPrincipalePetit">
			<div class="ConteneurPetitPlan">
				
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
						<li><a href="page_fiche_localisation.php">Mes fiches</a></li>
						<li><a href="page_mes_dispo.php" class="PageActive">Mes disponibilités</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">Vos disponibilités: </div>
                <p>Voici la liste de <b>vos disponibilités</b></p>
                <p>Renseignez les avec attention, elles seront prises en compte dans le choix final de la date de soutenance.</p>
                <?php
					//Je récupère et j'affiche la liste des disponibilités
					$resultat = mysqli_query($co,  "SELECT date, heure_debut, heure_fin
													FROM disponibilite
													WHERE login_dispo='$membre->login'");
													
					
					
					echo"<table border='1' width=\"100%\" cellpadding=\"10\">";
						echo"<tr>";
							echo"<td></td>";	
							echo"<td><b>DATE</b></td>";		
							echo"<td><b>DE</b></td>";
							echo"<td><b>A</b></td>";
						echo"</tr>";	
					if(mysqli_num_rows($resultat)>0){	
						$nb_dispo=0;						
						while($row = mysqli_fetch_row($resultat)){
							$nb_dispo+=1;
							$date= date("d-m-Y", strtotime($row[0]));
							$dateForInput=date("Y-m-d", strtotime($row[0]));
							$heure_debut=$row[1];
							$heure_fin=$row[2];
						
							echo"<tr>";
								echo"<td>$nb_dispo</td>";
								echo"<td>$date</td>";
								echo"<td>$heure_debut"."h"."</td>";
								echo"<td>$heure_fin"."h"."</td>";
								echo"<form>";
								?>
                                
                                <td><input type="button" value="Modifier" 
                                	onclick="generateModif('<?php echo $dateForInput?>','<?php echo $heure_debut ?>','<?php echo $heure_fin ?>')"/></td>
                                    
								<td><input type="button" value="Supprimer" 
                                	onclick="generate('<?php echo $date?>','<?php echo $heure_debut ?>','<?php echo $heure_fin ?>')"/></td>
                                
                                <?php
								echo"</form>";
							echo"</tr>";
						}
					}
					else{
						echo"<tr>";
							echo"<td colspan=\"3\" align=\"center\">Vous n'avez aucune disponibilité</td>";
						echo"</tr>";
					}
						
					echo"</table>";
					
				?>
                
                <p>Vous pouvez ajouter une disponibilité en appuyant sur le bouton ci dessous : <p><br/>
                <input type="button" value="Ajouter une disponibilité" 
                                	onclick="generateAdd()"/>
                
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
	
	//Ajout d'une disponibilité
	 function generateAdd() {
        var n = noty({
            text        : 'Ajouter une disponibilité le'
							+ '<input type="date" id="dateDispo"/> '
							+ 'de <input id="heureDebut" type="number" min="7" max="20" step="1" value="8"/>h '
							+ 'à <input id="heureFin" type="number" min="7" max="20" step="1" value="10"/>h ?',
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
                {addClass: 'btn btn-primary', text: 'Oui', onClick: function ($noty) {
                    var date=document.getElementById("dateDispo").value;
					
					if(date==""){
						wrong('Merci de choisir une date correcte');
					}
					else{
						var debut=document.getElementById("heureDebut").value;
						var fin=document.getElementById("heureFin").value;
						
						if(parseInt(debut)>=parseInt(fin)){
							wrong('Heures invalides');
						}
						else{
							$noty.close();
							document.location.href="../../controleurs/etudiant/add_dispo.php?date="+date+"&debut="+debut+"&fin="+fin;
						}
						
					}
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
	
	
	//Modification d'une disponibilité
	function generateModif(date, debut, fin) {
		
        var n = noty({
            text        : 'Modifier le <b>' + date + '</b> de <b>' + debut + 'h </b> à <b>' + fin + 'h </b> : '
							+ '<input type="date" id="dateDispo" value="'+date+'"/> '
							+ 'de <input id="heureDebut" type="number" min="7" max="20" step="1" value="'+debut+'"/>h '
							+ 'à <input id="heureFin" type="number" min="7" max="20" step="1" value="'+fin+'"/>h ?',
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
                {addClass: 'btn btn-primary', text: 'Oui', onClick: function ($noty) {
                    var newDate=document.getElementById("dateDispo").value;
					
					if(newDate==""){
						wrong('Merci de choisir une date correcte');
					}
					else{
						var newDebut=document.getElementById("heureDebut").value;
						var newFin=document.getElementById("heureFin").value;
						
						if(parseInt(newDebut)>=parseInt(newFin)){
							wrong('Heures invalides');
						}
						else{
							$noty.close();
							document.location.href="../../controleurs/etudiant/modif_dispo.php?date="+date+"&newDate="+newDate
							+"&debut="+debut+"&newDebut="+newDebut
							+"&fin="+fin+"&newFin="+newFin;
						}
						
					}
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
	
	
	function wrong(text) {

            var popup = noty({
                text        : text,
                type        : 'error',
                dismissQueue: true,
                layout      : 'center',
                theme       : 'relax',
                maxVisible  : 10,
                animation   : {
                    open  : 'animated flipInX',
                    close : 'animated flipOutX',
                    easing: 'swing',
                    speed : 1000
                }
            });
			
			setTimeout(function () {
           		popup.close();
        	}, 3000);
			
            console.log('html: ' + n.options.id);
        }
	
    function generate(date,heure_debut,heure_fin) {
        var n = noty({
            text        : 'Voulez vous vraiment supprimer la disponibilité du <b>' + date  + '</b> de <b>' + heure_debut + 'h</b> à <b>' + heure_fin +'h </b> ?',
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
                {addClass: 'btn btn-danger', text: 'Oui', onClick: function ($noty) {
                    $noty.close();
					document.location.href="../../controleurs/etudiant/delete_dispo.php?date="+date+"&debut="+heure_debut+"&fin="+heure_fin;
                    
                }
                },
                {addClass: 'btn btn-primary', text: 'Annuler', onClick: function ($noty) {
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
		
		 function generateDeleted() {
			
            generatePopup('success', '<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> La disponibilité à bien été supprimée </div> </div>');
			
		 }
		 
		 function generateAdded() {
			
            generatePopup('success', 
			'<div class=\"activity-item\"> <i class=\"fa fa-check text-success\"></i> <div class=\"activity\"> La disponibilité a bien été enregistrée </div> </div>');
		 }
		 
		 function generateFailed() {
			 
            generatePopup('error', '<div class=\"activity-item\"> <i class=\"fa fa-times text-error\"></i> <div class=\"activity\"> La disponibilité empiète sur une autre disponibilité </div> </div>');
			
		 }
	

</script>
	
	
    <!-- Affiche la popup de la dispo supprimée-->
    <?php
		if(isset($_GET['deleted'])){
			
		echo"
		 
   		 <script type=\"text/javascript\">

			 $(document).ready(function () {

            setTimeout(function() {
                generateDeleted();
            }, 200);
			
			setTimeout(function () {
           		$.noty.closeAll();
        	}, 3000);
		
        });

    	</script>
    ";
    }
    ?>
    
    
    
     <!-- Affiche la popup de la dispo ajoutée-->
    <?php
		if(isset($_GET['added'])){
			if($_GET['added']){
				echo"
		 
   		 		<script type=\"text/javascript\">

			 		$(document).ready(function () {

            			setTimeout(function() {
                			generateAdded();
           				 }, 200);
			
						setTimeout(function () {
           					$.noty.closeAll();
        				}, 3000);
		
        			});

    			</script>
   				 ";
			}
			else{
				echo"
		 
   		 		<script type=\"text/javascript\">

			 		$(document).ready(function () {

            			setTimeout(function() {
                			generateFailed();
           				 }, 200);
			
						setTimeout(function () {
           					$.noty.closeAll();
        				}, 3000);
		
        			});

    			</script>
   				 ";
			}
		
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