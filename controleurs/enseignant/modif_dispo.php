<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	
	
	//On modifie la disponibilité
	if(isset($_SESSION['membre']) && isset($_GET['newDate']) && isset($_GET['newDebut']) && isset($_GET['newFin'])){
						
		$membre=$_SESSION['membre'];
		
		$newDate=$_GET['newDate'];
		$newDebut=$_GET['newDebut'];
		$newFin=$_GET['newFin'];
		
		$date=$_GET['date'];
		$debut=$_GET['debut'];
		$fin=$_GET['fin'];
		
		//On récupère le numéro de la disponibilité pour ne pas la prendre en compte après
		$resultat = mysqli_query($co,  "SELECT num_dispo
										FROM disponibilite
										WHERE date=STR_TO_DATE('$date', '%Y-%m-%d')
										AND heure_debut=$debut
										AND heure_fin=$fin
										AND login_dispo='$membre->login'");
									
		$row=mysqli_fetch_row($resultat);
		$num_dispo=$row[0];	
	
		//On vérifie si elle empiète sur une autre soutenance (sauf elle même)
		$resultat = mysqli_query($co,  "SELECT num_dispo
										FROM disponibilite
										WHERE login_dispo='$membre->login'
										AND (STR_TO_DATE('$newDate', '%Y-%m-%d')=date)
										AND (($newDebut>=heure_debut AND $newDebut<heure_fin) OR ($newFin>heure_debut AND $newFin<=heure_fin))
										AND num_dispo<>$num_dispo");
		
		$valide= (mysqli_num_rows($resultat)==0 ? true : false);
		
		if($valide){
			mysqli_query($co,  "UPDATE disponibilite
								SET date=STR_TO_DATE('$newDate', '%Y-%m-%d'),heure_debut=$newDebut, heure_fin=$newFin
								WHERE date=STR_TO_DATE('$date', '%Y-%m-%d')
								AND heure_debut=$debut
								AND heure_fin=$fin
								AND login_dispo='$membre->login'");	
								
		}
		
		//On redirige vers la liste des disponibilités
		header("Location: ../../vues/enseignant/page_mes_dispo.php?added=".$valide);
		
	}
	
	
?>