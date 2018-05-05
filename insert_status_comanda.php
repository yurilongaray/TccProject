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

	//$var = (!isset($_POST['friendid'])) ? $_varGET['var'] : 'empty';

	$id_estabelecimento 		= $_SESSION['id_estabelecimento'];
	$nome_status_comanda		= isset($_POST['nome_status_comanda']) ? $_POST['nome_status_comanda'] : NULL;
	$descricao_status_comanda	= isset($_POST['descricao_status_comanda']) ? $_POST['descricao_status_comanda'] : NULL;

	$sql_insert_status_comanda	= " INSERT INTO Status_comanda (id_estabelecimento, nome_status_comanda, descricao_status_comanda)";
	$sql_insert_status_comanda.= " VALUES ($id_estabelecimento, '$nome_status_comanda', '$descricao_status_comanda')";

	if( isset($nome_status_comanda) ) {
		mysqli_query($link, $sql_insert_status_comanda);
		header("Location: painel.php?Status_comanda_registrado");
	}
?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>x</title>

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
			
			<div class="page-header">
				<h2>Cadastro de Status de Comanda</h2>
			</div>
			
			<form action="" method="post">
				
				<div class="row">
					<div class="form-group col-md-4">
						<label for="nome">Nome:</label>
						<input type="text" name="nome_status_comanda" tabindex="1" class="form-control" maxlength="30" required>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="descricao">Descrição:</label>
						<input type="text" name="descricao_status_comanda" tabindex="2" class="form-control" maxlength="330" >
					</div>
				</div>

				<button type="submit" class="btn btn-success">Cadastrar</button>

			</form>

		</div>


	</body>

</html>
