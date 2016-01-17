<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On ajoute la disponibilité
	if(isset($_SESSION['membre']) && isset($_GET['date']) && isset($_GET['debut']) && isset($_GET['fin'])){
						
		$membre=$_SESSION['membre'];
		$date=$_GET['date'];
		$debut=$_GET['debut'];
		$fin=$_GET['fin'];
	
		//On vérifie si elle empiète sur une autre soutenance
		$resultat = mysqli_query($co,  "SELECT num_dispo
											FROM disponibilite
											WHERE login_dispo='$membre->login'
											AND (STR_TO_DATE('$date', '%Y-%m-%d')=date)
											AND (($debut>=heure_debut AND $debut<heure_fin) OR ($fin>heure_debut AND $fin<=heure_fin))");
		
		$valide= (mysqli_num_rows($resultat)==0 ? true : false);
		
		if($valide){
			mysqli_query($co,  "INSERT INTO disponibilite(login_dispo,date,heure_debut,heure_fin)
								VALUES('$membre->login', STR_TO_DATE('$date', '%Y-%m-%d'), $debut, $fin)");	
								
		}
		
		//On redirige vers la liste des disponibilités
		header("Location: ../../vues/enseignant/page_mes_dispo.php?added=".$valide);
		
	}
	
	
?>