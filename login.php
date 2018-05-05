<?php 

	require_once("db_class.php");

	$objDb	= new db();
	$link	= $objDb->connect_db();
	
	$erro = isset($_GET['erro']) ? $_GET['erro'] : 0;

	$sql = "SELECT * FROM Estabelecimento";

	$resultado_sql = mysqli_query($link, $sql);

	$login = isset($_GET['login']) ? $_GET['login']: "";

?>

<!DOCTYPE html>
<html lang="pt-br">

	<head>

		<meta charset="UTF-8">

		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Login</title>

		<!-- link da cdn do jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<!-- link da cdn do bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<!-- link do arquivo css -->
		<link rel="stylesheet" type="text/css" href="css/style.css">
		
		<!-- link dos datepicker -->
		<link href="css/bootstrap-datepicker.css" rel="stylesheet" >
		<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="js/bootstrap-datepicker.pt-BR.min.js"></script>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>

	</head>

	<body>
		<div class="container">
	    	<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-login">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<a href="#" class="active" id="login-form-link">Login</a>
								</div>
								<div class="col-xs-6">
									<a href="#" id="register-form-link">Registrar</a>
								</div>
							</div>
							<hr>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">

									<!-- FORMULÁRIO DE LOGIN -->
									<form id="login-form" action="valida_login.php" method="POST" role="form"">
										<div class="form-group">
											<input type="text" name="usuario" id="username" tabindex="1" class="form-control text-center" placeholder="Usuario" value="<?= $login ?>">
										</div>
										<div class="form-group">
											<input type="password" name="senha" id="password" tabindex="2" class="form-control text-center" placeholder="Senha">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<button type="submit" name="login-submit" id="login-submit" tabindex="3" class="form-control btn btn-login">Entrar</button>
												</div>
											</div>
										</div>
										<!--<div class="form-group">
											<a href="" tabindex="5" class="forgot-password pull-right">Esqueci minha senha</a>
										</div>-->
									</form>

									<!-- FORMULÁRIO DE REGISTRO -->
									<form id="register-form" action="registra_usuario.php" method="POST" role="form" >
										
										<div class="form-group">
											<label for="registra-usuario-estabelecimento">Estabelecimento:</label>
											<select name="estabelecimento" id="registra-usuario-estabelecimento" tabindex="1" class="form-control"> 
												<?php 
													while ( $registro = mysqli_fetch_array($resultado_sql, MYSQLI_ASSOC) ) {
														echo "<option value='" . $registro['id_estabelecimento'] . "'> " . $registro['nome_estabelecimento'] . "</option>";
													};
												?>
											</select>
										</div>
										
										<div class="form-group">
											<label for="registra-nome">Nome Completo:</label>
											<input type="text" name="nome" id="registra-nome" tabindex="2" class="form-control" required>
										</div>
										
										<div class="form-group">
											<label for="datepicker">Data de Nascimento:</label>
											<div class="input-group date" id="datepicker">
											    <input type="text" name="data_nascimento" class="form-control" tabindex="3" required>
											    <div class="input-group-addon" required>
											        <span class="glyphicon glyphicon-th"></span>
											    </div>
											</div>
										</div>

										<div class="form-group">
											<label for="registra-sexo">Sexo:</label>
											<select name="sexo" id="registra-sexo" tabindex="4" class="form-control"> 
												<option value="M">Masculino</option>
												<option value="F">Feminino </option>
											</select>
										</div>

										<div class="form-group">
											<label for="registra-cidade">Cidade:</label>
											<input type="text" name="cidade" id="registra-cidade" tabindex="5" class="form-control" required>
										</div>
										
										<div class="form-group">
											<label for="registra-email">Email:</label>
											<input type="email" name="email" id="registra-email" tabindex="6" class="form-control" required>
										</div>
										

										<div class="form-group">
											<label for="registra-login">Login:</label>
											<input type="text" name="usuario" id="registra-login" tabindex="7" class="form-control" required>
										</div>
										
										
										<div class="form-group">
											<label for="registra-senha">Senha:</label>
											<input type="password" name="senha" id="registra-password" tabindex="8" class="form-control" required>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<button type="submit" name="register-submit" id="register-submit" tabindex="9" class="form-control btn btn-register">Registrar</button>
												</div>
											</div>
										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
			
	</body>

	<!-- link do arquivo js-->
	<script type="text/javascript" src="js/login.js"></script>
	


</html>