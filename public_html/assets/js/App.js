$(document).ready(function(){
    let
        formAlteracaoUsuario = '#form-alterar-conta-usuario'
        , formExclusaoUsuario = '#form-excluir-conta-usuario'
        , idUsuario
        , nomeUsuario;

    $('#form-autenticacao').submit(function(e){
       e.preventDefault();
       let data = $(this).serialize() , url = $(this).attr('action');
       $.ajax({
           method:'POST'
           , data: data
           , dataType: 'JSON'
           , url : url
           , success: function (response) {
               let success = response.success || undefined , message = response.message || undefined , redirectURL = response.url || undefined;
               alert(message);
               if ((success) && (typeof redirectURL !== 'undefined')) {
                   $(location).attr('href',redirectURL);
               }
           } ,

       });
    });

    $('#form-criar-conta').submit(function (e){
       e.preventDefault();
        let data = $(this).serialize() , url = $(this).attr('action');
        $.ajax({
            method:'POST'
            , data: data
            , dataType: 'JSON'
            , url : url
            , success: function (response) {
                let success = response.success || undefined
                    , message = response.message || undefined
                    , redirectURL = response.redirect || undefined;
                alert(message);
                if ((success) && (typeof redirectURL !== 'undefined')) {
                    $(location).attr('href',redirectURL);
                }
            }
        });
    });

    $('#formulario-registro-usuario').submit(function(e){
        e.preventDefault();
        let form = $(this) , data = $(this).serialize() , url = $(this).attr('action');
        $.ajax({
            method:'POST'
            , data: data
            , dataType: 'JSON'
            , url : url
            , success: function (response) {
                let success = response.success || undefined , message = response.message || undefined;
                alert(message);
                if (success === true) {
                    form.trigger("reset");
                }
            }
        });
    });

    $('.btn-alterar-usuario').click(function(){
        idUsuario = $(this).data('id');
        $(this).closest('tr').each(function(){
            nomeUsuario = $(this).find("[data-filter='nome']").html();
        });
        $('#modal-alteracao-usuario').each(function(){
            $(this).find('form input[name="idUsuario"]').val(idUsuario);
            $(this).find('form input[name="nomeCompletoUsuario"]').val(nomeUsuario);
            $(this).modal('show');
        });
    });

    $(formAlteracaoUsuario).submit(function(e){
        e.preventDefault();
        let form = $(this) , data = $(this).serialize() , url = $(this).attr('action');
        $.ajax({
            method:'POST'
            , data: data
            , dataType: 'JSON'
            , url : url
            , success: function (response) {
                let success = response.success || undefined , message = response.message || undefined;
                alert(message);
                if ( success ===true) {
                    $(`[data-row='${idUsuario}']`).find("[data-filter='nome']").html($(form).find('input[name="nomeCompletoUsuario"]').val());
                    $('#modal-alteracao-usuario').modal('hide');
                }
            }
        });
    });

    $('.salvar-conta-usuario').click(function(){
        $(formAlteracaoUsuario).trigger('submit');
    });

    $('.btn-excluir-usuario').click(function(){
        idUsuario = $(this).data('id');
        $('#modal-exclusao-usuario').each(function(){
            $(this).find('form input[name="idUsuario"]').val(idUsuario);
            $(this).modal('show');
        });
    });

    $('.excluir-conta-usuario').click(function(){
        $(formExclusaoUsuario).trigger('submit');
    });

    $(formExclusaoUsuario).submit(function(e){
        e.preventDefault();
        let form = $(this) , data = $(this).serialize() , url = $(this).attr('action');
        $.ajax({
            method:'POST'
            , data: data
            , dataType: 'JSON'
            , url : url
            , success: function (response) {
                let success = response.success || undefined , message = response.message || undefined;
                alert(message);
                if ( success ===true) {
                    $(`[data-row='${idUsuario}']`).remove();
                    if ($('table').find('tr').length === 1) {
                        $('table').remove();
                    }
                    $('#modal-exclusao-usuario').modal('hide');
                }
            }
        });
    });
});