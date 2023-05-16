<section class="buscador_imagenes">
    <form action="<?=$_ENV['BASE_URL']?>imagen/buscar" method="POST" enctype="multipart/form-data">

    <section>
        <label for="pais">Pa&iacute;s </label>
        <input type="text" name="data[pais]" id="pais"/>
    </section>

    <section>
        <label for="tipo">Tipo: </label>

        <select name="data[tipo]" value="<?php if (isset($_COOKIE['data']['tipo']))echo $_COOKIE['data']['tipo'];?>">
            <option value="indiferente"> Indiferente </option>
            <option value="naturaleza"> Naturaleza </option>
            <option value="construcciones"> Construcciones </option>
            <option value="animales"> Animales </option>
            <option value="personas"> Personas </option>
        </select>
    </section>
        
    <section>
        <label for="fecha">Fecha </label>
    
        <select name="data[fecha]" value="<?php if (isset($_COOKIE['data']['fecha']))echo $_COOKIE['data']['fecha'];?>">
            <option value="indiferente"> Indiferente </option>
            <option value="recientes"> M&aacute;s recientes </option>
            <option value="antiguas"> M&aacute;s antiguas </option>
        </select>
    </section>

        <input type="submit" value="Buscar" id="boton">
    </form>

</section>


<section class="imagenes">

    <?php foreach($imagenes as $imagen) : ?>
        <section class="imagen">
            <h4> <?= $imagen->getUsuario(); ?> </h4>

            <hr>

            <p class="imagen_imagen"> <?= $imagen->getImagen(); ?> </p>

            <p> <?= $imagen->getPais_viaje(); ?> </p>
            
            <p> <?= $imagen->getFecha(); ?> </p>
            
            <p> <?= $imagen->getTipo(); ?> </p>
            
        </section>

    <?php endforeach; ?>

</section>