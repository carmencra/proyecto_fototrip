/*Cuando se hace click en el botón, muestra el submenu*/
function despliega_usuario() {   
  //Añade una clase al elemento que tenga el id myDropdown
  document.getElementById("lista_usuario").classList.toggle("show");
}

//Cierra el submenu si se clica fuera
window.onclick = function(event){
  if(!event.target.matches('.boton_usuario')) {
    var dropdowns = document.getElementsByClassName("contenido_lista");
    var i;
    for (i = 0;  i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      //Busca dentro de drop-content los elementos con la clase show
      if (openDropdown.classList.contains('show')){
        //elimina la clase show de los elementos dentro de drop-content
        openDropdown.classList.remove('show');
      }
    }
  }
}
