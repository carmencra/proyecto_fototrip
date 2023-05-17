
<h2>Login</h2>

<form action="<?=$_ENV['BASE_URL']?>usuario/login" method="POST">

    <label for="email">Email: </label>
    <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" style="width:300px">

    <br><br>

    <label for="clave">Contraseña: </label>
    <input type="password" name="data[clave]">

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