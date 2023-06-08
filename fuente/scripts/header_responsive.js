$(document).ready(function () {
      
    /* Toggle menú de móviles  */
    $('#boton_desplegar').on('click', function (e) {
        e.preventDefault();
        $('#submenu').slideToggle(500);
    }); // fin click
    
    /* Hacer visible el menú al agrandar */
    $(window).resize(function () {
        if (innerWidth >= 480) {
            if ($('#submenu').css('display') == 'none') {
                $('#submenu').removeAttr('style');
            }
        }
    }); // fin resize
  });