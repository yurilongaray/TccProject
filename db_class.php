<?php 

	class db {

		private $host		= "localhost";
		private $user_db	= "root";
		private $password 	= "123456";
		private $db_name	= "TCC";

		public $conn;

		//Criando conexão com MYSQLI
		public function connect_db() {
			$this->conn = mysqli_connect($this->host, $this->user_db, $this->password, $this->db_name);

			//Ajustando o charset de comunicação entre a aplicação e o banco de dados
			mysqli_set_charset($this->conn, "utf8");

			if (!$this->conn) {
				die("Falha de conexão " . mysqli_connect_error());
			}

			return $this->conn;
		}

	}

?>