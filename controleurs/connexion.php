<?php	
	include("../modeles/membre.php");
	
	$bd = new Bd('site_stage');
	$co=$bd->connexion();
	
	
	if(isset($_POST ['login']) && isset($_POST ['mdp'])){
		$login = $_POST ['login'];
		$mdp = $_POST ['mdp'];
		
		//On test si c'est un étudiant on enseignant ou un tuteur
		$resultat = mysqli_query($co, "SELECT login FROM etudiant WHERE login='$login' AND mdp='$mdp'");
		if(mysqli_num_rows($resultat)>0){
			$function="etudiant";
			header('Location: ../vues/etudiant/accueil.php'); 
		}
		else{
			$resultat = mysqli_query($co, "SELECT login FROM enseignant WHERE login='$login' AND mdp='$mdp'");
			if(mysqli_num_rows($resultat)>0){
				$function="enseignant";
				header('Location: ../vues/enseignant/accueil.php');
			}
			else{
				$resultat = mysqli_query($co, "SELECT login FROM tuteur_entreprise WHERE login='$login' AND mdp='$mdp'");
				if(mysqli_num_rows($resultat)>0){
					$function="tuteur";
					header('Location: ../vues/tuteur/accueil.php');
				}
				else{
					$resultat = mysqli_query($co, "SELECT login FROM secretariat WHERE login='$login' AND mdp='$mdp'");
					if(mysqli_num_rows($resultat)>0){
						$function="secretariat";
						header('Location: ../vues/secretariat/accueil.php');
					}
					else{
						header('Location: ../index.html'); 
					}
				}
			}
		}
		
		//Une fois trouvé, on créer le nouveau membre. On le stock en variable de session
		$membre = new Membre($_POST ['login'],$_POST ['mdp'], $function);
		$membre->connexion();

		$_SESSION['membre']=$membre;
		
	}
	
	
?>
		