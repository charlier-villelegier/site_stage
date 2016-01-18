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
    <style type="text/css">
		.tab  {border-collapse:collapse;border-spacing:0;}
		.tab td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tab th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal; background-color:#26ade4;}
	</style>
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
						<li><a href="page_mes_etudiants.php" >Gérer mes étudiants</a></li>
						<li><a href="page_etudiant_disponible.php" class="PageActive">Etudiants disponibles</a></li>
						<li><a href="page_mes_dispo.php">Mes disponibilités</a></li>
                        <li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
      
			<div class="ConteneurTexte">   
				<div class="TitrePartie" id="titre1">Etudiants sans professeur tuteur : </div>
                <p>Voici la liste des étudiants <b>qui n'ont pas encore de professeur tuteur.</b></p>
                <p>Pour demander à être tuteur d'un élève, vous pouvez appuyer sur "choisir" à côté de son nom.</p>
                <?php
				
					//Je vérifie si les session d'admissions sont ouvertes
					$resultat = mysqli_query($co,  "SELECT session_appariement
													FROM secretariat");
					$row=mysqli_fetch_row($resultat);
					$session_ouverte=$row[0];
					
					if($session_ouverte){
						//Je récupère et j'affiche la liste des étudiants sans tuteurs
						$resultat = mysqli_query($co,  "SELECT nom, prenom, tp, login
														FROM etudiant E
														WHERE E.login NOT IN (SELECT etudiant
																			  FROM appariement_enseignant)
														ORDER BY nom");
					
						echo"<table class=\"tab\" width=\"100%\" cellpadding=\"10\">";
							echo"<tr>";
								echo"<th><b><font color=\"white\">NOM</font></b></td>";	
								echo"<th><b><font color=\"white\">PRENOM</font></b></td>";		
								echo"<th><b><font color=\"white\">TP</font></b></td>";
							echo"</tr>";	
													
							while($row = mysqli_fetch_row($resultat)){
								$nom=$row[0];
								$prenom=$row[1];
								$tp=($row[2]==NULL? "Non renseigné" : $row[2]);
								$login=$row[3];
						
								echo"<tr>";
									echo"<td>$nom</td>";
									echo"<td>$prenom</td>";
									echo"<td>$tp</td>";
									echo"<form>";
									?>
									<td ><input style="width:100%" type="button" value="Choisir" onclick="generate('<?php echo $nom.' '.$prenom?>','<?php echo $login ?>')"/></td>
                                	<?php
									echo"</form>";
								echo"</tr>";
							}
						
						echo"</table>";
					}
					else{
						echo "<h3>Les appariements sont actuellement <b>fermés</b>. Veuillez revenir lors de la prochaine session d'appariement.</h2>";	
					}
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
    
    <script type="text/javascript" src="../../js/noty/packaged/jquery.noty.packaged.js"></script>
    <script type="text/javascript">

    function generate(name,login) {
        var n = noty({
            text        : 'Voulez vous vraiment être le tuteur de <b>' + name  + ' </b> ?',
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
                    $noty.close();
					document.location.href="../../controleurs/enseignant/add_etudiant.php?etudiant="+login
                    
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

</script>

	
    
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