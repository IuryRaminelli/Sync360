<?php
session_start();

include_once __DIR__ . "/../Controller/ConUser.php";
include_once __DIR__ . "/../Model/User.php";
include_once __DIR__ . '/../Rotas/Constantes.php';

                

if (isset($_POST['cadastro'])) {
    $target_dir = "src/View/img/";

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $name = $_FILES['imagem']['name'];
        $target_file = $target_dir . basename($name);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
                $tipo = isset($_POST['tipo']) && !empty($_POST['tipo']) ? $_POST['tipo'] : 'normal';

                $arrayUser = array(
                    "cpf" => $_POST['cpf'],
                    "nome" => $_POST['nome'],
                    "dataNascimento" => $_POST['dataNascimento'],
                    "email" => $_POST['email'],
                    "senha" => $_POST['senha'],
                    "imagem" => $target_file,
                    "tipo" => $tipo,
                    "biografia" => $_POST['biografia'],
                    "rua" => $_POST['rua'],
                    "bairro" => $_POST['bairro'],
                    "id_estado" => $_POST['id_estado'],
                    "id_cidade" => $_POST['id_cidade'],
                );

                $ConUser = new ConUser();
                $User = new User($arrayUser);

                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    echo "<script>alert('E-mail inválido.'); window.location.href = '" . HOME . "CadastroUser';</script>";
                    exit;
                }


                if ($ConUser->insertUser($User)) {
                    echo "<script>alert('Cadastrado com sucesso!'); window.location.href = '" . HOME . "CadastroUser';</script>";
                } else {
                    echo "<script>alert('Erro ao se cadastrar.'); window.location.href = '" . HOME . "CadastroUser';</script>";
                }
            } else {
                echo "<script>alert('Erro ao enviar a imagem.');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Tipo de imagem não permitido.');</script>";
            exit;
        }
    } else {
        echo "<script>alert('Nenhuma imagem foi enviada.');</script>";
        exit;
    }
}

$ConUser = new ConUser();
$resultado_estados = $ConUser->estados();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_estado']) && !isset($_POST['cadastro'])) {
    $estadoSelecionado = $_POST['id_estado'];
    $resultado_cidades = $ConUser->cidades($estadoSelecionado);

    if ($resultado_cidades) {
        foreach ($resultado_cidades as $cidade) {
            echo '<option value="' . htmlspecialchars($cidade['Id']) . '">' . htmlspecialchars($cidade['Nome']) . '</option>';
        }
    } else {
        echo '<option value="">Nenhuma cidade encontrada</option>';
    }
    exit;
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
    <div class="container2">
        <br><br>
        <div align="center">
            <h1 align="center" class="display-4">Visualizar Usuários</h1>
            <?php
            echo '
                <form action="' . HOME . 'VisualizarUser' . '" method="POST" style="display:inline;">
                    <button type="submit" class="btn" name="acao">
                        <img src="src/View/img/config.png" width="28" height="28" alt="">
                    </button>
                </form>';
            ?>
        </div>

        <form align="center" action="<?= HOME ?>CadastroUser" method="POST" enctype="multipart/form-data">
                 <br><br>
                 <h1 align="center" class="display-4">Cadastrar Usuários</h1><br>
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" placeholder="Digite seu CPF" autofocus="true" /><br>
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" placeholder="Digite seu Nome" autofocus="true" /><br>

                <label for="biografia">Biografia</label>
                <textarea class="form-control" name="biografia" rows="5" placeholder="Digite uma biografia" autofocus="true"></textarea><br>

                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail" autofocus="true" /><br>
                <label for="dataNascimento">Data de Nascimento</label>
                <input type="date" class="form-control" name="dataNascimento" autofocus="true" /><br>
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="id_estado">Estado</label>
                        <select class="form-control" name="id_estado" id="id_estado" required>
                            <option value="">Selecione seu estado</option>
                            <?php foreach ($resultado_estados as $estado) { ?>
                                <option value="<?= htmlspecialchars($estado['Uf']) ?>"><?= htmlspecialchars($estado['Nome']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_cidade">Cidade</label>
                        <select class="form-control" name="id_cidade" id="id_cidade" required>
                            <option value="">Selecione sua cidade</option>
                        </select>
                    </div>
                </div>
                <br>

                <label for="rua">Rua</label>
                <input type="text" class="form-control" name="rua" placeholder="Digite sua rua"/><br>

                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" name="bairro" placeholder="Digite seu bairro"/><br>

                <label for="tipo">Tipo</label>
                <select class="form-control" name="tipo">
                    <option value="membro">Selecione um tipo</option>
                    <option value="normal">Normal</option>
                    <option value="admin">Administrador</option>
                </select><br>

                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" placeholder="Digite sua senha" /><br>
                <label for="imagem">Foto de Perfil</label>
                <input type="file" class="form-control" name="imagem"/><br>
                <input type="submit" value="Cadastrar" class="btn" name="cadastro"/>
            </form>
    </div>
</div>
<br><br>

    <script>
        $(document).ready(function() {
            $('#id_estado').on('change', function() {
                var estadoId = $(this).val();
                if (estadoId) {
                    $.ajax({
                        type: 'POST',
                        url: '', // URL do próprio arquivo PHP
                        data: {id_estado: estadoId},
                        success: function(html) {
                            $('#id_cidade').html(html);
                        }
                    });
                } else {
                    $('#id_cidade').html('<option value="">Selecione o estado primeiro</option>');
                }
            });
        });
    </script>

</body>
</html>