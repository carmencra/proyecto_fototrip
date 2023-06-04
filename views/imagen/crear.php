<title>Fototrip - Guardar imagen</title>

<?php require_once('views/layout/header_sub_main.php'); 

// Retrieve the values from session variables
if (isset($_SESSION['viajes'])) {
    $viajes = $_SESSION['viajes'];
}?>

<main>
    <section class="contenido_main">
        <!-- si se ha intentado guardar una imagen, nos muestra el resultado de la operación  -->
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
            <?php endif;
        endif;

        
        // recogemos si hay alguna cookie de selecciones
        // if (isset($_COOKIE['data_viaje'])) {
        //     $opcion_viaje= $_COOKIE['data_viaje'];
        // } else {
        //     $opcion_viaje = ""; 
        //     // Valor predeterminado si no hay cookie
        // } 
        
        // if (isset($_COOKIE['data_tipo'])) {
        //     $opcion_tipo= $_COOKIE['data_tipo'];
        // } else {
        //     $opcion_tipo = ""; 
        //     // Valor predeterminado si no hay cookie
        // } 

        // guardamos los valores de selects en las cookies
        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // $opcion_viaje = $_POST['data']['viaje'];
            // // setcookie("data_viaje", $opcion_viaje);
            // $_SESSION['data_viaje']= $opcion_viaje;
            
            // // setcookie("data_tipo", $opcion_tipo);
            // $opcion_tipo = $_POST['data']['tipo'];
            // $_SESSION['data_tipo'] = $opcion_tipo;

            // $valor_fecha = $_POST['data']['fecha'];
            // $_SESSION['data_fecha']= $valor_fecha;
        // }
  ?>
  
  


        <form action="<?=$_ENV['BASE_URL']?>imagen/crear" method="POST" enctype="multipart/form-data" class="form_crear" id="myForm">
            <h1>Guardar imagen</h1>    
            <hr> <br>

            <label for="viaje">Viaje: </label>
            <select name="data[viaje]">
                <?php foreach ($viajes as $viaje) :?>
                    <option value="<?= $viaje->getId() ?>" <?php if (isset($_SESSION['data']['viaje']) && $_SESSION['data']['viaje'] == $viaje->getId()) echo "selected"; ?>>
                    <?= $viaje->getPais() ?>
                    </option>
                <?php endforeach; ?> 
            </select> <br> <br>

            <label for="tipo">Tipo: </label>
            <!-- <select name="data[tipo]">
                <option value="naturaleza" < ?php if ($opcion_tipo === 'naturaleza') echo 'selected'; ?>>Naturaleza</option>
                <option value="construcciones" < ?php if ($opcion_tipo === 'construcciones') echo 'selected'; ?>>Construcciones</option>
                <option value="animales" < ?php if ($opcion_tipo === 'animales') echo 'selected'; ?>>Animales</option>
                <option value="personas" < ?php if ($opcion_tipo === 'personas') echo 'selected'; ?>>Personas</option>
            </select> -->
            <select name="mySelect" id="mySelect">
                <option value="naturaleza">Naturaleza</option>
                <option value="construcciones">Construcciones</option>
                <option value="animales">Animales</option>
                <option value="personas">Personas</option>
            </select>

            <br><br>

            <label for="fecha">Fecha: </label>
            <input type="date" name="data[fecha]" value="<?php echo isset($_SESSION['data_fecha']) ? $_SESSION['data_fecha'] : ''; ?>">
            
            <!-- imprimimos las fechas del viaje seleccionado para poder seleccionarla de manera eficiente -->
            <?php if ($selected_viaje !== null): ?>
                <br> (<?= $selected_viaje_inicio ?> / <?= $selected_viaje_fin ?>)
            <?php endif; ?>

            <br><br>

            <label for="imagen">Imagen: </label>
            <input type="file" name="imagen" accept="image/*">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_img'])) echo  $_SESSION['err_img']?> </span>

            <br><br><br>

            <input type="submit" value="Guardar" class="crear">
        
        </form>

    </section>

    <!-- esto es para el tipo -->
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.getElementById('mySelect');
    var savedValue = sessionStorage.getItem('selectedValue');
    if (savedValue) {
      selectElement.value = savedValue;
    }

    selectElement.addEventListener('change', function() {
      sessionStorage.setItem('selectedValue', this.value);
    });
    
    document.getElementById('myForm').addEventListener('submit', function() {
      sessionStorage.removeItem('selectedValue');
    });
  });
</script>

<!-- y esto para la fecha -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var dateInput = document.getElementsByName('data[fecha]')[0];
    var savedDate = sessionStorage.getItem('selectedDate');
    if (savedDate) {
      dateInput.value = savedDate;
    }

    dateInput.addEventListener('change', function() {
      sessionStorage.setItem('selectedDate', this.value);
    });
    
    document.getElementById('myForm').addEventListener('submit', function() {
      sessionStorage.removeItem('selectedDate');
    });
  });
</script>

<!-- y esto para el viaje -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var selectElement = document.querySelector('select[name="data[viaje]"]');
    var savedViaje = sessionStorage.getItem('selectedViaje');
    if (savedViaje) {
      selectElement.value = savedViaje;
    }

    selectElement.addEventListener('change', function() {
      sessionStorage.setItem('selectedViaje', this.value);
    });
    
    document.getElementById('myForm').addEventListener('submit', function() {
      sessionStorage.removeItem('selectedViaje');
    });
  });
</script>




<?php
// Access the selected value using $_POST['mySelect']
if (isset($_POST['mySelect'])) {
    $selectedValue = $_POST['mySelect'];
    // Rest of your code
} 


$_SESSION['viajes'] = $viajes;


// Perform any necessary actions with the selected value

// Redirect back to the form page
// header("Location: ". $_ENV['BASE_URL'].'imagen/crear');
// exit;
?>



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
