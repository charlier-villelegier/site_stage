<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On associe l'élève et l'étudiant
	if(isset($_SESSION['membre']) && isset($_GET['state'])){
		
		$membre=$_SESSION['membre'];
		$state=($_GET['state']=="open"? 1 : 0);
		
		echo $state;
		mysqli_query($co,  "UPDATE secretariat
							SET session_appariement=$state
							WHERE login='$membre->login'");	
								
	}
	
	//On redirige vers ses étudiants
	header("Location: ../../vues/secretariat/session_appariement.php?state=".$_GET['state']);
?>