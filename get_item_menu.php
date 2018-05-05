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

	$id_estabelecimento = $_SESSION['id_estabelecimento'];

	//Para efetuar o filtro: 
	if ( isset($_POST['buscar_item_menu']) ) {
		$buscar_item_menu = $_POST['buscar_item_menu'];
	} else {
		$buscar_item_menu = "";
	}

	$sql = " SELECT * "; 
	$sql.= " FROM Item_menu ";
	$sql.= " WHERE nome_item_menu LIKE '%$buscar_item_menu%' ";
	$sql.= " AND id_estabelecimento = $id_estabelecimento";
	$sql.= " ORDER BY id_item_menu DESC"; //DESC = ordem decrescente

	$resultado_sql = mysqli_query($link, $sql);

	if ( $resultado_sql ) {
		while ( $registro = mysqli_fetch_array($resultado_sql, MYSQLI_ASSOC) ) { //Retorna apenas indices associativos
			//var_dump($registro);


			//SQL para encontrar os ingredientes de cada item_menu
			$sql_ingrediente_item = " SELECT Ingrediente.nome_ingrediente";
			$sql_ingrediente_item.= " FROM Item_menuXIngrediente";
			$sql_ingrediente_item.= " INNER JOIN Item_menu ON Item_menu.id_item_menu = Item_menuXIngrediente.id_item_menu";
			$sql_ingrediente_item.= " INNER JOIN Ingrediente ON Ingrediente.id_ingrediente = Item_menuXIngrediente.id_ingrediente";
			$sql_ingrediente_item.= " WHERE Item_menu.id_item_menu = " . $registro['id_item_menu'];
			

			$resultado_sql_ingrediente_item = mysqli_query($link, $sql_ingrediente_item);

			$array_ingrediente = array();

			//Adicionando os nomes de ingredientes em um array
			while ( $row =  mysqli_fetch_array($resultado_sql_ingrediente_item, MYSQLI_ASSOC) ) {
				$array_ingrediente[] = $row['nome_ingrediente'];
			}

			//print_r($array_ingrediente);


			//Esse é o resultado de muitas conversões: lista_ingredientes
			$lista_ingredientes = implode(",", $array_ingrediente);
			
			//echo $lista_ingredientes;

			if ( !isset($registro['imagem_item_menu']) ) {
				$imagem_apresentada = "pratox.jpg";
			} else {
				$imagem_apresentada = $registro['imagem_item_menu'];
			}

			echo "<div class='col-md-6'>";

				echo "<div class='box' >";

					echo "<div class='box-content'> ";

						//data-id_item_menu, serve para que no jquery seja possivel a captura do id
						echo "<span class='glyphicon glyphicon-remove pull-right' data-toggle='modal' data-target='#modal-confirmar-delete' onclick='deleteItem(" . $registro['id_item_menu'] . ")'></span>";

						echo "<span class='glyphicon glyphicon-edit pull-right' onclick='buscarDados(" . $registro['id_item_menu'] . ", \"" . $registro['nome_item_menu'] . "\", \""  . $registro['descricao_item_menu'] . "\", \"" . $lista_ingredientes . "\", " . $registro['serve_qtd_pessoa'] . ", " . $registro['preco_item_menu'] . ")' ></span>";

						echo "<h4 class='tag-title' id='nome_item_menux' > " . $registro['nome_item_menu'] . " </h4>";

						echo "<img id='imagem-item-menu' src='upload/" . $imagem_apresentada . "' class='img-responsive pull-left'>";

						echo "<p> <strong>Descrição: </strong>" . $registro['descricao_item_menu'] . "</p>";
						echo "<br>";

						echo "<span class='pull-left' id='posicao-serve'><strong>Serve: </strong>" . $registro['serve_qtd_pessoa'] . " pessoa (as)</span>";

						echo "<span class='pull-right' id='posicao-preco'><strong>Valor: </strong>R$ " . $registro['preco_item_menu'] . "</span>";

					echo "</div>";

				echo "</div>";

			echo "</div>";
		}

	} else {
		echo "Falha ao trazer os itens do cardápio";
	}

?>