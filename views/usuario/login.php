
<link rel="stylesheet" href="../fuente/styles/fototrip.css">

<?php require_once('views/layout/header_base.php'); ?>

<main>
    <section class="contenido_main">

         <fieldset>
            <legend> <h2>Login de usuario</h2> </legend>

                <form action="<?=$_ENV['BASE_URL']?>usuario/login" method="POST">

                    <label for="email">Email: </label>
                    <input type="email" name="data[email]" value="<?php if (isset($_POST['data']['email']))echo $_POST['data']['email'];?>" style="width:300px">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_ema'])) echo  $_SESSION['err_ema']?> </span>

                    <br><br>

                    <label for="clave">Contraseña: </label>
                    <input type="password" name="data[clave]" value="<?php if (isset($_POST['data']['clave']))echo $_POST['data']['clave'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_cla'])) echo  $_SESSION['err_cla']?> </span>

                    <br><br>

                    <input type="submit" value="Registrarse">
                </form>
        </fieldset>

        

    </section>
    
