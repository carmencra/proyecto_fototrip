<title>Fototrip - Guardar viaje</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<!-- si se ha intentado guardar una viaje, nos muestra el resultado de la operación  -->
<?php 
    if(isset($_SESSION['viaje_creado'])):
        if ($_SESSION['viaje_creado'] == true) : ?>
            <script type="text/javascript">
                alert("Se ha guardado la viaje.");
                window.close();
            </script>
            
        <?php else: ?>
            <script type="text/javascript">
                alert("Ha habido un error al guardar la viaje.");
                window.close();
            </script>
        <?php endif;
    endif; 
?>

<!-- cargamos la ruta de la página actual por si viniera de otra ruta -->
<!-- <script>
    console.log(window.location.href);
    var baseUrl = 'http://localhost/fototrip/';
    var ruta_pagina = 'viaje/crear';

    if (!window.location.href.startsWith(baseUrl) || !window.location.href.endsWith(ruta_pagina)) {
        window.location.href = baseUrl + ruta_pagina;
    }
</script> -->

<?php        
    // guardamos los valores del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $select_nivel= $_POST['data']['nivel'];
        $_SESSION['data_nivel']= $select_nivel;
        
        $select_exigencia= $_POST['data']['exigencia'];
        $_SESSION['data_exigencia']= $select_exigencia;
    }    
?>

<main>
    <section class="contenido_main">
        <form action="<?=$_ENV['BASE_URL']?>viaje/guardar" method="POST" enctype="multipart/form-data" class="form_crear">
            <h1>Guardar viaje</h1>    
            <hr> <br>

            <label for="pais">Pa&iacute;s: </label>
            <input type="text" name="data[pais]" value="<?php if (isset($_POST['data']['pais']))echo $_POST['data']['pais'];?>">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_pai'])) echo  $_SESSION['err_pai']?> </span>

            <br><br>
            
            <label for="fecha_inicio">Fecha inicio: </label>
            <input type="date" name="data[fecha_inicio]" value="<?php if (isset($_POST['data']['fecha_inicio']))echo $_POST['data']['fecha_inicio'];?>">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_feci'])) echo  $_SESSION['err_feci']?> </span>

            <br><br>
            
            <label for="fecha_fin">Fecha fin: </label>
            <input type="date" name="data[fecha_fin]" value="<?php if (isset($_POST['data']['fecha_fin']))echo $_POST['data']['fecha_fin'];?>">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_fecf'])) echo  $_SESSION['err_fecf']?> </span>

            <br><br>
            
            <label for="precio">Precio: </label>
            <input type="number" name="data[precio]" value="<?php if (isset($_POST['data']['precio']))echo $_POST['data']['precio'];?>" style="width:60px"> €
            <br><span style="color:red"> <?php if(isset($_SESSION['err_pre'])) echo  $_SESSION['err_pre']?> </span>

            <br><br>
            
            <label for="descripcion">Descripci&oacute;n: </label>
            <input type="text" name="data[descripcion]" value="<?php if (isset($_POST['data']['descripcion']))echo $_POST['data']['descripcion'];?>">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_des'])) echo  $_SESSION['err_des']?> </span>
            
            <br><br>
            
            <label for="informacion">Informaci&oacute;n: </label> <br>
            <textarea> 
                <?php if (isset($_POST['data']['informacion']))echo $_POST['data']['informacion'];?>
            </textarea>
            <br><span style="color:red"> <?php if(isset($_SESSION['err_inf'])) echo  $_SESSION['err_inf']?> </span>

            <br><br>

            <label for="exigencia">Exigencia f&iacute;sica: </label>
            <select name="data[exigencia]">
                <option value="muy_facil" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "muy_facil")) echo "selected"; ?>> Muy f&aacute;cil </option>
                <option value="novato" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "novato")) echo "selected"; ?>> Novato </option>
                <option value="medio" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "medio")) echo "selected"; ?>> Medio </option>
                <option value="alto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "alto")) echo "selected"; ?>> Alto </option>
                <option value="experto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "experto")) echo "selected"; ?>> Experto </option>
            </select>
            
            <br><br><br>

            <label for="nivel">Nivel fotogr&aacute;fico: </label>
            <select name="data[nivel]">
                <option value="muy_facil" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "muy_facil")) echo "selected"; ?>> Muy f&aacute;cil </option>
                <option value="novato" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "novato")) echo "selected"; ?>> Novato </option>
                <option value="medio" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "medio")) echo "selected"; ?>> Medio </option>
                <option value="alto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "alto")) echo "selected"; ?>> Alto </option>
                <option value="experto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "experto")) echo "selected"; ?>> Experto </option>
            </select>

            <br><br><br>

            <label for="imagen">Imagen: </label>
            <input type="file" name="imagen" accept="image/*">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_img'])) echo  $_SESSION['err_img']?> </span>

            <br><br>

            <input type="submit" value="Guardar" class="crear">
        </form>

    </section>

    
<?php 
    use Utils\Utils;
    Utils::deleteSession('viaje_creado');

    require_once('views/layout/footer_sub_main.php'); 
?>
