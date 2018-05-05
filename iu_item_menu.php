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


	$id_estabelecimento		= $_SESSION['id_estabelecimento'];
	$id_item_menu 			= $_POST['id_item_menu'];
	$nome_item_menu			= $_POST['nome_item_menu'];
	$descricao_item_menu	= $_POST['descricao_item_menu'];
	$serve_qtd_pessoa		= $_POST['serve_qtd_pessoa'];
	$preco_item_menu		= $_POST['preco_item_menu'];
	$ingrediente_item_menu  = $_POST['ingrediente_item_menu'];


	//echo $ingrediente_item_menu;
	$lista_ingredientes = explode(",", $ingrediente_item_menu);
	//print_r($lista_ingredientes);
	

	//Validando imagem
	if( isset($_FILES['imagem_item_menu']) ) {

		$extensoes		= array(".jpeg", ".jpg", ".png");
		$extensao 		= strtolower(substr($_FILES['imagem_item_menu']['name'], -4));

		//Pq o .JPEG tem mais de 4 caracteres
		if( $extensao == "jpeg" ) {
			$extensao = ".jpeg";
		}

		if ( in_array($extensao, $extensoes) ) {

			$nome_imagem 	= md5($_FILES['imagem_item_menu']['name']). $extensao;
			$diretorio 		= "upload/";
			move_uploaded_file($_FILES['imagem_item_menu']['tmp_name'], $diretorio . $nome_imagem);
		
		}

	} else {		
		echo " imagem nao encontrada ";
	}

	if ($nome_item_menu == "" || $descricao_item_menu == "" || $serve_qtd_pessoa == "" || $preco_item_menu == "") {
		die();
	}

	
	//Se o id_item_menu for 0, sera efetuado um INSERT
	if ($id_item_menu == 0) {

		$sql_insert_item_menu = "INSERT INTO Item_menu (id_estabelecimento, nome_item_menu, preco_item_menu, serve_qtd_pessoa, descricao_item_menu, imagem_item_menu) ";
		$sql_insert_item_menu.= "VALUES ($id_estabelecimento, '$nome_item_menu', $preco_item_menu, $serve_qtd_pessoa, '$descricao_item_menu', '$nome_imagem')";

		if ( mysqli_query($link, $sql_insert_item_menu) ) {
	    	echo $nome_item_menu . " adicionado!";
	    } else {
	    	echo "Falha ao adicionar Item de Menu.";
	    }

		//Verificando qual o próximo ID
		$novo_id = mysqli_insert_id($link);
		//echo $novo_id;

		//Apos adicionar o registro, vamos vincular o mesmo aos seus ingredientes
		foreach ($lista_ingredientes as $key => $value) {
			$sql_insert_item_ingrediente = " INSERT INTO Item_menuXIngrediente (id_item_menu, id_ingrediente) VALUES";
			$sql_insert_item_ingrediente.= " ($novo_id, $value)";
			echo $sql_insert_item_ingrediente;

			if ( mysqli_query($link, $sql_insert_item_ingrediente) ) {
	    		echo "Ingrediente " . $value . " vinculado ao " . $novo_id . ".";
		    } else {
		    	echo "Falha ao Vincular Ingrediente.";
		    }
		}

		die();	    

	} 

	//Se for id__item_menu diferente de 0, efetuar UPDATE
	else {


		$sql_update_item = "UPDATE Item_menu SET ";
		$sql_update_item.= "nome_item_menu = '$nome_item_menu', ";
		$sql_update_item.= "preco_item_menu = '$preco_item_menu', ";
		$sql_update_item.= "serve_qtd_pessoa = $serve_qtd_pessoa, ";
		$sql_update_item.= "descricao_item_menu = '$descricao_item_menu', ";
		$sql_update_item.= "imagem_item_menu = '$nome_imagem' ";
		$sql_update_item.= "WHERE id_item_menu = $id_item_menu";
			
		if ( mysqli_query($link, $sql_update_item) ) {
			echo $nome_item_menu . "alterado!";
		}else {
			echo "Falha ao atualizar o Item";
		}
		//print_r($lista_ingredientes);

		//Deletar as ligações entre os item menu e ingrediente para atualizar
		$sql_delete_item_ingrediente = "DELETE FROM Item_menuXIngrediente  WHERE id_item_menu = $id_item_menu";

		if ( mysqli_query($link, $sql_delete_item_ingrediente) ) {
			echo "Lista de Ingredientes limpa, prosseguindo para a atualização dos Ingredientes. <br>";
		}


		//Apos deletar o registro, vamos vincular o mesmo aos seus ingredientes
		foreach ($lista_ingredientes as $key => $value) {
			$sql_update_item_ingrediente = " INSERT INTO Item_menuXIngrediente (id_item_menu, id_ingrediente) VALUES";
			$sql_update_item_ingrediente.= " ($id_item_menu, $value)";
			//echo $sql_update_item_ingrediente;

			if ( mysqli_query($link, $sql_update_item_ingrediente) ) {
	    		echo "Ingrediente " . $value . " atualizado ao " . $id_item_menu . ".";
		    } else {
		    	echo "Falha ao atualizar Ingrediente.";
		    }
		}

	}

?>
