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

	$delete_item_menu = $_POST['delete_id_item_menu'];

	if ($delete_item_menu == "") {
		die();
	}

	$sql1 = "SELECT * FROM Pedido ";
	$sql1.= "WHERE id_item_menu = $delete_item_menu";

	$resultado_sql1 = mysqli_query($link, $sql1);

	$numero_itens = mysqli_num_rows($resultado_sql1);
	
	//echo $numero_itens;


	if ($numero_itens == 0) {

		$sql2 = "DELETE FROM Item_menuXIngrediente ";
		$sql2.= "WHERE id_item_menu = '$delete_item_menu'";

		$sql3 = "DELETE FROM Item_menu ";
		$sql3.= "WHERE id_item_menu = '$delete_item_menu'";

		if ( !mysqli_query($link, $sql2) ) {
	    	echo "Falha ao excluir o Item " . $delete_item_menu . " do menu. ";
	    }	

		if ( mysqli_query($link, $sql3) ) {
	    	echo "Item " . $delete_item_menu . " excluído.";
	    } else {
	    	echo "Falha ao excluir o Item " . $delete_item_menu . " do menu. ";
	    }

	} else {
		echo "Existem pedidos atrelados a este registro ";
	}
	


?>
