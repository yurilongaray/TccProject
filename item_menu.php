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

	$sql_ingrediente = "SELECT * FROM Ingrediente";
	$sql_ingrediente.= " WHERE id_estabelecimento = $id_estabelecimento";
	$sql_ingrediente.= " ORDER BY nome_ingrediente";

	$resultado_sql_ingrediente = mysqli_query($link, $sql_ingrediente);

?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Menu</title>

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
				<h2>Item Menu</h2>
			</div>

			<div class="row">     			

				<div class="col-sm-8 col col-xs-4">
				  	<!-- Botão para abrir a modal -->
				  	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#form-modal-item-menu">Adicionar</button>
			  	</div>
				
				<div class="col-sm-4 col col-xs-8">
				  	<form id="form-buscar-item-menu" class="input-group pull-right">
		    			<input type="text" id="buscar-item-menu" name="buscar_item_menu" class="form-control" placeholder="O que você está procurando?" maxlength="140" />
		    			<span class="input-group-btn">
		    				<button class="btn btn-default" id="botao-buscar_item_menu" type="button">Buscar</button>
		    			</span>
		    		</form>
	    		</div>
      		</div>

			<!-- Aqui serão inseridos os itens do menu -->
			<div id="painel-item-menu" class="row"></div>
			
			<!-- /////////////////////////////// INICIO MODAL FORM ///////////////////////////////// -->

	        <div class="modal fade" id="form-modal-item-menu" role="dialog">
			    <div class="modal-dialog">
			      	<div class="modal-content">

				        <div class="modal-header">

				        	<button type="button" class="close botao_close" data-dismiss="modal">&times;</button>
				        	
				        	<div class="row col-sm-12">
								<div class="col-sm-6">
									<a href="#" class="active pull-right botao-aba-principal">Principal</a>
								</div>
								<div class="col-sm-6">
									<a href="#" class="botao-aba-ingredientes">Ingredientes</a>
								</div>
							</div>
				        </div>

				        <!-- ///////////////////////////// INICIO FORM ITEM_MENU /////////////////////////////// -->
				        <form id="form-item-menu" method="post" enctype="multipart/form-data">

					        <div class="modal-body aba-principal">
					            <div class="row form-group">
						        	<div class="col-sm-12">
							        	<label for="nome-item">Nome: </label>
							        	<input type="text" id="nome-item" class="form-control input-sm col-sm-12" name="nome_item_menu" maxlength="30" required>
							        </div>
						        </div>
						        <input type="hidden" name="id_item_meu" id="id-item" value="0">	
							    <div class="row form-group">	
									<div class="col-sm-12">								
						        		<label for="descricao-item">Descrição: </label>
						        		<textarea type="text" class="form-control col-sm-12" id="descricao-item" name="descricao_item_menu" maxlength="330"></textarea>
						        	</div>
								</div>
								<div class="row form-group">									
						        	<div class="col-sm-6">
						        		<label for="serve-item">Serve: </label>
						        		<input type="number" min="1" max="1000" step="1" id="serve-item" class="form-control input-sm" name="serve_qtd_pessoa" placeholder="Num. Pessoas">
						        	</div>
						        	<div class="col-sm-6">
						        		<label for="preco-item">Preço: </label>
						        		<input type="number" class="form-control input-sm" min="0.00" max="10000.00" step="0.01" id="preco-item" name="preco_item_menu" placeholder="R$">
						        	</div>
								</div>
								<div class="row form-group">
									<div class="col-sm-12">
							            <label for="imagem-item">Imagem:</label>
							        	<input type="file" class="form-control-file" id="imagem-item" name="imagem_item_menu" aria-describedby="fileHelp">
										<small id="fileHelp" class="form-text text-muted">Somente imagens nos formatos: jpeg, png e jpg</small>
  									</div>
								</div>
					        </div>
								
							<!-- Aba de Ingredientes -->
					        <div class="modal-body aba-ingredientes">
					        	<div class="well">
					        		<ul class="list-group checked-list-box">
										<?php
											while ( $registro = mysqli_fetch_array( $resultado_sql_ingrediente, MYSQLI_ASSOC) ) {
												echo "
													<div class='checkbox'> 
														<li class='list-group-item'> 
															<label> 
																<input type='checkbox' data-ingrediente_check='" . $registro['nome_ingrediente'] . "' id='ingrediente-item' name='ingrediente_item_menu[]' value='". $registro['id_ingrediente'] . "'> " . $registro['nome_ingrediente'] . "
															</label>
														</li>
													</div>
												";
											}
										?>
									</ul>
								</div>							
							</div>

					        <div class="modal-footer">
					        	<button type="button" class="btn btn-danger botao_close" data-dismiss="modal">Close</button>
					        	<button type="button" class="btn btn-success pull-left" onclick="insertItem()" id="botao-insert-item">Adicionar</button>
				        	</div>

			      		</form>
			      		 <!-- /////////////////////////////// FIM FORM ITEM_MENU ///////////////////////////////// -->
	                </div>
			    </div>
	        </div>

	        <!-- //////////////////////////////// FIM MODAL FORM ///////////////////////////////// -->


			<!-- ////////////////////////////// INICIO MODAL DE CONFIRMA DELETE ///////////////////////////////// -->
			<div class="modal fade" id="modal-confirmar-delete" role="dialog">
			    <div class="modal-dialog modal-sm">
			      	<div class="modal-content">
				        <div class="modal-header">
				        	<h4 class="modal-title" align="center" id="texto-confirmar-delete"></h4>
				        	<input type="hidden" id="id-confirmar-delete">
				        </div>
				        <div class="modal-footer">
							<button type="button" class="btn btn-danger botao_close" data-dismiss="modal">Não</button>
							<button type="button" class="btn btn-success pull-left" onclick="confirmaDelete()">Sim</button>
						</div>		        
	                </div>
			    </div>
	        </div>
	        <!-- //////////////////////////////// FIM MODAL DE CONFIRMA DELETE  ///////////////////////////////// -->

	    	<br>
		</div>	<!-- Container -->

	</body>

	<!-- link do arquivo js-->
	<script type="text/javascript" src="js/item_menu.js"></script>

</html>
