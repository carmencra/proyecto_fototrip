
<?php require_once('views/layout/header_main.php'); ?>

<main>
    <section class="contenido_main">

        <fieldset>
            <br>
            <p>Se ha enviado un correo de confirmaci&oacute;n a <b><?= $_SESSION['correo_a_confirmar'] ?></b>.</p>

            <p>Puede cerrar esta pestaña. Una vez confirme su cuenta, se le abrir&aacute; una nueva con la sesi&oacute;n ya iniciada.</p>
        </fieldset> <br><br><br>
    </section>
    
<?php require_once('views/layout/footer_main.php'); ?>
