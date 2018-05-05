
function atualizaPainel() { //Para retornar os itens do menu cadastrados

    $.ajax({
        method: 'get',
        url: 'get_caixa.php',
        success: function(data) {
            //Inserir item_menu na div informado no item_menu
            $('#painel-caixa').html(data); //semelhante ao innerHtml do JS

        }
    });

}

$(document).ready( function(){

    $('#botao-buscar_nome_usuario').click( function() {

        if ( $('#buscar-nome-usuario').val().length > 0 ) {
            $.ajax({
                method: 'post',
                url: 'get_caixa.php',
                data: $('#form-buscar-nome-usuario').serialize(),
                success: function(data) {
                    $('#painel-caixa').html(data); //semelhante ao innerHtml do JS

                }
            })
        } else {
            atualizaPainel();
        }
    });


    atualizaPainel();

});


