
<h2>Registro de usuario</h2>

<!-- 
    aquí súper importante
    en el action
    cambiar -env
    eso es con:
    < ?=$_ENV['BASE_URL']?>usuario/register
    (huntando < y ?)

    (esto es porque así se va a la ruta tal cual,
    con el .env, llama a la función del controller)
 -->


<form action="<?=$_ENV['BASE_URL']?>usuario/register" method="POST">

    <label for="email">Email: </label>
    <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" style="width:300px">

    <br><br>

    <label for="clave">Contraseña: </label>
    <input type="password" name="data[clave]">

    <br><br>

    <label for="nombre">Nombre: </label>
    <input type="text" name="data[nombre]" value="<?php if (isset($_POST['data']['nombre']))echo $_POST['data']['nombre'];?>">

    <br><br>

    <label for="apellidos">Apellidos: </label>
    <input type="text" name="data[apellidos]" value="<?php if (isset($_POST['data']['apellidos']))echo $_POST['data']['apellidos'];?>">

    <br><br>

    <input type="submit" value="Registrarse">
</form>



<?php
    use Utils\Utils;

    if (isset($_SESSION['registro']) && $_SESSION['registro'] == 'failed'): 
?>
        <h3 style='color:red'>REGISTRO FALLIDO</h3>

<?php 
    endif;
    
    
    Utils::deleteSession('registro');

    if (isset($_SESSION['err_reg'])) {
        echo "<span style='color:red'>".$_SESSION['err_reg']."</span>";
        
    Utils::deleteSession('err_reg');
    }
?>