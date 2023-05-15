// /*Cuando se hace click en el botón, muestra el submenu*/
// function despliega_usuario() {   
//     //Añade una clase al elemento que tenga el id myDropdown
//     document.getElementById("menu_usuario").classList.toggle("show");
//   }
  
//   //Cierra el submenu si se clica fuera
//   window.onclick = function(event){
//     if(!event.target.matches('.boton_usuario')) {
//       var enlaces_usuario = document.getElementsByClassName("contenido_usuario");
//       var i;
//       for (i = 0;  i < enlaces_usuario.length; i++) {
//         var enlace = enlaces_usuario[i];
//         //Busca dentro de drop-content los elementos con la clase show
//         if (enlace.classList.contains('show')){
//           //elimina la clase show de los elementos dentro de drop-content
//           enlace.classList.remove('show');
//         }
//       }
//     }
//   }

//   tal cual

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

/* <div class="menu_usuario">
            <button onclick="despliega_usuario()" class="boton_usuario">Registro</button>
            <div id="lista_usuario" class="contenido_lista">
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
            </div>
        </div>
        <!-- <div class="dropdown">
            <button onclick="myFunction()" class="drop-button">Dropdown</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#">Link 1</a>
                <a href="#">Link 2</a>
                <a href="#">Link 3</a>
            </div>
</div>  */