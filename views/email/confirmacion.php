<title>Fototrip - Confirmar cuenta</title>

<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<script>
    console.log(window.location.href);
    var baseUrl = '<?= $_ENV['BASE_URL']?>';
    var ruta_pagina = 'email/confirmacion';

    if (!window.location.href.startsWith(baseUrl) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = baseUrl + ruta_pagina;
    }
</script>

<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">

        <fieldset>
            <br>
            <p>Se ha enviado un correo de confirmaci&oacute;n a <b><?= $_SESSION['correo_a_confirmar'] ?></b>.</p>

            <p>Puede cerrar esta pestaña. Una vez confirme su cuenta, se le abrir&aacute; una nueva con la sesi&oacute;n ya iniciada.</p>
        </fieldset> 

    </section>
    
<?php require_once('views/layout/footer_sub_main.php'); ?>
