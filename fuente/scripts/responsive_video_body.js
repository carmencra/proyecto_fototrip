function margen_video_main(){
    $('main').css("margin-top", $('header').height());
}

$(document).ready(margen_video_main);
$(window).resize(margen_video_main);
  