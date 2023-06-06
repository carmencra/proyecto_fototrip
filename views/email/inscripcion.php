<title>Fototrip - Inscripción realizada</title>

<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<script>
    console.log(window.location.href);
    var baseUrl = 'http://localhost/fototrip/';
    var ruta_pagina = 'email/inscripcion';

    if (!window.location.href.startsWith(baseUrl) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = baseUrl + ruta_pagina;
    }
</script>

<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">

        <fieldset>
            <br>
            <p>Se ha enviado un correo con los datos de la inscripci&oacute;n a <b><?= $_SESSION['usuario'] ?></b>.</p>

            <p>Puede cerrar esta pestaña. Desde el correo podr&aacute; acceder al enlace donde encontrar&aacute; los viajes a los que est&aacute; inscrito.</p>

        </fieldset>

    </section>
    
<?php require_once('views/layout/footer_sub_main.php'); ?>
