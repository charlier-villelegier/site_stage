<?php	
	include("../modeles/membre.php");
	
		
	session_start();
	if(isset($_SESSION['membre'])){
		$membre=$_SESSION['membre'];
		$membre->deconnexion();
	}
			
	header('Location: ../index.html'); 	
	
	
?>
		