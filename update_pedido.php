<?php 
	

    session_start(); //Sempre que criarmos uma sessão, devemos iniciar ela para utilizar as variáveis de sessão
    
	require_once("db_class.php");

	$objDb	= new db();
	$link	= $objDb->connect_db();


	if( !isset($_SESSION['id_usuario']) ){
		header('Location: login.php?erro=1');
	} elseif ( !isset($_SESSION['id_estabelecimento'])) {
		header('Location: login.php?id_estabelecimento=null');
	}


	$novo_status = $_POST['alterar_status'];
	$id_pedido	 = $_POST['update_id_pedido'];


	if ( ($novo_status == "") || ($id_pedido == "") ) {
		die();
	}

	$sql = " UPDATE Pedido ";
	$sql.= " SET id_status_pedido = '$novo_status'";
	$sql.= " WHERE id_pedido = '$id_pedido'";

	echo $sql;

	if ( mysqli_query($link, $sql) ) {
    	echo "Status do Pedido " . $id_pedido . " alterado para " . $novo_status . "";
    } else {
    	echo "Falha ao alterar o Status do Pedido";
    }


?>
