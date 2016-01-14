<?php
	include("bd.php");
	class Membre {
		
		public $login;
		public $mdp;
		public $nom;
		public $prenom;
		private $fonction;
		
		function __construct(){
			
			$bd = new Bd("site_stage");
			$co = $bd->connexion();
         	$this->login=func_get_arg(0);
			$this->mdp=func_get_arg(1);
			$this->fonction=func_get_arg(2);
			
			switch($this->fonction){
				case "etudiant":
					$resultat = mysqli_query($co, "SELECT nom,prenom FROM etudiant WHERE login='$this->login' AND mdp='$this->mdp'");
					break;
							
				case "enseignant":
					$resultat = mysqli_query($co, "SELECT nom,prenom FROM enseignant WHERE login='$this->login' AND mdp='$this->mdp'");
					break;
							
				case "tuteur":
					$resultat = mysqli_query($co, "SELECT nom,prenom FROM tuteur_entreprise WHERE login='$this->login' AND mdp='$this->mdp'");
					break;
							
			}
			$row = mysqli_fetch_row($resultat);
			$this->nom=$row[0];
			$this->prenom=$row[1];
			
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