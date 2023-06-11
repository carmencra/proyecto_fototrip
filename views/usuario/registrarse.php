<title>Fototrip - Registrarse</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">
        <section class="tipos_registro">

            <fieldset>
                <h2>Registrarse</h2>
            
                <hr> <br>
    
                <!-- registro -->
                <form action="<?=$_ENV['BASE_URL']?>usuario/registro" method="POST">
    
                    <label for="data[email]">Email: </label>
                    <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" class="input_email">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_ema'])) echo  $_SESSION['err_ema']?> </span>
    
                    <br><br>
    
                    <label for="data[clave]">Contraseña: </label>
                    <input type="password" name="data[clave]" value="<?php if (isset($_POST['data']['clave']))echo $_POST['data']['clave'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_cla'])) echo  $_SESSION['err_cla']?> </span>
    
                    <br><br>
    
                    <label for="data[nombre]">Nombre: </label>
                    <input type="text" name="data[nombre]" value="<?php if (isset($_POST['data']['nombre']))echo $_POST['data']['nombre'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_nom'])) echo  $_SESSION['err_nom']?> </span>
    
                    <br><br>
    
                    <label for="data[apellidos]">Apellidos: </label>
                    <input type="text" name="data[apellidos]" value="<?php if (isset($_POST['data']['apellidos']))echo $_POST['data']['apellidos'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_ape'])) echo  $_SESSION['err_ape']?> </span>
    
                    <br><br>
                    
                    <?php if (isset($_SESSION['err_reg'])): ?>
                        <span style='color:red'>*Registro fallido</span>
                        <br><br>
                    <?php endif; ?>
    
                    <section class="submit">
                        <input type="submit" value="Registrarse" class="boton_resaltar">
                    </section>    
                </form>
            </fieldset>


            <!-- login -->
            <fieldset>
            <h2>Iniciar sesi&oacute;n</h2>

            <hr> <br>

            <form action="<?=$_ENV['BASE_URL']?>usuario/login" method="POST">

                <label for="data[email]">Email: </label>
                <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" class="input_email">
                <br><span style="color:red"> <?php if(isset($_SESSION['err_ema'])) echo  $_SESSION['err_ema']?> </span>

                <br><br>

                <label for="data[clave]">Contraseña: </label>
                <input type="password" name="data[clave]" value="<?php if (isset($_POST['data']['clave']))echo $_POST['data']['clave'];?>">
                <br><span style="color:red"> <?php if(isset($_SESSION['err_cla'])) echo  $_SESSION['err_cla']?> </span>

                <br><br>

                <?php if (isset($_SESSION['err_log'])): ?>
                    <span style='color:red'>*Usuario no confirmado</span>
                    <br><br>
                <?php endif; ?>

                <section class="submit">
                    <input type="submit" value="Iniciar sesión" class="boton_resaltar">
                </section>
            </form>
            
        </fieldset>

        </section>


    </section>

<?php require_once('views/layout/footer_sub_main.php'); ?>
