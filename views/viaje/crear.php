<title>Fototrip - Guardar viaje</title>

<?php require_once('views/layout/header_sub_main.php'); ?>

<!-- si se ha intentado guardar un viaje, muestra si ha ocurrido algún error, si se completa, lo indica en la página de administrar  -->
<?php use Utils\Utils;
    if(isset($_SESSION['viaje_creado']) && $_SESSION['viaje_creado'] == false):
        if (isset($_SESSION['error_gastos'])): ?>
            <script type="text/javascript">
                alert("Ha habido un error al guardar los gastos del viaje.");
                window.close();
            </script>
        <?php else: ?>
            <script type="text/javascript">
                alert("Ha habido un error al guardar el viaje.");
                window.close();
            </script>
        <?php endif; 

        Utils::deleteSession('viaje_creado');

    endif; 
?>

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

            <section class="antes_desc">
                <div>
                    <label for="pais">Pa&iacute;s: </label>
                    <input type="text" name="data[pais]" value="<?php if (isset($_POST['data']['pais']))echo $_POST['data']['pais'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_pai'])) echo  $_SESSION['err_pai']?> </span>
                </div>

                <div>
                    <label for="precio">Precio: </label>
                    <input type="number" name="data[precio]" value="<?php if (isset($_POST['data']['precio']))echo $_POST['data']['precio'];?>" style="width:60px" min="1" oninput="this.value= !!this.value && Math.abs(this.value) >= 1 ? Math.abs(this.value) : null"> €
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_pre'])) echo  $_SESSION['err_pre']?> </span>
                </div>

                <div>
                    <label for="fecha_inicio">Fecha inicio: </label>
                    <input type="date" name="data[fecha_inicio]" value="<?php if (isset($_POST['data']['fecha_inicio']))echo $_POST['data']['fecha_inicio'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_feci'])) echo $_SESSION['err_feci']?> </span>
                </div>

                <div>
                    <label for="fecha_fin">Fecha fin: </label>
                    <input type="date" name="data[fecha_fin]" value="<?php if (isset($_POST['data']['fecha_fin']))echo $_POST['data']['fecha_fin'];?>">
                    <br><span style="color:red"> <?php if(isset($_SESSION['err_fecf'])) echo  $_SESSION['err_fecf']; if(isset($_SESSION['err_via'])) echo $_SESSION['err_via']?> </span>
                </div>
               
            </section> <br>
            
            <label for="descripcion">Descripci&oacute;n: </label> <br>
            <textarea name="data[descripcion]" rows='1'><?php if (isset($_POST['data']['descripcion'])) echo $_POST['data']['descripcion']; ?></textarea>
            <br><span style="color:red"> <?php if(isset($_SESSION['err_des'])) echo  $_SESSION['err_des']?> </span>
            
            <br><br>
            
            <label for="informacion">Informaci&oacute;n: </label> <br>
            <textarea name="data[informacion]" rows='3'><?php if (isset($_POST['data']['informacion'])) echo $_POST['data']['informacion']; ?></textarea>
            <br><span style="color:red"> <?php if(isset($_SESSION['err_inf'])) echo $_SESSION['err_inf']?> </span>


            <section class="select">
                <div>
                    <label for="exigencia">Exigencia f&iacute;sica: </label>
                    <select name="data[exigencia]">
                        <option value="muy_facil" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "muy_facil")) echo "selected"; ?>> Muy f&aacute;cil </option>
                        <option value="novato" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "novato")) echo "selected"; ?>> Novato </option>
                        <option value="medio" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "medio")) echo "selected"; ?>> Medio </option>
                        <option value="alto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "alto")) echo "selected"; ?>> Alto </option>
                        <option value="experto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_exigencia'] == "experto")) echo "selected"; ?>> Experto </option>
                    </select>
                </div>

                <div>
                    <label for="nivel">Nivel fotogr&aacute;fico: </label>
                    <select name="data[nivel]">
                        <option value="muy_facil" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "muy_facil")) echo "selected"; ?>> Muy f&aacute;cil </option>
                        <option value="novato" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "novato")) echo "selected"; ?>> Novato </option>
                        <option value="medio" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "medio")) echo "selected"; ?>> Medio </option>
                        <option value="alto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "alto")) echo "selected"; ?>> Alto </option>
                        <option value="experto" <?php if (isset($_POST['data']['descripcion']) && ($_SESSION['data_nivel'] == "experto")) echo "selected"; ?>> Experto </option>
                    </select>
                </div>

            </section> <br>

            <label for="imagen">Imagen: </label>
            <input type="file" name="imagen" accept="image/*">
            <br><span style="color:red"> <?php if(isset($_SESSION['err_img'])) echo  $_SESSION['err_img']?> </span>
            
            <br><br><br><br>

            <label for="gastos">Gastos incluidos: </label> <br>
            <span>(Marca los que est&eacute;n incluidos)</span> <br><br>

                <section class="crear_gastos">
                    <div>
                        <label for="comida">Comida</label>
                        <input type="checkbox" id="comida" name="gastos[]" value="comida" <?php echo isset($_POST['gastos']) && in_array('comida', $_POST['gastos']) ? 'checked' : ''; ?>>
                    </div>

                    <div>
                        <label for="alojamiento">Alojamiento</label>
                        <input type="checkbox" id="alojamiento" name="gastos[]" value="alojamiento" <?php echo isset($_POST['gastos']) && in_array('alojamiento', $_POST['gastos']) ? 'checked' : ''; ?>>
                    </div>

                    <div>
                        <label for="vuelos">Vuelos</label>
                        <input type="checkbox" id="vuelos" name="gastos[]" value="vuelos" <?php echo isset($_POST['gastos']) && in_array('vuelos', $_POST['gastos']) ? 'checked' : ''; ?>>
                    </div>

                    <div>
                        <label for="transportes">Transportes</label>
                        <input type="checkbox" id="transportes" name="gastos[]" value="transportes" <?php echo isset($_POST['gastos']) && in_array('transportes', $_POST['gastos']) ? 'checked' : ''; ?>>
                    </div>

                    <div>
                        <label for="seguro">Seguro</label>
                        <input type="checkbox" id="seguro" name="gastos[]" value="seguro" <?php echo isset($_POST['gastos']) && in_array('seguro', $_POST['gastos']) ? 'checked' : ''; ?>>
                    </div>

                    <div>
                        <label for="gastos">Gastos</label>
                        <input type="checkbox" id="gastos" name="gastos[]" value="gastos" <?php echo isset($_POST['gastos']) && in_array('gastos', $_POST['gastos']) ? 'checked' : ''; ?>>
                    </div>

                </section>

                <br><br>

            <input type="submit" value="Guardar" class="crear boton_resaltar">
        </form>

    </section>

    
<?php require_once('views/layout/footer_sub_main.php'); ?>
