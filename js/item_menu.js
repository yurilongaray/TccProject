

function capturaJson() {
    $.ajax({
        type: 'get',
        url: 'http://rest-service.guides.spring.io/greeting',
        success: function(data) {
            console.log(data.id);
            console.log(data.content);
        }

   });
}


function atualizaPainel() { //Para retornar os itens do menu cadastrados

    $.ajax({
        method: 'get',
        url: 'get_item_menu.php',
        success: function(data) {
            //Inserir item_menu na div informado no item_menu
            $('#painel-item-menu').html(data); //semelhante ao innerHtml do JS

        }
    });

}

//Limpar dados dos campos
function clearItem() {

    $('#id-item').val(0);
    $('#nome-item').val('');
    $('#descricao-item').val('');
    $('[data-ingrediente_check]').prop('checked', false);
    $('#serve-item').val('');
    $('#preco-item').val('');
    $('#imagem-item').css('color','#333');
    $('#imagem-item').val('');
    $('.botao-aba-principal').addClass('active');
    $('.botao-aba-ingredientes').removeClass('active')
    $('.aba-principal').fadeIn();
    $('.aba-ingredientes').fadeOut();
    $('#botao-insert-item').html('Adicionar');
    $('#id-confirmar-delete').val('');

}

//Apenas preenche o modal do delete
function deleteItem(id_item_menu) {

    $('#texto-confirmar-delete').html('Deseja excluir o Item ' + id_item_menu + ' ?');
    $('#id-confirmar-delete').val(id_item_menu);

}

function confirmaDelete() {

    $.ajax({
        url: 'delete_item_menu.php',
        method: 'post',
        data: { delete_id_item_menu: $('#id-confirmar-delete').val() }, //Esta variável será enviada ao POST
        success: function(data) {
            $('.botao_close').click(); //disparando um click para fechar
            alert(data);
            atualizaPainel();
        }
    });

}



function buscarDados(id_item_menu, nome_item_menu, descricao_item_menu, ingrediente_item_menu, serve_qtd_pessoa, preco_item_menu) {

    $('#form-modal-item-menu').modal('show'); //Para apresentar o modal

    console.log(id_item_menu, nome_item_menu, descricao_item_menu, ingrediente_item_menu, serve_qtd_pessoa, preco_item_menu);

    //$("input[type=checkbox][name='ingrediente_item_menu[]']:checked").each(function(){         
           
    var lista_ingrediente = ingrediente_item_menu.split(','); //Explode do php = split do Js

    console.log(ingrediente_item_menu);

    //Verificando se a lista de ingredientes é vazia
    if ( ingrediente_item_menu != '' ) {

        console.log(lista_ingrediente);
        //DESSA FORMA O CHECKBOX SERÁ MARCADO $('[data-ingredient=Feijão]').prop('checked', true);
        //Para deixar check todos os valores puxados do BD
        lista_ingrediente.forEach( ingrediente => {
            $('[data-ingrediente_check=' + ingrediente + ']').prop('checked', true);
        });
    }

    $('#id-item').val(id_item_menu);
    $('#nome-item').val(nome_item_menu);
    $('#descricao-item').val(descricao_item_menu);
    $('#serve-item').val(serve_qtd_pessoa);
    $('#preco-item').val(preco_item_menu);

    $('.botao_close').click( function() {
        clearItem();
    });

    $('#botao-insert-item').html('Alterar');

}


function changeForm() {

    //Efetuando a troca de formulário, ativando o formulário de login e desativando o de registro
    $('.botao-aba-principal').click(function(e) {
        $('.aba-principal').delay(100).fadeIn(100);
        $('.aba-ingredientes').fadeOut(100);
        $('.botao-aba-ingredientes').removeClass('active');
        $(this).addClass('active'); 
        $(document).keypress(function(e) {
            if(e.which == 13) $('.botao-insert-item').click(); //Quando clicar no Enter selecionar o botão Adicionar
        });
        e.preventDefault();
    });

    //Efetuando a troca de formulário, ativando o formulário de registro e desativando o de login
    $('.botao-aba-ingredientes').click(function(e) {
        $('.aba-ingredientes').delay(100).fadeIn(100);
        $('.aba-principal').fadeOut(100);
        $('.botao-aba-principal').removeClass('active');
        $(this).addClass('active');
        $(document).keypress(function(e) {
            if(e.which == 13) $('.botao-insert-item').click(); //Quando clicar no Enter selecionar o botão Adicionar também
        });
        e.preventDefault();
    });
}

function insertItem() {

    //Enviar insert
    var form_data = new FormData();
    var ingrediente_item_menu = new Array();

    $("input[type=checkbox][name='ingrediente_item_menu[]']:checked").each(function(){         
        ingrediente_item_menu.push($(this).val());                    
    });

    //alert (ingrediente_item_menu);

    form_data.append('id_item_menu',          $('#id-item').val());
    form_data.append('imagem_item_menu',      $('#imagem-item').prop('files')[0]);
    form_data.append('nome_item_menu',        $('#nome-item').val());
    form_data.append('descricao_item_menu',   $('#descricao-item').val());
    form_data.append('serve_qtd_pessoa',      $('#serve-item').val());
    form_data.append('preco_item_menu',       $('#preco-item').val());
    form_data.append('ingrediente_item_menu', ingrediente_item_menu);

    
    if ( ( $('#nome-item').val() != "" ) && ( $('#descricao-item').val() != "" )
        &&  ( $('#serve-item').val() != "" ) && ( $('#preco-item').val() != "" ) 
        && ( $('#imagem-item').val() != "" ) ) { //Verificando se o campo possui conteudo

        $.ajax({
        url: 'iu_item_menu.php',
        method: 'post',
        cache: false,
        contentType: false,
        processData: false, 
        data: form_data, 
        //$('#form-item-menu').serialize(), //dessa forma pegará todos os names das inputs
        success: function(data) { // caso haja sucesso

            //console.log(data);
            $('.botao_close').click(); //disparando um click para fechar
            clearItem();
            console.log(data);
            atualizaPainel();

            }
        });

    } else {
        alert('Existem campos vazios!');

    }
}

$(document).ready( function(){

    atualizaPainel();

    changeForm();

    $('#botao-buscar_item_menu').click( function() {

        if ( $('#buscar-item-menu').val().length > 0 ) {
            $.ajax({
                method: 'post',
                url: 'get_item_menu.php',
                data: $('#form-buscar-item-menu').serialize(),
                success: function(data) {
                    $('#painel-item-menu').html(data); //semelhante ao innerHtml do JS

                }
            })
        } else {
            atualizaPainel();
        }
    });


    // Função para modificar imagem antes da validação, IMPORTANTE PARA INSERÇÃO DE IMAGEM
    $(function() {

        $("#imagem-item").change(function() {
            var file        = this.files[0];
            var imagefile   = file.type;
            var match       = ["image/jpeg","image/png","image/jpg"];
            if( !((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])) && $('input[type=file]').val() != "" ) {
                alert('Formato inválido!');                
                $("#imagem-item").css("color","red");
                $('#botao-insert-item').hide();
            } else {
                var reader = new FileReader();
                reader.onload = imageIsLoaded; // Para executar a função imageIsLoaded 
                reader.readAsDataURL(this.files[0]);
                imagem_item_menu = file['name'];
                return imagem_item_menu;
            }
        });

    });


    function imageIsLoaded(e) { //Quando a imagem for carregada, alterar a cor para verde do nome
        $("#imagem-item").css("color","green");
        $('#botao-insert-item').show();
    };

    capturaJson();

});


