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

	$sql1 = " SELECT * FROM Status_pedido";
	$sql1.= " WHERE id_estabelecimento = $id_estabelecimento";
	$sql1.= " ORDER BY nome_status_pedido";

	$resultado_sql1 = mysqli_query($link, $sql1);

	$sql2 = " SELECT * FROM Status_comanda";
	$sql2.= " WHERE id_estabelecimento = $id_estabelecimento";
	$sql2.= " ORDER BY nome_status_comanda";

	$resultado_sql2 = mysqli_query($link, $sql2);

	$sql3 = " SELECT * FROM Ingrediente";
	$sql3.= " WHERE id_estabelecimento = $id_estabelecimento";
	$sql3.= " ORDER BY nome_ingrediente";

	$resultado_sql3 = mysqli_query($link, $sql3);
	

?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Painel de Controle</title>

		<!-- link da cdn do jquery -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- link da cdn do bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- link do arquivo css -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<!-- link do arquivo js-->
		<script type="text/javascript" src="js/script.js"></script>
	
	</head>

	<body>

		<?php require_once("top.php"); ?>

		<div class="container">
			<div class="row page-header">
				<h2> Painel de Controle </h2>
			</div>

			<div class="row painel-controle">
			
				<h4> Status de Pedido </h4>

				<a href="insert_status_pedido.php" class="btn btn-success pull-right">Cadastrar</a>

				<ul class="list-inline">
					<?php 
						while ( $registro1 = mysqli_fetch_array($resultado_sql1, MYSQLI_ASSOC) ) {
							echo "<li><strong>" . $registro1['nome_status_pedido'] . "</strong></li>";
						};

					?>
				</ul>
				
			</div>

			<div class="row painel-controle">
			
				<h4> Status de Comanda </h4>
				
				<a href="insert_status_comanda.php" class="btn btn-success pull-right">Cadastrar</a>

				<ul class="list-inline">
					<?php 
						while ( $registro2 = mysqli_fetch_array( $resultado_sql2, MYSQLI_ASSOC ) ) {
							echo "<li><strong>" . $registro2['nome_status_comanda'] . "</strong></li>";
						};

					?>
				</ul>
			
			</div>

			<div class="row painel-controle">
			
				<h4> Ingredientes </h4>
			
				<a href="insert_ingrediente.php" class="btn btn-success pull-right">Cadastrar</a>

				<ul class="list-inline">

					<?php 
						while ( $registro3 = mysqli_fetch_array( $resultado_sql3, MYSQLI_ASSOC ) ) {
							echo "<li><strong>" . $registro3['nome_ingrediente'] . "</strong></li>";
						};
					?>

				</ul>

			</div>

		</div>		

	</body>

</html>
