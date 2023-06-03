<title>Fototrip - Guardar imagen</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<main>
    <section class="contenido_main">

        <?php if(isset($_SESSION['imagen_creada'])):
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
            <?php endif;?>     
        <?php endif;?>

        <?php
            // guardamos los valores de selects en las cookies
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $opcion_viaje = $_POST['data']['viaje'];
                setcookie("data_viaje", $opcion_viaje);
                
                $opcion_tipo = $_POST['data']['tipo'];
                setcookie("data_tipo", $opcion_tipo);

                $valor_fecha = $_POST['data']['fecha'];
                $_SESSION['data_fecha']= $valor_fecha;
            }

            // recogemos si hay alguna cookie de selecciones
            if (isset($_COOKIE['data_viaje'])) {
                $opcion_viaje= $_COOKIE['data_viaje'];
            } else {
                $opcion_viaje = ""; 
                // Valor predeterminado si no hay cookie
            } 
            
            if (isset($_COOKIE['data_tipo'])) {
                $opcion_tipo= $_COOKIE['data_tipo'];
            } else {
                $opcion_tipo = ""; 
                // Valor predeterminado si no hay cookie
            } 
        ?>

        <form action="<?=$_ENV['BASE_URL']?>imagen/crear" method="POST" enctype="multipart/form-data" class="form_crear">
            <h1>Guardar imagen</h1>    
            <hr> <br>

            <label for="viaje">Viaje: </label>
            <select name="data[viaje]">
                <?php foreach($viajes as $viaje): ?>
                    <option value="<?= $viaje->getId() ?>" <?php if ($opcion_viaje == $viaje->getId()) echo "selected"; ?>>
                        <?= $viaje->getPais() ?> 
                    </option>
                <?php endforeach; ?>
            </select> <br> <br>

            <label for="tipo">Tipo: </label>
            <select name="data[tipo]">
                <option value="naturaleza" <?php if ($opcion_tipo == "naturaleza") echo "selected"; ?>> Naturaleza </option>
                <option value="construcciones" <?php if ($opcion_tipo == "construcciones") echo "selected"; ?>> Construcciones </option>
                <option value="animales" <?php if ($opcion_tipo == "animales") echo "selected"; ?>> Animales </option>
                <option value="personas" <?php if ($opcion_tipo == "personas") echo "selected"; ?>> Personas </option>
            </select>

            <br><br>

            <label for="fecha">Fecha: </label>
            <input type="date" name="data[fecha]" value="<?php echo isset($_SESSION['data_fecha']) ? $_SESSION['data_fecha'] : ''; ?>">
            <br> (<?=$viaje->getFecha_inicio();?> / <?= $viaje->getFecha_fin();?>)
            <br><span style="color:red"> <?php if(isset($_SESSION['err_fec'])) echo  $_SESSION['err_fec']?> </span>

            <br><br>

            <label for="imagen">Imagen: </label>
            <input type="file" name="imagen" accept="image/*">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_img'])) echo  $_SESSION['err_img']?> </span>

            <br><br><br>

            <input type="submit" value="Guardar" class="crear">
        
        </form>

    </section>


<?php 
    use Utils\Utils;
    Utils::deleteSession('imagen_creada');

    require_once('views/layout/footer_sub_main.php'); 
?>


<!-- para crear imagen necesito:

pasar viajes-> opción id; value->país

tipos en select

coger el nombre de la imagen con extensión

como es el admin estará aceptada y el usuario el 1 de admin

comprobar si la fecha introducida está dentro del período del viaje
-->
