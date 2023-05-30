
$(document).ready(function() {
  // recoge el formulario de BORRAR VIAJE
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


  // recoge el formulario de BORRAR COMENTARIO
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


  // recoge el formulario de BORRAR IMAGEN
  $("form[id^='form_borrar_imagen_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres borrar esta imagen?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });

  
  // recoge el formulario de ACEPTAR IMAGEN
  $("form[id^='form_aceptar_imagen_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres aceptar(publicar) esta imagen?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });

  // recoge el formulario de DESCARTAR IMAGEN
  $("form[id^='form_descartar_imagen_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres descartar(publicar) esta imagen?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });


  // recoge el formulario de ACEPTAR COMENTARIO
  $("form[id^='form_aceptar_comentario_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres aceptar(publicar) este comentario?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });

  // recoge el formulario de DESCARTAR COMENTARIO
  $("form[id^='form_descartar_comentario_']").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario
    
    var form = this;
    
    // Verificar si se ha confirmado anteriormente
    if (!$(form).data('confirmed')) {
      var result = confirm("¿Quieres descartar(borrar) este comentario?");
      if (result) {
        $(form).data('confirmed', true); // Marcar como confirmado para evitar futuras ventanas emergentes
        form.submit(); // Enviar el formulario para redirigir al controlador
      }
    }
  });

});
