<title>Fototrip - Guardar imagen</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<!-- si se ha intentado guardar una imagen, muestra si ha ocurrido algún error, si se completa, lo indica en la página de administrar  -->
<?php use Utils\Utils;
    if(isset($_SESSION['imagen_creada']) && $_SESSION['imagen_creada'] == false): ?>
        <script type="text/javascript">
            alert("Ha habido un error al guardar la imagen.");
            window.close();
        </script>
    
        <?php
        Utils::deleteSession('imagen_creada');
     endif;
?>

<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<script>
    var base_url = '<?= $_ENV['BASE_URL']?>';
    var ruta_pagina = 'imagen/crear';

    if (!window.location.href.startsWith(base_url) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = base_url + ruta_pagina;
    }
</script>

<?php        
    // guardamos los valores del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $select_tipo= $_POST['data']['tipo'];
        $_SESSION['data_tipo']= $select_tipo;
        
        $select_viaje= $_POST['data']['viaje'];
        $_SESSION['data_viaje']= $select_viaje;
        
        $select_fecha= $_POST['data']['fecha'];
        $_SESSION['data_fecha']= $select_fecha;
    }    
?>


<main>
    <section class="contenido_main">
        
  
        <form action="<?=$_ENV['BASE_URL']?>imagen/guardar" method="POST" enctype="multipart/form-data" class="form_crear" id="myForm">
            <h1>Guardar imagen</h1>    
            <hr> <br>

            <label for="viaje">Viaje: </label>
            <select name="data[viaje]" id="viaje_seleccionado">
                <?php $datos_viaje= [];
                foreach ($viajes as $viaje) :
                    // obtenemos los datos del viaje seleccionado
                    $datos_viaje[$viaje->getId()]= [
                        'fecha_inicio' => $viaje->getFecha_inicio(),
                        'fecha_fin' => $viaje->getFecha_fin()
                    ]; ?>
                    <option value="<?= $viaje->getId() ?>" <?php if (isset($_SESSION['data_viaje']) && $_SESSION['data_viaje'] == $viaje->getId()) echo "selected"; ?> >
                        <?= $viaje->getPais() ?>
                    </option>
                <?php endforeach; ?>
            </select> 
            
            <br><br>

            <label for="tipo">Tipo: </label>
            <select name="data[tipo]">
                <option value="naturaleza" <?php if (isset($_SESSION['data_tipo']) && $_SESSION['data_tipo']== "naturaleza") echo "selected"; ?>>Naturaleza</option>
                <option value="construcciones" <?php if (isset($_SESSION['data_tipo']) && $_SESSION['data_tipo']== "construcciones") echo "selected"; ?>>Construcciones</option>
                <option value="animales" <?php if (isset($_SESSION['data_tipo']) && $_SESSION['data_tipo']== "animales") echo "selected"; ?>>Animales</option>
                <option value="personas" <?php if (isset($_SESSION['data_tipo']) && $_SESSION['data_tipo']== "personas") echo "selected"; ?>>Personas</option>
            </select>

            <br><br>

            <label for="fecha">Fecha: </label>
            <input type="date" name="data[fecha]" value="<?php if (isset($_SESSION['data_fecha']))echo $_SESSION['data_fecha'];?>">

            <br>
            
            ( <span id="span_fecha_inicio">
                <?php if (isset($_SESSION['data']['viaje']) && isset($datos_viaje[$_SESSION['data']['viaje']])) {
                    echo $datos_viaje[$_SESSION['data']['viaje']]['fecha_inicio'];
                } ?>
            </span>
            / 
            <span id="span_fecha_fin">
                <?php if (isset($_SESSION['data']['viaje']) && isset($datos_viaje[$_SESSION['data']['viaje']])) {
                    echo $datos_viaje[$_SESSION['data']['viaje']]['fecha_fin'];
                } ?>
            </span> )

            <br><span style="color:red"> <?php if(isset($_SESSION['err_fec'])) echo  $_SESSION['err_fec']?> </span>

            <br><br>

            <label for="imagen">Imagen: </label>
            <input type="file" name="imagen" accept="image/*">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_img'])) echo  $_SESSION['err_img']?> </span>

            <br><br>

            <input type="submit" value="Guardar" class="crear boton_resaltar">
        
        </form>

    </section>


<!-- para poner la fecha del viaje seleccionado -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var viaje_seleccionado= document.querySelector('select[name="data[viaje]"]');

        var span_fecha_inicio= document.getElementById('span_fecha_inicio');
        var span_fecha_fin= document.getElementById('span_fecha_fin');

        var datos_viaje= <?= json_encode($datos_viaje) ?>;

        actualizar_fechas_viaje();

        // coge el evento de cada vez que se cambia la opción del select de viajes
        viaje_seleccionado.addEventListener('change', function() {
        actualizar_fechas_viaje();
        });

        // actualiza las fechas impresas según las del viaje selecionado
        function actualizar_fechas_viaje() {
            var id_viaje_actual= viaje_seleccionado.value;
            var fechas= datos_viaje[id_viaje_actual];

            span_fecha_inicio.textContent= fechas.fecha_inicio;
            span_fecha_fin.textContent= fechas.fecha_fin;
        }
    });
</script>


<?php require_once('views/layout/footer_sub_main.php'); ?>
