<?php
    include_once __DIR__ . '/Rotas.php';

    /* NORMAL */
    Rotas::add('/Home', '/View/home.php');

    /* CONTROLE */
    Rotas::add('/CadastrarUser', 'View/CadastrarUser.php');
    Rotas::add('/AlterarPerfil', 'View/AlterarPerfil.php');
    Rotas::add('/VisualizarUser', 'View/VisualizarUser.php');

    /* PERFIL */
    Rotas::add('/Login', 'View/login.php');
    Rotas::add('/Perfil', 'View/perfil.php');
    Rotas::add('/Sair', 'View/sair.php');

    Rotas::erro('View/404.php');
    Rotas::exec();
?>