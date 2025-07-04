<?php
include_once __DIR__ . "/../Controller/ConUser.php";
include_once __DIR__ . "/../Model/User.php";
include_once __DIR__ . '/../Rotas/Constantes.php';

if (isset($_POST['email']) && isset($_POST['senha'])) {
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  $ConUser = new ConUser();
  $linha = $ConUser->selectLoginUser1($_POST['email']);

  if ($linha == null) {
    echo "<script>alert('Desculpe, essa conta não existe.'); window.location.href = '/Sync360/Login';</script>";
  } else {
    $user = new User($linha[0]);
    if (($user->getEmail() == $_POST['email']) && password_verify($_POST['senha'], $user->getSenha())) {
      $_SESSION["USER_LOGIN"] = $user->getTipo();
      $_SESSION["USER_LOGIN2"] = $_POST['email'];
      $_SESSION["USER_LOGIN_ID"] = $user->getIdUser();
      $_SESSION["user_cpf"] = $user->getCPF();
      
      header("Location: " . HOME . "Home");
      if (isset($_SESSION["USER_LOGIN"])){
        header("Location: " . HOME . "Home");
        exit;
      }
    } else {
      echo "<script>alert('Erro! E-mail ou senha incorretos.'); window.location.href = '/Sync360/Login';</script>";
    }
  }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
        .container2 {
            width: 45%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .container2 {
                width: 90%;
            }
        }

        @media (max-width: 576px) {
            .container2 {
                width: 100%;
                padding: 0 15px;
            }
        }

        .formLogin {
          display: flex;
          flex-direction: column;
          background-color: #fff;
          border-radius: 7px;
          padding: 40px;
          box-shadow: 10px 10px 40px rgba(0, 0, 0, 0.4);
          gap: 5px
        }

        .areaLogin img {
          width: 420px;
        }

        .formLogin h1 {
          padding: 0;
          margin: 0;
          font-weight: 500;
          font-size: 2.3em;
        }

        .formLogin p {
          display: inline-block;
          font-size: 14px;
          color: #666;
          margin-bottom: 25px;
        }

        .formLogin input {
          padding: 15px;
          font-size: 14px;
          border: 1px solid #ccc;
          margin-bottom: 20px;
          margin-top: 5px;
          border-radius: 4px;
          transition: all linear 160ms;
          outline: none;
        }


        .formLogin input:focus {
          border: 1px solid #1f2937;
        }

        .formLogin label {
          font-size: 14px;
          font-weight: 600;
        }

        .formLogin a {
          display: inline-block;
          margin-bottom: 20px;
          font-size: 13px;
          color: #555;
          transition: all linear 160ms;
        }

        .formLogin a:hover {
          color: rgb(37, 41, 68);
        }
    </style>
</head>

<body>
  <?php
    include_once 'header.php';
  ?>
  <div class="container">
    <div class="container2">
      <br><br>
      <div class="row mt-4">
        <form action="<?=HOME?>Login" method="POST" class="formLogin">
          <h1 align="center">LOGIN</h1><br>
          <label for="email">E-mail</label>
          <input type="email" name="email" placeholder="Digite seu e-mail" autofocus="true" />
          <label for="password">Senha</label>
          <input type="password" name="senha" placeholder="Digite sua senha" />
          <input type="submit" value="Acessar" class="btn" />
        </form>
      </div>
    </div>
  </div>
</body>

</html>