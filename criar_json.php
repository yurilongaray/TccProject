<?php 
	

    session_start(); //Sempre que criarmos uma sessão, devemos iniciar ela para utilizar as variáveis de sessão
    
	require_once("db_class.php");

	$objDb	= new db();
	$link	= $objDb->connect_db();

	// Seleciona todos os registros da tabela:
	$result = mysqli_query($link, "SELECT * FROM Item_menu");

	// Retorna todos os registros:
	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

	// Escreve o resultado JSON em arquivo:
	file_put_contents("item_menu.json", json_encode($data));

?>