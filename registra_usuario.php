<?php 
	

    session_start(); //Sempre que criarmos uma sessão, devemos iniciar ela para utilizar as variáveis de sessão
    
	require_once("db_class.php");

	$objDb	= new db();
	$link	= $objDb->connect_db();

	$usuario		 = $_POST['usuario'];
	$estabelecimento = $_POST['estabelecimento']; 
	$nome 			 = $_POST['nome'];
	$email			 = $_POST['email'];
	$senha			 = md5($_POST['senha']);
	$sexo			 = $_POST['sexo'];
	$data_nascimento = $_POST['data_nascimento'];
	$cidade			 = $_POST['cidade'];

	//echo $usuario . "<br>" . $estabelecimento . "<br>" . $nome . "<br>" . $email . "<br>" . $senha . "<br>" . $sexo . "<br>" . $cidade . "<br>" . $data_nascimento;

	$usuario_existe = FALSE;
	$email_existe	= FALSE;

	//Verificando se já existe um usuário
	$sql_login = " SELECT login_usuario FROM Usuarios WHERE login_usuario = '$usuario' ";

	if ($resultado_login = mysqli_query($link, $sql_login)) {

		$coluna_login = mysqli_fetch_array($resultado_login);
		if (isset($coluna_login['login_usuario'])) { //Se já existe, vai para o if e então retorna a página de registrar
			$usuario_existe = TRUE;
		}		
	} else {
		"Erro ao tentar localizar o login do usuário";
	}

	//verificar se o e-mail já
	$sql_email = "SELECT  email_usuario FROM Usuarios WHERE email_usuario = '$email' ";
	
	if($resultado_email = mysqli_query($link, $sql_email)) {

		$coluna_email = mysqli_fetch_array($resultado_email);

		if(isset($coluna_email['email_usuario'])){ //Verifica se existe 
			$email_existe = TRUE;//Se já existe, vai para o if e então retorna a página de registra
		} 
	} else {
		echo 'Erro ao tentar localizar o registro de email';
	}


	if($usuario_existe || $email_existe){ //Verifica se o login ou email são true

		$retorno_get = '';

		if($usuario_existe){
			$retorno_get.= "erro_usuario=1&"; //& determinar onde acaba para então verificar outra variavel com get
		}

		if($email_existe){
			$retorno_get.= "erro_email=1&"; //.= para concatenar com a variavel e caso o usuario tbm exista, ficará: 
			//erro_usuario=1&erro_email=1&
		}

		header('Location: login.php?'.$retorno_get);
		die(); //Para que não seja inserido nenhum usuario no Banco de dados
	}

	$sql = " INSERT INTO Usuarios";
	$sql.= " (id_estabelecimento, id_niveis_acesso, nome_usuario, login_usuario, senha_usuario, email_usuario, cidade_usuario, sexo_usuario, data_nascimento)";
	$sql.= " VALUES ($estabelecimento, 2, '$nome', '$usuario', '$senha', '$email', '$cidade', '$sexo', '$data_nascimento')";

	//Executando insert do usuario
	if(mysqli_query($link, $sql)){
		header('Location: login.php?login='. $usuario);
	} else {
		echo 'Erro ao registrar o usuário!';
		echo "<a href='login.php' class='btn btn primary'>Voltar</a>";
	}


?>