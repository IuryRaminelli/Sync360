<?php
include_once "src/Model/User.php";
include_once "src/Controller/ConUser.php";

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION["USER_LOGIN_ID"])) {
  $user_id = $_SESSION["USER_LOGIN_ID"];
  $ConUser = new ConUser();
  $user = $ConUser->selectUserById($user_id);
}
?>

<?php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$is_active = in_array($current_page, ['Produtos', 'Detalhes', 'ListaProdutos']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"></script>
  <style>
/* Primeiro header */
.top-header {
  position: fixed;
  top: 0;
  width: 100%;
  background-color: #ffffff;
  box-shadow: none;
  z-index: 1040;
  padding: 0.5rem 0;
}

.top-header .container {
  display: flex;
  justify-content: center;
  align-items: center;
}

.top-header img {
  height: 50px;
}

.header-spacer {
  height: 65px;
}

/* Segundo header */
.header-inicio {
  background-color: #ffffff;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  padding: 0.5rem 0;
  z-index: 1040;
}

.navbar-nav {
  gap: 1.5rem;
}

.navbar-nav .nav-link {
  color: #1f2937 !important;
  font-weight: 600;
  transition: color 0.2s ease-in-out, border-bottom 0.2s ease-in-out;
  padding-bottom: 5px;
  border-bottom: 2px solid transparent;
}

.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
  color: #0d6efd !important;
  border-bottom: 2px solid #0d6efd;
}

/* Botões */
.btn {
  background-color: #1f2937;
  color: #fff;
  font-size: 14px;
  font-weight: 600;
  border: none !important;
  transition: all linear 160ms;
  cursor: pointer;
}

.btn:hover {
  transform: scale(1.05);
  background-color: #1f2937;
}


/* .separador { */
  /* height: 2px; /* Ajuste a altura conforme necessário */
  /*background-color: #000; Cor da linha de separação */
/* } */

</style>
</head>
<body>

<!-- Primeiro Header -->
<header class="top-header">
  <div class="container">
    <a href="<?=HOME?>Home">
      <img src="src/View/img/amper.png" alt="Logo">
    </a>
  </div>
</header>

<!-- Espaço para compensar o header fixo -->
<div class="header-spacer"></div>

<!-- Segundo Header -->
<header class="header-inicio">
  <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
          <ul class="navbar-nav">
            <?php
            include_once __DIR__ . '/../Rotas/Constantes.php';
            if (isset($_SESSION["USER_LOGIN"]) && $_SESSION["USER_LOGIN"] == "admin") :
            ?>
              <li class="nav-item"><a class="nav-link <?= $current_page == 'Home' ? 'active' : '' ?>" href="<?=HOME?>Home">Home</a></li>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= in_array($current_page, ['CadastroUser']) ? 'active' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Controle
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= HOME ?>CadastroUser">Usuário</a></li>
              </ul>
            </li>
            <?php endif; ?>

            <?php if (isset($_SESSION["USER_LOGIN"]) && $_SESSION["USER_LOGIN"] != "admin") : ?>
                <li class="nav-item"><a class="nav-link <?= $current_page == 'Home' ? 'active' : '' ?>" href="<?=HOME?>Home">Home</a></li>
            <?php endif; ?>

            <?php if (!isset($_SESSION["USER_LOGIN"])) : ?>
              <li class="nav-item"><a class="nav-link <?= $current_page == 'Home' ? 'active' : '' ?>" href="<?=HOME?>Home">Home</a></li>
            <?php endif; ?>
          </ul>
          <ul class="navbar-nav">
            <?php if (!isset($_SESSION["USER_LOGIN"])) : ?>
              <div class="dropdown text">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="src/View/img/perfil.png" alt="Foto" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
                  <li><a class="dropdown-item" href="<?=HOME?>Login">Entrar</a></li>
                </ul>
              </div>
            <?php else : ?>
              <div class="dropdown text">
                <?php if (isset($_SESSION["USER_LOGIN"])) : ?>
                  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?= $user->getImagem() ?>" alt="Foto" width="32" height="32" class="rounded-circle">
                  </a>
                <?php endif; ?>
                <ul class="dropdown-menu text-small">
                  <li><a class="dropdown-item" href="<?=HOME?>Perfil">Perfil</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="<?=HOME?>Sair">Sair</a></li>
                </ul>
              </div>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</body>
</html>