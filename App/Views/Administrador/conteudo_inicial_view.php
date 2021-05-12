<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Lista de usuários</h1>
        <div class="d-flex flex-row-reverse bd-highlight">
            <div class="p-2 bd-highlight"><a class="btn btn-primary"
                                             href="<?= Url::baseUrl('administrador/usuario/adicionar-novo-usuario') ?>">Adicionar
                    novo usuário</a></div>
        </div>
        <?php
        if ((isset($listaUsuarios)) && (is_array($listaUsuarios)) && (count($listaUsuarios)>0)):
            ?>
            <table class="table">
                <thead>
                <tr>
                    <th>Nome usuário</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($listaUsuarios as $item) {
                    printf("<tr data-row=\"%s\"><td data-filter=\"nome\">%s</td><td data-filter=\"email\">%s</td><td><div class=\"btn-group\" role=\"group\"><button type=\"button\" class=\"btn btn-warning btn-alterar-usuario\" data-id=\"%s\">Alterar</button><button type=\"button\" class=\"btn btn-danger btn-excluir-usuario\" data-id=\"%s\">Excluir</button></div></td></tr>", $item['id'], $item['nome_completo'], $item['email'], $item['id'], $item['id']);
                }
                ?>
                </tbody>
            </table>
        <?php
        else :?>
            Não há registro de usuários cadastrados
        <?php
        endif;
        ?>
    </div>
</main>
<div class="modal fade" id="modal-alteracao-usuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alteração de dados usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-alterar-conta-usuario"
                      action="<?= Url::baseUrl("administrador/usuario/alterar-dados-usuario") ?>">
                    <input type="hidden" name="idUsuario">
                    <div class="mb-3">
                        <label for="nomeCompletoUsuario" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" placeholder="informe teu nome completo"
                               name="nomeCompletoUsuario" id="nomeCompletoUsuario" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary salvar-conta-usuario">Salvar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-exclusao-usuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Excluir usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-excluir-conta-usuario"
                      action="<?= Url::baseUrl("administrador/usuario/excluir-usuario") ?>">
                    <input type="hidden" name="idUsuario">
                    <p>Gostaria de continuar com a exclusão?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger excluir-conta-usuario">Sim</button>
            </div>
        </div>
    </div>
</div>
