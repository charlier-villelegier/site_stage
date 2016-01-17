<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On enlève l'association l'élève et l'étudiant
	if(isset($_SESSION['membre']) && isset($_GET['date']) && isset($_GET['debut']) && isset($_GET['fin'])){
		
		$membre=$_SESSION['membre'];
		$date=$_GET['date'];
		$debut=$_GET['debut'];
		$fin=$_GET['fin'];
		echo $date;
		
		mysqli_query($co,  "DELETE FROM disponibilite
							WHERE login_dispo='$membre->login'
							AND date=STR_TO_DATE('$date', '%d-%m-%Y')
							AND heure_debut=$debut
							AND heure_fin=$fin");	
																
	}
	
	
	header("Location: ../../vues/tuteur/page_mes_dispo.php?deleted=true");
?>