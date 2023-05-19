
<?php require_once('views/layout/header_base.php'); ?>

<main>
    <section class="contenido_main">

    
        <fieldset>
            <legend> <h2>Registro de usuario</h2> </legend>
        

            <form action="<?=$_ENV['BASE_URL']?>usuario/registro" method="POST">

                <label for="email">Email: </label>
                <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" style="width:300px">
                <br><span style="color:red"> <?php if(isset($_SESSION['err_ema'])) echo  $_SESSION['err_ema']?> </span>

                <br><br>

                <label for="clave">Contraseña: </label>
                <input type="password" name="data[clave]" value="<?php if (isset($_POST['data']['clave']))echo $_POST['data']['clave'];?>">
                <br><span style="color:red"> <?php if(isset($_SESSION['err_cla'])) echo  $_SESSION['err_cla']?> </span>

                <br><br>

                <label for="nombre">Nombre: </label>
                <input type="text" name="data[nombre]" value="<?php if (isset($_POST['data']['nombre']))echo $_POST['data']['nombre'];?>">
                <br><span style="color:red"> <?php if(isset($_SESSION['err_nom'])) echo  $_SESSION['err_nom']?> </span>

                <br><br>

                <label for="apellidos">Apellidos: </label>
                <input type="text" name="data[apellidos]" value="<?php if (isset($_POST['data']['apellidos']))echo $_POST['data']['apellidos'];?>">
                <br><span style="color:red"> <?php if(isset($_SESSION['err_ape'])) echo  $_SESSION['err_ape']?> </span>

                <br><br>

                <input type="submit" value="Registrarse">
            </form>

        </fieldset>

    </section>



    <?php
        use Utils\Utils;

        if (isset($_SESSION['err_reg'])): 
    ?>
            <h3 style='color:red'>REGISTRO FALLIDO</h3>

    <?php 
        endif;
    ?>
