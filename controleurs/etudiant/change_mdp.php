<?php	
	include("../../modeles/membre.php");
	
	session_start();
	$membre=$_SESSION['membre'];
	
	if(empty($_POST['AncienMdp']) || empty($_POST['NouveauMdp']) || empty($_POST['NouveauMdpConfirm'])){
		//On redirige vers la page
		header("Location: ../../vues/etudiant/change_mdp.php?fillall=true");
		
	}
	else if($_POST['AncienMdp']!=$membre->mdp){
		//On redirige vers la page
		header("Location: ../../vues/etudiant/change_mdp.php?badoldmdp=true");
	}
	else if($_POST['NouveauMdpConfirm']!=$_POST['NouveauMdp']){
		//On redirige vers la page
		header("Location: ../../vues/etudiant/change_mdp.php?notsame=true");
	}
	else{
		$membre->modif_mdpasse($_POST['NouveauMdp']);
		//On redirige vers la page
		header("Location: ../../vues/etudiant/change_mdp.php?success=true");
	}	
	
	
?>

 
		