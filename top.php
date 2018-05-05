<?php
  
  $id_estabelecimento = $_SESSION['id_estabelecimento'];
  $sql = "SELECT nome_estabelecimento FROM Estabelecimento ";
  $sql.= "WHERE id_estabelecimento = $id_estabelecimento ";
  $sql.= "ORDER BY id_estabelecimento ";
  $sql.= "LIMIT 1";

  $query = mysqli_query($link, $sql);

  $resultado_query = mysqli_fetch_array($query, MYSQLI_ASSOC);

  $nome_estabelecimento = $resultado_query['nome_estabelecimento'];

?>

<nav class="navbar navbar-fixed-top navbar-inverse" style="border-color: #E0FFFF;">
  <div class="container-fluid">
  
    <div class="navbar-header col-md-2">
      <p class="navbar-text col-xs-10" id="logo"><?= $nome_estabelecimento; ?></p>
      <button type="button" class="navbar-toggle collapsed col-xs-2" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav espacamento">
        <li><a href="array_insert.php">Home</a></li>
        <li><a href="menu.php">Resumo</a></li>
        <li><a href="caixa.php">Caixa</a></li>
        <li><a href="pedido.php">Pedidos</a></li>
        <li><a href="item_menu.php">Menu</a></li>
        <li><a href="painel.php">Painel de Controle</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">  
        <li><a href="logout.php" id="logout">
          <span class="glyphicon glyphicon-log-in"></span>Logout</a>
        </li>
      </ul>
    </div>

  </div>
  

</nav>