
$(document).ready(function() {
  // recoge el formulario de borrar VIAJE
  $("form[id^='form_borrar_viaje_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres borrar este viaje?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });

  // recoge el formulario de borrar COMENTARIO
  $("form[id^='form_borrar_comentario_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres borrar este comentario?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });
});
