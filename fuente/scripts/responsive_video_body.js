function margen_video_main(){    
    $('#main_index').css("margin-top", $('header').height());
    $('.contenido_main').css("margin-top", $('header').height());
    $('#main_ver').css("margin-top",  $('.portada').height());
    // $('#contenido_main_ver').css("margin-top", ($('header').height() + $('.portada').height()));
}

$(document).ready(margen_video_main);
$(window).resize(margen_video_main);
  