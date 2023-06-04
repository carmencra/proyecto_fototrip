<title>Fototrip - Guardar imagen</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<!-- si se ha intentado guardar una imagen, nos muestra el resultado de la operación  -->
<?php 
    if(isset($_SESSION['imagen_creada'])):
        if ($_SESSION['imagen_creada'] == true) : ?>
            <script type="text/javascript">
                alert("Se ha guardado la imagen.");
                window.close();
            </script>
            
        <?php else: ?>
            <script type="text/javascript">
                alert("Ha habido un error al guardar la imagen.");
                window.close();
            </script>
        <?php endif;
    endif; 
?>

<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<script>
    console.log(window.location.href);
    var baseUrl = 'http://localhost/fototrip/';
    var ruta_pagina = 'imagen/crear';

    if (!window.location.href.startsWith(baseUrl) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = baseUrl + ruta_pagina;
    }
</script>

<main>
    <section class="contenido_main">
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
                    <option value="<?= $viaje->getId() ?>" <?php if ($_SESSION['data_viaje'] == $viaje->getId()) echo "selected"; ?> >
                        <?= $viaje->getPais() ?>
                    </option>
                <?php endforeach; ?>
            </select> 
            
            <br><br>

            <label for="tipo">Tipo: </label>
            <select name="data[tipo]">
                <option value="naturaleza" <?php if ($_SESSION['data_tipo'] == "naturaleza") echo "selected"; ?>>Naturaleza</option>
                <option value="construcciones" <?php if ($_SESSION['data_tipo'] == "construcciones") echo "selected"; ?>>Construcciones</option>
                <option value="animales" <?php if ($_SESSION['data_tipo'] == "animales") echo "selected"; ?>>Animales</option>
                <option value="personas" <?php if ($_SESSION['data_tipo'] == "personas") echo "selected"; ?>>Personas</option>
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

            <br><br><br>

            <input type="submit" value="Guardar" class="crear">
        
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


<?php 
    use Utils\Utils;
    Utils::deleteSession('imagen_creada');

    require_once('views/layout/footer_sub_main.php'); 
?>
