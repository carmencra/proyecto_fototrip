
<link rel="stylesheet" href="fuente/styles/viaje.css">

<section class="buscador_viajes">
    <form action="<?=$_ENV['BASE_URL']?>viaje/buscar" method="POST" enctype="multipart/form-data">
        <label for="pais">Pa&iacute;s </label>
        <input type="text" name="data[pais]" id="pais"/>

        <label for="precio_min">Precio m&iacute;n: </label>
        <input type="text" name="data[precio_min]" id="min"/>
        
        <label for="precio_max">Precio m&aacute;x: </label>
        <input type="text" name="data[precio_max]" id="max"/>
        
        <label for="exigencia">Exigencia f&iacute;sica: </label>
        <input type="text" name="data[exigencia]" id="fisico"/>
        
        <label for="nivel">Nivel fotograf&iacute;a </label>
        <input type="text" name="data[nivel]" id="foto"/>

        <input type="submit" value="Buscar" id="boton">
    </form>

</section>


<section class="viajes">

    <?php foreach($viajes as $viaje) : ?>
        <section class="viaje">
            <p class="precio"> <?= $viaje->getPrecio(); ?> €</p>

            <h1 class="pais"> <?= $viaje->getPais(); ?> </h1>

            <p> <?= $viaje->getFecha_inicio(); ?> / <?= $viaje->getFecha_fin(); ?>
                ( <?= $viaje->getDuracion(); ?> d&iacute;as )
            </p>

            <p> <?= $viaje->getDescripcion(); ?> </p>

            <form action="<?=base_url.'viaje/ver&id='.$viaje->getId() ?>" method="GET">
                <input class="ver_mas" type="submit" value="ver más">
            </form>
        </section>

    <?php endforeach; ?>

</section>