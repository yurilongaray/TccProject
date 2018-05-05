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

	//Para efetuar o filtro: 
	if ( isset($_POST['buscar_nome_usuario']) ) {
		$buscar_nome_usuario = $_POST['buscar_nome_usuario'];
	} else {
		$buscar_nome_usuario = "";
	}


	$sql = " SELECT *";
	$sql.= " FROM Comanda c";
	$sql.= " INNER JOIN Usuarios u ON c.id_usuario = u.id_usuario";
	$sql.= " INNER JOIN Status_comanda s ON c.id_status_comanda = s.id_status_comanda";
	$sql.= " WHERE nome_usuario LIKE '%$buscar_nome_usuario%' ";
	$sql.= " ORDER BY s.nome_status_comanda, id_comanda "; 

	//echo $sql;

	//die();

	$resultado_sql = mysqli_query($link, $sql);

	if ( $resultado_sql ) {

		while ( $registro = mysqli_fetch_array($resultado_sql, MYSQLI_ASSOC) ) { //Retorna apenas indices associativos
			//var_dump($registro);
			echo "<tr>";
				echo "<td>" . $registro['id_comanda'] 			. "</td>";
				echo "<td>" . $registro['nome_status_comanda']	. "</td>";
				echo "<td>" . $registro['nome_usuario'] 		. "</td>";
				echo "<td>" . $registro['mesa'] 				. "</td>";
				echo "<td>" . $registro['valor_total']			. "</td>";
				echo "<td> <span class='glyphicon glyphicon-remove' id=''></span> </td>";
			echo "</tr>";
		}
	}

?>