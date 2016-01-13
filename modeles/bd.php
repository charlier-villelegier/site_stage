<?php
	class Bd {
		
		private $bdd;
		private $host = "localhost";
		private $user = "root";
		private $passwd = "";
		private $co;
		
		function __construct($bdd){
			$this->bdd = $bdd;
		}
	
		public function connexion() {
			$this->co = mysqli_connect($this->host , $this->user , $this->passwd, $this->bdd) or die("erreur de connexion");
			return($this->co);
		} 
		
		public function deconnexion() {
			mysqli_close();
		}
	}
	
?>