$( document ).ready(function($) {
    $('#cpf').mask('000.000.000-00', {reverse: true});
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#ie').mask('000.000.000.000');
    $('#telefone').mask('(00) 0000-0000');
    $('#valor_diaria').mask('000.000.000.000.000,00', {reverse: true})
    // Para aplicar a mascara correta dependendo da quantidade de numeros do celular
    var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
       },
       options = {onKeyPress: function(val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
        }
       };
       $('#celular').mask(maskBehavior, options);
});