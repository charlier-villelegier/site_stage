<?php
include 'bd.php';
	class Membre {
		
		private $login;
		private $mdp;
		private $email;
		private $fonction;
		
		function __construct(){
			
			$bd = new Bd("site_stage");
			$co = $bd->connexion();
         	$this->login=func_get_arg(0);
			$this->mdpasse=func_get_arg(1);
			$this->fonction=func_get_arg(2);
					
			switch($this->fonction){
				case "etudiant":
					$resultat = mysqli_query($co, "SELECT mail FROM etudiant WHERE login='$this->login' AND mdp='$this->mdp'");
					break;
							
				case "enseignant":
					$resultat = mysqli_query($co, "SELECT mail FROM enseignant WHERE login='$this->login' AND mdp='$this->mdp'");
					break;
							
				case "tuteur":
					$resultat = mysqli_query($co, "SELECT mail FROM tuteur_entreprise WHERE login='$this->login' AND mdp='$this->mdp'");
					break;
							
			}
					
			$row = mysql_fetch_row($result);
			$this->email=$row['mail'];
		}
		
	
		public function connexion() {
			session_start();
		} 
		
		public function modif_mdpasse($mdp) {
			$this->mdp=$mdp;
			mysqli_query($co, "UPDATE membres SET mdpasse=$this->mdpasse WHERE id=$this->id");	
		}
		
		public function deconnexion() {
			session_destroy();
		} 
	}
	
?>