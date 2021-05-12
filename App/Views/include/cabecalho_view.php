<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <title>Painel Administrativo</title>
    <!-- Bootstrap core CSS -->
    <link href="<?= Url::baseUrl('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <style>
        main > .container {
            padding: 50px 25px 0;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Gerenciamento de Usuários</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-nav me-auto mb-2 mb-lg-0">
                <span class="navbar-text">
                    Seja bem-vindo(a)&nbsp;<?= (isset($nomeUsuario)) ? $nomeUsuario : "Nome??" ?>
                </span>
            </div>
            <form action="<?=Url::baseUrl('desconectar');?>" method="GET" class="d-flex">
                <button class="btn btn-outline-secondary" type="submit">Sair</button>
            </form>
        </div>
    </nav>
</header>
