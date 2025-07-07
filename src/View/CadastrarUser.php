<?php
session_start();

include_once __DIR__ . "/../Controller/ConUser.php";
include_once __DIR__ . "/../Model/User.php";
include_once __DIR__ . '/../Rotas/Constantes.php';


if (isset($_POST['cadastro'])) {
    $target_dir = "src/View/img/";

    if (empty($_POST['cpf']) || empty($_POST['nome']) || empty($_POST['dataNascimento']) || empty($_POST['email']) ||
    empty($_POST['senha']) || empty($_POST['imagem']) || empty($_POST['biografia']) ||
    empty($_POST['rua']) || empty($_POST['bairro']) || empty($_POST['id_estado']) || empty($_POST['id_cidade'])) {
        echo "<script>alert('Todos os campos são obrigatórios.'); window.location.href = '" . HOME . "CadastrarUser';</script>";
        exit;
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('E-mail inválido.'); window.location.href = '" . HOME . "CadastrarUser';</script>";
        exit;
    }

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $name = $_FILES['imagem']['name'];
        $target_file = $target_dir . basename($name);
        $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
                $tipo = 'normal';

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


                if ($ConUser->insertUser($User)) {
                    echo "<script>alert('Cadastrado com sucesso!'); window.location.href = '" . HOME . "Login';</script>";
                } else {
                    echo "<script>alert('Erro ao se cadastrar.'); window.location.href = '" . HOME . "CadastrarUser';</script>";
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

        .formLogin select {
        padding: 15px;
        font-size: 14px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        margin-top: 5px;
        border-radius: 4px;
        transition: all linear 160ms;
        outline: none;
        width: 100%;
        box-sizing: border-box;
        }

        .formLogin select:focus {
        border-color: #1f2937;
        }

        .formLogin textarea {
        padding: 15px;
        font-size: 14px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        margin-top: 5px;
        border-radius: 4px;
        transition: all linear 160ms;
        outline: none;
        width: 100%;
        box-sizing: border-box;
        resize: vertical;
        }

        .formLogin textarea:focus {
        border-color: #1f2937;
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
            <form action="<?= HOME ?>CadastrarUser" class="formLogin" method="POST" enctype="multipart/form-data">
                 <h1 align="center" class="display-4">CADASTRO</h1><br>
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" placeholder="Digite seu CPF" autofocus="true" />
                <label for="nome">Nome</label>
                <input type="text" name="nome" placeholder="Digite seu Nome" autofocus="true" />

                <label for="biografia">Biografia</label>
                <textarea name="biografia" rows="5" placeholder="Digite uma biografia" autofocus="true"></textarea>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Digite seu e-mail" autofocus="true" />
                <label for="dataNascimento">Data de Nascimento</label>
                <input type="date" name="dataNascimento" autofocus="true" />
                
                <div class="row">
                    <div class="col-md-6">
                        <label for="id_estado">Estado</label>
                        <select name="id_estado" id="id_estado" required>
                            <option value="">Selecione seu estado</option>
                            <?php foreach ($resultado_estados as $estado) { ?>
                                <option value="<?= htmlspecialchars($estado['Uf']) ?>"><?= htmlspecialchars($estado['Nome']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_cidade">Cidade</label>
                        <select name="id_cidade" id="id_cidade" required>
                            <option value="">Selecione sua cidade</option>
                        </select>
                    </div>
                </div>

                <label for="rua">Rua</label>
                <input type="text" name="rua" placeholder="Digite sua rua"/>

                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" placeholder="Digite seu bairro"/>

                <label for="senha">Senha</label>
                <input type="password" name="senha" placeholder="Digite sua senha" />
                <label for="imagem">Foto de Perfil</label>
                <input type="file" name="imagem"/>
                <input type="submit" value="Cadastrar" class="btn" name="cadastro"/>
            </form>
        </div>
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