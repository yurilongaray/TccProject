
function atualizaPainel() {

    $.ajax({
        method: 'get',
        url: 'get_pedido.php',
        success: function(data) {
            //Inserir menu na div informada no Pedido
            $('#painel-pedido').html(data);
            $('#status-pedido').val(1);
        }
    });

}


function updatePedido(id_pedido) {

    console.log(id_pedido)

    $('#texto-update-pedido').html('Alterar Status do Pedido ' + id_pedido );
    $('#input-id-pedido').val(id_pedido);

    $('#botao-confirmar-update').click( function() {

        const status_pedido = $('[name=alterar_status]').val();

        //console.log(status_pedido, id_pedido);

        $.ajax({
            method: 'post',
            url: 'update_pedido.php',
            data: {
                update_id_pedido: id_pedido, 
                alterar_status: status_pedido,
            },
            success: function(data) {
                console.log(data);
                $('.close-update').click();
                atualizaPainel();
                $('#status-pedido').val(1);
            }

        });


    });

}

$(document).ready( function(){

    atualizaPainel();


    $('#botao-buscar-pedido').click( function() {

        if ( $('#buscar-pedido').val().length > 0 ) {

            $.ajax({
                method: 'post',
                url: 'get_pedido.php',
                data: $('#form-buscar-pedido').serialize(),
                success: function(data) {
                    $('#painel-pedido').html(data); //semelhante ao innerHtml do JS
                }
            })
        } else {
            atualizaPainel();
        }
    });

    $('#botao-buscar-status').click( function() {

        $.ajax({
            method: 'post',
            url: 'get_pedido.php',
            data: $('#form-buscar-status').serialize(),
            success: function(data) {
                $('#painel-pedido').html(data); //semelhante ao innerHtml do JS
            }
        })
    });

});