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
					
				case "secretariat":
					$resultat = mysqli_query($co, "SELECT nom,prenom FROM secretariat WHERE login='$this->login' AND mdp='$this->mdp'");
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
			
			$bd = new Bd("site_stage");
			$co = $bd->connexion();
			
			$this->mdp=$mdp;
			
			switch($this->fonction){
				case "etudiant":
					$resultat=mysqli_query($co, "UPDATE etudiant SET mdp='$this->mdp' WHERE login='$this->login'");	
					break;
							
				case "enseignant":
					$resultat=mysqli_query($co, "UPDATE enseignant SET mdp='$this->mdp' WHERE login='$this->login'");	
					break;
							
				case "tuteur":
					$resultat=mysqli_query($co, "UPDATE tuteur_entreprise SET mdp='$this->mdp' WHERE login='$this->login'");	
					break;
					
				case "secretariat":
					$resultat=mysqli_query($co, "UPDATE secretariat SET mdp='$this->mdp' WHERE login='$this->login'");	
					break;
							
			}
			
		}
		
		public function maj(){
			$bd = new Bd("site_stage");
			$co = $bd->connexion();
			
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
		
		public function deconnexion() {
			session_destroy();
		} 
	}
	
?>