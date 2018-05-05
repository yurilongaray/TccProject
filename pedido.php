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

	$sql = " SELECT * FROM Status_pedido";
	$sql.= " WHERE id_estabelecimento = $id_estabelecimento";
	$sql.= " ORDER BY nome_status_pedido";

	$resultado_sql = mysqli_query($link, $sql);
	//Nao funciona o segundo while caso nao utilizemos mais uma pesquisa
	$resultado_sql2 = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Pedidos</title>

		<!-- link da cdn do jquery -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- link da cdn do bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- link do arquivo css -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
	</head>

	<body>

		<?php require_once("top.php"); ?>

		<div class="container">
			
			<div class="page-header">
				<h2>Pedidos</h2>
			</div>

			<div class="row">

				<form id="form-buscar-status">
					<div class="col-sm-2">
					  	<select class="form-control" name="buscar_status" id="status-pedido">
					  		<?php
								while ( $registro = mysqli_fetch_array($resultado_sql, MYSQLI_ASSOC) ) {
									echo "<option value=". $registro['id_status_pedido'] . ">" . $registro['nome_status_pedido'] . "</option>";
								};

							?>
						</select>
					</div>
					
					<div class="col-sm-6">						
				  		<button class="btn btn-success" id="botao-buscar-status" type="button">Atualizar</button>
					</div>
				</form>

					
				<div class="col-sm-4">

					<form id="form-buscar-pedido" class="input-group">
			    		<input type="text" id="buscar-pedido" name="buscar_pedido" class="form-control" placeholder="O que você está procurando?" maxlength="140" />
			    		<span class="input-group-btn">
			    			<button class="btn btn-default" id="botao-buscar-pedido" type="button">Buscar</button>
			    		</span>
			    	</form>

	    		</div>

		    </div>
			
			<!-- Aqui serão inseridos os pedidos -->
			<div class="row" id="painel-pedido"></div>

			<!-- ////////////////////////////// INICIO MODAL DE UPDATE  ///////////////////////////////// -->
			<div class="modal fade" id="modal-update-pedido" role="dialog">
			    <div class="modal-dialog modal-sm">
			      	<div class="modal-content">
			      		<form id="form-update-pedido" method="post" enctype="multipart/form-data">
					        <div class="modal-header">
					        	<h4 class="modal-title" align="center" id="texto-update-pedido"></h4>
					        </div>
					        <div class="modal-body">
					        	<div class="form-group">
					        		<!-- Para armazenar o valor do id_pedido na raça -->
					        		<input type="number" class="form-control hidden" id="input-id-pedido" name="input_id_pedido" >
					        	</div>
					        	<div class="form-group">	
					        		<select class="form-control" name="alterar_status" id="alterar-status">
							  		<?php 
										while ( $registro = mysqli_fetch_array($resultado_sql2, MYSQLI_ASSOC) ) {
											echo "<option value=". $registro['id_status_pedido'] . ">" . $registro['nome_status_pedido'] . "</option>";
										};

						  			?>
								</select>
								</div>
					        </div>		
					        <div class="modal-footer">
								<button type="button" class="btn btn-danger pull-right close-update" data-dismiss="modal">Cancelar</button>
								<button type="button" class="btn btn-success pull-left" id="botao-confirmar-update">Alterar</button>
							</div>	
						</form>	        
	                </div>
			    </div>
	        </div>
	        <!-- //////////////////////////////// FIM MODAL DE UPDATE  ///////////////////////////////// -->


		</div>

	</body>

	
	<!-- link do arquivo js-->
	<script type="text/javascript" src="js/pedido.js"></script>

</html>
