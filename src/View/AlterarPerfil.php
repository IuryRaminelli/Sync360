<?php
session_start();
include_once "src/Controller/ConUser.php";
include_once "src/Model/User.php";

$ConUser = new ConUser();
$linha = $ConUser->selectLoginUser1($_SESSION["USER_LOGIN2"]);

if ($linha != null) {
    $user = new User($linha[0]);
    $nomeEstado = $ConUser->getNomeEstado($user->getIdEstado());
    $nomeCidade = $ConUser->getNomeCidade($user->getIdCidade());

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao']) && $_POST['acao'] === 'Alterar') {
        $User = new User();

        $idUser = $_POST['id_user'];
        $cpf = $_POST['cpf'];
        $nome = $_POST['nome'];
        $dataNascimento = $_POST['dataNascimento'];
        $email = $_POST['email'];
        $senha = isset($_POST['senha']) && !empty($_POST['senha']) ? $_POST['senha'] : null;
        $imagem = isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0 ? $_FILES['imagem'] : null;
        $rua = $_POST['rua'];
        $bairro = $_POST['bairro'];
        $biografia = $_POST['biografia'];
        $id_estado = $_POST['id_estado'];
        $id_cidade = $_POST['id_cidade'];
        $tipo = $_POST['tipo'] ?? $user->getTipo();

        // Setar os dados no objeto
        $User->setIdUser($idUser);
        $User->setCPF($cpf);
        $User->setNome($nome);
        $User->setDataNascimento($dataNascimento);
        $User->setEmail($email);
        $User->setSenha($senha);
        $User->setRua($rua);
        $User->setBiografia($biografia);
        $User->setBairro($bairro);
        $User->setIdEstado($id_estado);
        $User->setIdCidade($id_cidade);
        $User->setTipo($tipo);

        if ($imagem) {
            $target_dir = "src/View/img/";
            $target_file = $target_dir . basename($imagem['name']);
            $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($imagem['tmp_name'], $target_file)) {
                    $User->setImagem($target_file);
                } else {
                    echo "<script>alert('Erro ao enviar a imagem.');</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Tipo de imagem não permitido.');</script>";
                exit;
            }
        } else {
            $User->setImagem($user->getImagem());
        }

        if ($ConUser->alterarUser($User)) {
            echo "<script>alert('Alterado com sucesso!'); window.location.href = '" . HOME . "Perfil';</script>";
            exit();
        } else {
            echo "<script>alert('Erro ao alterar!');</script>";
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
    <?php include_once 'header.php'; ?>
    <div class="cor">
    <div class="container">
        <div class="container2">
            <form align="center" method="POST" enctype="multipart/form-data">

                <br><br>
                
                <h1 align="center" class="display-4">Editar Perfil</h1><br>
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" name="cpf" value="<?php echo $user->getCPF(); ?>" autofocus="true"/><br>

                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" value="<?php echo $user->getNome(); ?>" autofocus="true" /><br>

                <label for="biografia">Biografia</label>
                <textarea class="form-control" name="biografia" rows="5" autofocus="true"><?php echo $user->getBiografia(); ?></textarea><br>

                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user->getEmail(); ?>"/><br>

                <label for="dataNascimento">Data de Nascimento</label>
                <?php
                    if (!empty($user->getDataNascimento())) {
                        $dataOriginal = $user->getDataNascimento();
                        $data = DateTime::createFromFormat('Y-m-d', $dataOriginal);
                        if ($data !== false) {
                            $dataFormatada = $data->format('Y-m-d');
                        } else {
                            $dataFormatada = '';
                        }
                    } else {
                        $dataFormatada = '';
                    }
                ?>
                <input type="date" class="form-control" name="dataNascimento" value="<?= $dataFormatada; ?>" /><br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="id_estado">Estado</label>
                        <select class="form-control" name="id_estado" id="id_estado" required>
                            <option value="<?php echo $user->getIdEstado(); ?>"><?= htmlspecialchars($nomeEstado); ?></option>
                            <?php foreach ($resultado_estados as $estado) { ?>
                                <option value="<?= htmlspecialchars($estado['Uf']) ?>"><?= htmlspecialchars($estado['Nome']) ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="id_cidade">Cidade</label>
                        <select class="form-control" name="id_cidade" id="id_cidade" required>
                            <option value="<?php echo $user->getIdCidade(); ?>"><?= htmlspecialchars($nomeCidade); ?></option>
                        </select>
                    </div>
                </div>
                <br>

                <label for="rua">Rua</label>
                <input type="text" class="form-control" name="rua" value="<?php echo $user->getRua(); ?>"/><br>

                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" name="bairro" value="<?php echo $user->getBairro(); ?>"/><br>

                <label for="senha">Senha</label>
                <input type="password" class="form-control" name="senha" placeholder="Deixe em branco para não alterar"/><br>

                <label for="imagem">Foto de Perfil</label><br>
                <?php if (!empty($user->getImagem())): ?>
                    <img src="<?= $user->getImagem() ?>" alt="Foto" width="150" height="150" class="rounded-circle">
                <?php endif; ?>
                <br><br>
                <input type="file" class="form-control" name="imagem"/><br>

                <input type="hidden" name="id_user" value="<?= $user->getIdUser(); ?>">

                <br>
                <input type="submit" value="Alterar" class="btn" name="acao" />
            </form>
        </div>

    </div>
    <br><br>
    <script>
        $(document).ready(function () {
            function carregarCidades(estadoId, cidadeSelecionada) {
                if (estadoId) {
                    $.ajax({
                        type: 'POST',
                        url: '',
                        data: { id_estado: estadoId },
                        success: function (html) {
                            $('#id_cidade').html(html);

                            if (cidadeSelecionada) {
                                $('#id_cidade').val(cidadeSelecionada);
                            }
                        }
                    });
                } else {
                    $('#id_cidade').html('<option value="">Selecione o estado primeiro</option>');
                }
            }

            $('#id_estado').on('change', function () {
                var estadoId = $(this).val();
                carregarCidades(estadoId, null);
            });

            const estadoSalvo = '<?= $user->getIdEstado() ?>';
            const cidadeSalva = '<?= $user->getIdCidade() ?>';
            if (estadoSalvo) {
                carregarCidades(estadoSalvo, cidadeSalva);
            }
        });
    </script>

</body>
</html>

<?php
}
?>
