<?php 

	session_start();

	unset($_SESSION['id_usuario']);
	unset($_SESSION['usuario']);
	unset($_SESSION['usuarioNiveisAcessoId']);
	unset($_SESSION['email']);
	unset($_SESSION['senha']);
	unset($_SESSION['id_estabelecimento']);

	//Certificando que está fechando a sessão
	session_unset();
	mysqli_close();

	header('Location: login.php?logout');
?>
