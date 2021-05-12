<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Tela de cadastro de usuário</h1>
        <form class="form" role="form" method="post" id="formulario-registro-usuario" action="<?=Url::baseUrl("administrador/usuario/registrar-usuario")?>">
            <div class="mb-3">
                <label for="nomeCompletoUsuario" class="form-label">Nome completo</label>
                <input type="text" class="form-control" placeholder="informe teu nome completo"  name="nomeCompletoUsuario" id="nomeCompletoUsuario" required>
            </div>
            <div class="mb-3">
                <label for="emailUsuario" class="form-label">Endereço de email</label>
                <input type="email" class="form-control" placeholder="exemplo@kabum.com.br" name="emailUsuario" id="emailUsuario" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" id="senhaUsuario" name="senhaUsuario" placeholder="senha para acesso" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</main>