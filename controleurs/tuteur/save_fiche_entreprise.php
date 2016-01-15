<?php	
	include("../../modeles/membre.php");
	
	session_start();
	
	$membre=$_SESSION['membre'];
	$bd = new Bd("site_stage");
	$co = $bd->connexion();
	
	//Tuteur
	if(isset($_POST['NomResponsableStage']) && isset($_POST['PrenomResponsableStage'])){
		$nom=$_POST['NomResponsableStage'];
		$prenom=$_POST['PrenomResponsableStage'];
		
		mysqli_query($co,  "UPDATE tuteur_entreprise
							SET nom='$nom', prenom='$prenom'
							WHERE login='$membre->login' AND mdp='$membre->mdp'");	
	}
	
	//On vérifie s'il a déjà une fiche_tuteur dans la base de données
	$resultat = mysqli_query($co,  "SELECT sa_fiche_tuteur
									FROM etudiant E, appariement_tuteur A, tuteur_entreprise T
									WHERE T.login='$membre->login' AND T.mdp='$membre->mdp'
									AND A.tuteur=T.login
									AND E.login=A.etudiant");
	$row = mysqli_fetch_row($resultat);
	$num_fiche_tuteur=$row[0];
	//S'il n'en a pas on en créer une et on lui associe
	if($num_fiche_tuteur==0){
		mysqli_query($co,  "INSERT INTO fiche_tuteur VALUES()");
		$resultat=mysqli_query($co,  "SELECT MAX(num_fiche) FROM fiche_tuteur");
		$row = mysqli_fetch_row($resultat);
		$num_fiche_tuteur=$row[0];
		mysqli_query($co,  "UPDATE etudiant SET sa_fiche_tuteur=$num_fiche_tuteur WHERE login='$membre->login' AND mdp='$membre->mdp'");
	}
	
	echo "c'est good";
?>