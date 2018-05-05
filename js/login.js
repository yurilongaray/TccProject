
$(document).ready( function(){


    //Efetuando a troca de formulário, ativando o formulário de login e desativando o de registro
    $('#login-form-link').click(function(e) {
		$('#login-form').delay(100).fadeIn(100);
 		$('#register-form').fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
        $(document).keypress(function(e) {
            if(e.which == 13) $('#login-submit').click(); //Quando clicar no Enter selecionar o botão Entrar
        });
		e.preventDefault();
	});

    //Efetuando a troca de formulário, ativando o formulário de registro e desativando o de login
	$('#register-form-link').click(function(e) {
		$('#register-form').delay(100).fadeIn(100);
 		$('#login-form').fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
        $(document).keypress(function(e) {
            if(e.which == 13) $('#register-submit').click(); //Quando clicar no Enter selecionar o botão Registrar
        });
		e.preventDefault();
	});

	$('#username').focus(function() { //Evento para esconder os placeholders dos inputs
    	$('#username').removeAttr('placeholder');
    });

    $('#username').blur(function() {
    	$('#username').attr('placeholder', 'Usuario');
    });

    $('#password').focus(function() {
    	$('#password').removeAttr('placeholder');
    });

    $('#password').blur(function() {
    	$('#password').attr('placeholder', 'Senha');
    });

    $('#datepicker').datepicker({
        autoclose: true,
        toggleActive: true,
        language: "pt-BR"
    });


});