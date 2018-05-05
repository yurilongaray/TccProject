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


?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Caixa</title>

		<!-- link da cdn do jquery -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- link da cdn do bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- link do arquivo css -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<!-- link do arquivo js-->
		<script type="text/javascript" src="js/caixa.js"></script>
	
	</head>

	<body>

		<?php require_once("top.php"); ?>

		<div class="container">
			
			<div class="page-header">
				<h2>Caixa / Comandas</h2>
			</div>
			

			<div class="row">
				<div class="col-md-4">
				  	<form id="form-buscar-nome-usuario" class="input-group pull-right">
		    			<input type="text" id="buscar-nome-usuario" name="buscar_nome_usuario" class="form-control" placeholder="Nome do Cliente" maxlength="140" />
		    			<span class="input-group-btn">
		    				<button class="btn btn-default" id="botao-buscar_nome_usuario" type="button">Buscar</button>
		    			</span>
		    		</form>
	    		</div>
			</div>

			<br>

			<div class="row col-md-12">
				<table class="table table-hover">
					<thead>
				        <tr>
				            <th class="col-md-2">Comanda</th>
				            <th class="col-md-2">Status da Comanda</th>
				    	    <th class="col-md-3">Nome do Cliente</th>
				    	    <th class="col-md-2">Código da Mesa</th>
				    	    <th class="col-md-2">Valor a Pagar</th>
				    	    <th class="col-md-1">Encerrar</th>
				        </tr>
				    </thead>
					
					<!-- INSERÇÃO DO CONTEUDO  --> 
				    <tbody id="painel-caixa"></tbody>

				</table>    
			</div>

		</div>
	</body>

</html>
