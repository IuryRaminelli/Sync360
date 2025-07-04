<?php
session_start();
include_once "src/Controller/ConUser.php";
include_once "src/Model/User.php";

$ConUser = new ConUser();
$linha = $ConUser->selectLoginUser1($_SESSION["USER_LOGIN2"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'Alterar') {
    $idUser = $_POST['id_user'];
    $_SESSION['id_user'] = $idUser;
    header("Location: " . HOME . "AlterarUser");
    exit();
}

if (isset($_SESSION["USER_LOGIN"]) && ($_SESSION["USER_LOGIN"] != "admin" || $_SESSION["USER_LOGIN"] == "admin")) {

    if($linha != null){
        $user = new User($linha[0]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <div class="container2">
        <form align="center" method="POST">

            <br><br>
            
            <h1 align="center" class="display-4">Perfil</h1><br>
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" value="<?php echo $user->getCPF(); ?>" autofocus="true" disabled=""/><br>
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $user->getNome(); ?>" autofocus="true" disabled=""/><br>
                <label for="dataNascimento">Data de Nascimento</label>
                <?php
                    $dataOriginal = $user->getDataNascimento();
                    $data = DateTime::createFromFormat('Y-m-d', $dataOriginal);
                    $dataFormatada = $data->format('d/m/Y');
                ?>
                <input type="text" class="form-control" name="dataNascimento" value="<?= $dataFormatada;?>" disabled=""/><br>

                <!-- Idade não é salva no banco de dados, mas é contada automáticamente através da data de nascimento (que é salva no banco de dados) -->
                <label for="email">Idade</label>
                <?php
                    $dataNascimento = new DateTime($dataOriginal);
                    $hoje = new DateTime();
                    $idade = $dataNascimento->diff($hoje)->y;
                ?>
                <input type="email" class="form-control" name="email" value="<?= $idade;?>" disabled=""/><br>
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user->getEmail(); ?>" disabled=""/><br>
                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" value="********" disabled=""/><br>
                <label for="imagem">Foto de Perfil</label>
                <br>
                <img src="<?= $user->getImagem() ?>" alt="Foto" width="150" height="150" class="rounded-circle">
                <br>
                <input type="hidden" name="id_user" value="<?= $user->getIdUser(); ?>">
                <br>
                <button type="submit" class="btn" name="acao" value="Alterar">
                    <img src="src/View/img/editar2.png" width="28" height="28" alt="">
                </button>
            </form>
    </div>
    <br><br>
</div>
</body>
</html>
<?php
    }
} else {
    echo "<h1>404 Não possui acesso.</h1>";
}
?>