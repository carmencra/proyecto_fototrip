$(document).ready(function () {
    $('.boton_desplegar').on('click', function (e) {
        e.preventDefault();
        $('.lista_despegable').slideToggle(500);
    }); 
    
    /* restablecer el menú predeterminado al pasar los pixeles determminados */
    $(window).resize(function () {
        if (innerWidth >= 480) {
            if ($('.lista_despegable').css('display') == 'none') {
                $('.lista_despegable').removeAttr('style');
            }
        }
    }); 
});
