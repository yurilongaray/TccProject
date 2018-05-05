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
	if ( isset($_POST['buscar_pedido']) ) {
		$buscar_pedido = $_POST['buscar_pedido'];
	} else {
		$buscar_pedido = "";
	}

	//Para filtros de Status do Pedido:
	if ( isset($_POST['buscar_status']) ){
		$buscar_status = $_POST['buscar_status'];
	} else {
		$buscar_status = 1; //Para tornar padrao e sempre vir com este valor
	}

	//Futuramente devemostrazer somente os itens do estabelecimento, então deveremos aplicar um WHERE abaixo:
	$sql = " SELECT *"; 
	$sql.= " FROM Pedido p";
	$sql.= " INNER JOIN Item_menu i ON p.id_item_menu = i.id_item_menu ";
	$sql.= " INNER JOIN Status_pedido s ON p.id_status_pedido = s.id_status_pedido ";
	$sql.= " WHERE i.nome_item_menu LIKE '%$buscar_pedido%' ";
	$sql.= " AND s.id_status_pedido = $buscar_status";
	$sql.= " AND p.id_estabelecimento = $id_estabelecimento";
	$sql.= " ORDER BY id_pedido"; 

	//echo $sql;

	//die();

	$resultado_sql = mysqli_query($link, $sql);

	if ( $resultado_sql ) {
		while ( $registro = mysqli_fetch_array($resultado_sql, MYSQLI_ASSOC) ) { //Retorna apenas indices associativos
			//var_dump($registro);

			if ( !isset($registro['imagem_item_menu']) ) {
				$imagem_apresentada = "pratox.jpg";
			} else {
				$imagem_apresentada = $registro['imagem_item_menu'];
			}
			
			$horario_pedido = substr($registro['data_registro'], -8);
			
			echo "<div class='col-md-6 '>";

				echo "<div class='box editar-pedido' onclick='updatePedido(" . $registro['id_pedido'] . ")' data-toggle='modal' data-target='#modal-update-pedido' >";

					echo "<div class='box-content' > ";

						echo "<h4 class='tag-title'> " . $registro['nome_item_menu'] . " </h4>";

						echo "<span class='pull-right' id='posicao-id-pedido'> <strong>" . $registro['id_pedido'] . " </strong></span>";

						echo "<img src='upload/" . $imagem_apresentada . "' class='img-responsive pull-left'>";

						echo "<p><strong> Observações: <br> </strong>" . $registro['observacao_pedido'] . "</p>";

						echo "<br>";

						echo "<span class='pull-left' id='posicao-data-pedido'><strong>Horário: </strong>" . $horario_pedido . "</span>";

						echo "<span class='pull-right' id='posicao-status'><strong>Status: </strong>" . $registro['nome_status_pedido'] . "</span>";

					echo "</div>";
				echo "</div>";

			echo "</div>";

		}

	} else {
		echo "Falha ao trazer os itens do cardápio";
	}

?>