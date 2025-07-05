<?php
session_start();
include_once "src/Controller/ConUser.php";
include_once "src/Model/User.php";

$ConUser = new ConUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'Excluir') {
    $idAta = $_POST["id_user"];

    if ($ConUser->deleteUser($idAta)) {
        echo "<script>alert('Excluído com sucesso!'); window.location.href = '" . HOME . "VisualizarUser';</script>";
        exit();
    } else {
        echo "<script>alert('Erro ao excluir!');</script>";
    }
}

if (isset($_SESSION["USER_LOGIN"]) && ($_SESSION["USER_LOGIN"] == "admin")) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
    include_once 'header.php';
?>

<div class="container">

    <br><br>

    <?php
        $lista = $ConUser->selectAllUser();
    ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">CPF</th>
                <th scope="col">Nome</th>
                <th scope="col">Biografia</th>
                <th scope="col">Email</th>
                <th scope="col">Estado</th>
                <th scope="col">Cidade</th>
                <th scope="col">Rua</th>
                <th scope="col">Bairro</th>
                <th scope="col">Senha</th>
                <th scope="col">Data de Nascimento</th>
                <th scope="col">Tipo</th>
                <?php
                    if (isset($_SESSION["USER_LOGIN"]) && $_SESSION["USER_LOGIN"] == "admin") {
                        echo '<th scope="col">Excluir</th>';
                    }
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
        $dataOriginal = $user->getDataNascimento();            
        $data = DateTime::createFromFormat('Y-m-d', $dataOriginal);
        $dataFormatada = $data->format('d/m/Y');

        foreach ($lista as $user) {
            $user = new User($user);
            echo '
                <tr>
                    <td>' . $user->getCPF() . '</td>
                    <td>' . $user->getNome() . '</td>
                    <td>' . $user->getBiografia() . '</td>
                    <td>' . $user->getEmail() . '</td>
                    <td>' . $user->getIdEstado() . '</td>
                    <td>' . $user->getIdCidade() . '</td>
                    <td>' . $user->getRua() . '</td>
                    <td>' . $user->getBairro() . '</td>
                    <td>' . $user->getSenha() . '</td>
                    <td>' . $dataFormatada . '</td>
                    <td>' . $user->getTipo() . '</td>
                    
                    ';
            if (isset($_SESSION["USER_LOGIN"]) && $_SESSION["USER_LOGIN"] == "admin") {
                echo '<td>
                        <form action="' . HOME . 'VisualizarUser' . '" method="POST" style="display:inline;">
                            <input type="hidden" name="id_user" value="' . $user->getIdUser() . '">
                            <button type="submit" class="btn" name="acao" value="Excluir" onclick="return confirm(\'Tem certeza que deseja excluir este usuário?\');">
                                <img src="src/View/img/deletar2.png" width="28" height="28" alt="">
                            </button>
                    </td>';
            }
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <br><br>
</div>
</body>
</html>

<?php
} else {
    echo "<h1>404 Não possui acesso.</h1>";
}
?>
