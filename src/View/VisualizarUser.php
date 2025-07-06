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
    
    <h1 align="center" class="display-4">Visualizar Usuários</h1>
    <br>
    <table class="table table-striped table-responsive">
    <thead class="table-dark">
        <tr>
            <th>CPF</th>
            <th>Nome</th>
            <th>Biografia</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Rua</th>
            <th>Bairro</th>
            <th>Senha</th>
            <th>Data de Nascimento</th>
            <th>Tipo</th>
            <?php if ($_SESSION["USER_LOGIN"] == "admin") echo '<th>Ações</th>'; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($lista as $userData): 
            $user = new User($userData);
            $nomeEstado = $ConUser->getNomeEstado($user->getIdEstado());
            $nomeCidade = $ConUser->getNomeCidade($user->getIdCidade());
            $dataOriginal = $user->getDataNascimento();
            $data = DateTime::createFromFormat('Y-m-d', $dataOriginal);
            $dataFormatada = $data ? $data->format('d/m/Y') : 'Data inválida';
        ?>
            <tr>
                <td><?= $user->getCPF(); ?></td>
                <td><?= $user->getNome(); ?></td>
                <td><?= $user->getBiografia(); ?></td>
                <td><?= $user->getEmail(); ?></td>
                <td><?= $nomeEstado; ?></td>
                <td><?= $nomeCidade; ?></td>
                <td><?= $user->getRua(); ?></td>
                <td><?= $user->getBairro(); ?></td>
                <td><?= $user->getSenha(); ?></td>
                <td><?= $dataFormatada; ?></td>
                <td><?= $user->getTipo(); ?></td>
                <?php if ($_SESSION["USER_LOGIN"] == "admin"): ?>
                    <td>
                        <form action="<?= HOME ?>VisualizarUser" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                            <input type="hidden" name="id_user" value="<?= $user->getIdUser(); ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="acao" value="Excluir">
                                <img src="src/View/img/deletar2.png" width="20" height="20" alt="Excluir">
                            </button>
                        </form>
                        <br>
                        <form action="<?= HOME ?>AlterarUser" method="GET">
                            <input type="hidden" name="id" value="<?= $user->getIdUser(); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <img src="src/View/img/editar2.png" width="20" height="20" alt="Alterar">
                            </button>
                        </form>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
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
