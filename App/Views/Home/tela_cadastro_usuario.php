<!doctype html>
<html lang="pt-BR" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="pragma" content="no-cache">
    <title>Tela de Cadastro</title>
    <!-- Bootstrap core CSS -->
    <link href="<?= Url::baseURL('assets/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- Login CSS -->
    <link href="<?= Url::baseURL('assets/css/login.css') ?>" rel="stylesheet">
</head>
<body class="text-center">
<div class="row d-flex justify-content-center">
    <div class="col-md">
        <form method="post" id="form-criar-conta" action="<?= Url::baseURL('usuario/registrar-conta') ?>" oninput="confirmacao_senha_acesso.setCustomValidity(confirmacao_senha_acesso.value !== senha_acesso.value ? 'Senhas não conferem' : '')">
            <div class="card p-4 py-5">
                <h2>Crie tua conta!</h2>
                <div class="signup mt-3">
                    <input type="email" name="login_acesso" class="form-control" placeholder="seuemail@dominio.com.br" required>
                    <input type="text" name="nome_completo" class="form-control" placeholder="Nome completo" required>
                    <input type="password" name="senha_acesso" class="form-control" placeholder="Senha" required>
                    <input type="password" name="confirmacao_senha_acesso" class="form-control" placeholder="Confirme a senha" required>
                </div>
                <div class="mt-4">
                    <button class="btn btn-info button btn-block" type="submit">Criar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= Url::baseURL("assets/js/jquery-3.6.0.min.js") ?>"></script>
<script src="<?= Url::baseURL("assets/js/App.js") ?>"></script>
</body>
</html>

