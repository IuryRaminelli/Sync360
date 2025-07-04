<?php
session_start();
if (isset($_SESSION["USER_LOGIN"]) && $_SESSION["USER_LOGIN"] == "admin") {

    include_once __DIR__ . "/../Controller/ConUser.php";
    include_once __DIR__ . "/../Model/User.php";
    include_once __DIR__ . '/../Rotas/Constantes.php';

    if (isset($_POST['cadastro'])) {
        $arrayUser = array(
            "nome" => $_POST['nome'],
            "email" => $_POST['email'],
            "senha" => $_POST['senha'],
            "telefone" => $_POST['telefone'],
            "tipo" => $_POST['tipo'],
        );

        // Validação
        if (empty($_POST['nome']) || empty($_POST['email']) || empty($_POST['telefone']) || empty($_POST['senha'])) {
            echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href = '" . HOME . "CadastroUser';</script>";
            exit;
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('E-mail inválido.'); window.location.href = '" . HOME . "CadastroUser';</script>";
            exit;
        }

        $ConUser = new ConUser();
        $User = new User($arrayUser);

        if ($ConUser->insertUser($User)) {
            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href = '" . HOME . "CadastroUser';</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar usuário.'); window.location.href = '" . HOME . "CadastroUser';</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
    </style>
</head>
<body>      
  <?php
      include_once 'header.php';
  ?>

  <div class="container">

    <br><br>
    
    <div align="center">
    <h1 align="center" class="display-4">Usuários</h1>
      <?php
      echo '
        <form action="' . HOME . 'Usuarios' . '" method="POST" style="display:inline;">
            <input type="hidden" name="id_ativ">Visualizar Usuários<br>
            <button type="submit" class="btn" name="acao">
                <img src="src/View/img/config.png" width="28" height="28" alt="">
            </button>
        </form>';
      ?>
    </div>
    <br><br>

    <h1 align="center" class="display-4">Cadastrar Usuários</h1><br>
    <div class="container2">
    <form align="center" action="<?= HOME ?>CadastroUser" method="POST">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Digite um nome" autofocus="true"/><br>
                
                <label for="biografia">Biografia</label>
                <textarea class="form-control" name="biografia" rows="5" placeholder="Digite uma biografia" autofocus="true"></textarea><br>

                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Digite um e-mail"/><br>

                <!-- Automático em Banco de Dados -->
                <label for="estado">Estado</label>
                <input type="tel" class="form-control" name="telefone" placeholder="Digite um telefone"/><br>

                <!-- Não é automático em banco de dados (são muitas cidades) -->
                <label for="estado">Cidade</label>
                <input type="tel" class="form-control" name="telefone" placeholder="Digite um telefone"/><br>

                <label for="estado">Rua</label>
                <input type="tel" class="form-control" name="telefone" placeholder="Digite um telefone"/><br>

                <label for="estado">Bairro</label>
                <input type="tel" class="form-control" name="telefone" placeholder="Digite um telefone"/><br>

                <label for="tipo">Tipo</label>
                <select class="form-control" name="tipo">
                    <option value="membro">Selecione um tipo:</option>
                    <option value="membro">Normal</option>
                    <option value="admin">Administrador</option>
                </select><br>

                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" placeholder="Digite uma senha"/><br>

                <input type="submit" value="Cadastrar" class="btn" name="cadastro" />
            </form>
    </div>
    <br><br>
</div>
</body>
</html>

<?php 
}else{
    echo "<h1>404 Não possui acesso.</h1>";
}
?>