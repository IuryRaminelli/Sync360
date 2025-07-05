<?php
    include_once __DIR__ . '/Rotas.php';

    /* NORMAL */
    Rotas::add('/Home', '/View/home.php');

    /* CONTROLE */
    Rotas::add('/CadastroUser', 'View/INSERTUser.php');
    Rotas::add('/AlterarUser', 'View/UPDATEUser.php');
    Rotas::add('/VisualizarUser', 'View/SELECTUser.php');

    /* PERFIL */
    Rotas::add('/Login', 'View/login.php');
    Rotas::add('/Perfil', 'View/perfil.php');
    Rotas::add('/Sair', 'View/sair.php');

    Rotas::erro('View/404.php');
    Rotas::exec();
?>