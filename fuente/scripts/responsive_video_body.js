function margen_video_main(){   
    $('.contenido_main').css("margin-top", $('header').height());
    $('.titulo_portada').css("margin-top",  $('header').height());
}

$(document).ready(margen_video_main);
$(window).resize(margen_video_main);
  