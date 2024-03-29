 <!--  si no hay usuario, muestra el registro -->
 <?php if (!isset($_SESSION['usuario'])): ?>
    <button class="boton_usuario">
        <a href="<?=$_ENV['BASE_URL']?>usuario/registrarse">Registro</a>
    </button>


<?php elseif (isset($_SESSION['usuario'])) :
    // si es el admin, muestra la pantalla de administrar
    if (isset($_SESSION['admin'])): ?>
        <button onclick="despliega_usuario()" class="boton_usuario">
         <?php if(isset($_SESSION['usuario'])) { echo $_SESSION['usuario']; }?> 
        </button>
            <div id="lista_usuario" class="contenido_lista">
                <a href="<?=$_ENV['BASE_URL']?>administrar">Administrar</a>
                <a href="<?=$_ENV['BASE_URL']?>usuario/cerrar">Salir</a>
            </div>
    <!-- si es un usuario normal, muestra ver sus viajes y cerrar sesión -->
    <?php else :?>
        <button onclick="despliega_usuario()" class="boton_usuario"> 
            <?php if(isset($_SESSION['usuario'])) { echo $_SESSION['nombre_usuario']; }?> 
        </button>
            <div id="lista_usuario" class="contenido_lista">
                <a href="<?=$_ENV['BASE_URL']?>misviajes">Mis viajes</a>
                <a href="<?=$_ENV['BASE_URL']?>usuario/cerrar">Salir</a>
            </div>
    <?php endif;?>
<?php endif;?>