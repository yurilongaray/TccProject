<?php
    
    session_start(); //Sempre que criarmos uma sessão, devemos iniciar ela para utilizar as variáveis de sessão

    require_once('db_class.php');


    $objDb = new db();
    $objDb->connect_db();

    if (isset($_POST['usuario']) && (isset($_POST['senha']))) { //verifica se estão vazias
        $usuario = mysqli_real_escape_string($objDb->conn, $_POST['usuario']); //Escapar de caracteres especiais e SQL injection
        $senha   = mysqli_real_escape_string($objDb->conn, md5($_POST['senha'])); //para entrar com a senha criptografada pois se não a autenticação não será possível na hora de verificar senha com o banco de dados

        /* Busca na tabela o usuario que corresponde com os dados do form */
        $sql = " SELECT * FROM Usuarios WHERE login_usuario = '$usuario' AND senha_usuario = '$senha' ";
        $resultado_query = mysqli_fetch_assoc(mysqli_query($objDb->conn, $sql));

        if(isset($resultado_query)) { //Se o usuário existir, iniciar a sessão:
            $_SESSION['id_estabelecimento']      = $resultado_query['id_estabelecimento'];            
            $_SESSION['id_usuario']              = $resultado_query['id_usuario'];
            $_SESSION['usuario']                 = $resultado_query['login_usuario'];
            $_SESSION["usuarioNiveisAcessoId"]   = $resultado_query["id_niveis_acesso"];
            $_SESSION['email']                   = $resultado_query['email_usuario'];
            $_SESSION['senha']                   = $resultado_query['senha_usuario'];

            //Verificando o Nível de acesso do usuário    
            if ($_SESSION["usuarioNiveisAcessoId"] == "1") {
                header("Location: administrativo.php");
            } elseif ($_SESSION["usuarioNiveisAcessoId"] == "2") {
                header("Location: pedido.php");
            } else {
                header("Location: cliente.php");
            }
        
        } else { /* Nenhum usuario encontrado com os dados do form */
            header('Location: login.php?erro=1'); //Redireciona para página no Location
        }
    } else { /* bloqueia usuario e senha em branco tentando informar url para passar pelo login*/
        header('Location: login.php?erro=2'); //Redireciona para página no Location
    }


?>