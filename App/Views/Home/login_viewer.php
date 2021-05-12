<!doctype html>
<html lang="pt-BR" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="pragma" content="no-cache">
        <title>Tela de autenticação</title>
        <!-- Bootstrap core CSS -->
        <link href="<?= Url::baseURL('assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

        <!-- Login CSS -->
        <link href="<?= Url::baseURL('assets/css/login.css') ?>" rel="stylesheet">
    </head>
    <body class="text-center">
        <form class="form-signin" id="form-autenticacao" action="<?=Url::baseURL('usuario/autenticar')?>">
            <img class="mb-4" src="https://imagens.canaltech.com.br/empresas/5193.400.jpg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Tela de Autenticação</h1>
            <label for="endereco_email" class="sr-only">Endereço de e-mail</label>
            <input type="email" id="login_acesso" name="login_acesso" class="form-control" placeholder="exemplo@kabum.com.br" required autofocus>
            <label for="senha_acesso"  class="sr-only">Senha</label>
            <input type="password" id="senha_acesso" name="senha_acesso" class="form-control" placeholder="Senha" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Logar</button>
            <p><a href="<?=Url::baseURL('usuario/criar-cadastro')?>">Criar cadastro</a></p>
        </form>
        <script src="<?=Url::baseURL("assets/js/jquery-3.6.0.min.js")?>"></script>
        <script src="<?=Url::baseURL("assets/js/App.js")?>"></script>
    </body>
</html>

