$( document ).ready(function($) {
    $('#cpf').mask('000.000.000-00', {reverse: true});
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#ie').mask('000.000.000.000');
    $('#telefone').mask('(00)0000-0000');
    $('#valor_diaria').mask('000000000000000.00', {reverse: true})
    $('#celular').mask('(00)00000-0000');
});