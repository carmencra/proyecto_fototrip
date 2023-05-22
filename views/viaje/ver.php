
<?php require_once('views/layout/header_base.php'); ?>

<main>
    <section class="contenido_main">
        <?php if (empty($viaje)): ?>
            <p>No se ha encontrado ning&uacute;n viaje.</p> <br><br><br>
        <?php else:?>
        
        <section class="detalle_viaje">
            <h1> <?= $viaje->getPais() ?></h1>

            <section class="general">
                <h2>Informaci&oacute;n general</h2>
                <hr>

                <table>
                    <tr>
                        <td> 
                            <img src="../fuente/media/images/icono_precio.png" alt="precio"/> 
                        </td>
                        <th class="izquierda"> <?= $viaje->getPrecio() ?> € </th>
                        <td>
                            <img src="../fuente/media/images/icono_foto.png" alt="nivel fotográfico"/> 
                        </td>
                        <th> <?= $viaje->getNivel_fotografia() ?></th>
                    </tr>

                    <tr>
                        <td>
                            <img src="../fuente/media/images/icono_fecha.png" alt="fecha"/> 
                        </td>
                        <th class="izquierda"> <?= $viaje->getFecha_inicio() ?> - <?= $viaje->getFecha_fin() ?> </th>
                        <td>
                            <img src="../fuente/media/images/icono_fisico.png" alt="nivel físico"/> 
                        </td>
                        <th> <?= $viaje->getNivel_fisico() ?></th>
                    </tr>
                </table>
            </section>


            <section class="itinerario">
                <details>
                    <summary>
                        <h2>Itinerario</h2>
                        <hr>
                    </summary>

                    <section>
                        <ul>
                            <?php foreach ($itinerario as $dia ): ?>
                                <li><h3>D&iacute;a <?= $dia->getDia(); ?> </h3></li>
                                <p> <?= $dia->getDescripcion(); ?> </p> <br>

                            <?php endforeach;?>
                        </ul>
                    
                    </section>
                </details>
                
            </section>

            
            <section class="gastos">
                <h2>Gastos incluidos</h2>
                <hr>

                <table>
                    <tr>
                        <td>
                            <?php if ($gastos->getComida() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <th class="izquierda"> Comida </th>

                        <td>
                            <?php if ($gastos->getTransportes() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <th> Transportes </th>
                    </tr>

                    <tr>
                        <td>
                            <?php if ($gastos->getAlojamiento() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <th class="izquierda"> Alojamiento </th>

                        <td>
                            <?php if ($gastos->getSeguro() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <th> Seguro </th>
                    </tr>

                    <tr>
                        <td>
                            <?php if ($gastos->getVuelos() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <th class="izquierda"> Vuelos </th>

                        <td>
                            <?php if ($gastos->getGastos() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <th> Gastos aparte </th>
                    </tr>                    
                    
                </table>
            </section>


            
            <section class="galeria">
                <h2>Galer&iacute;a</h2>
                <hr>
            </section>

            <section class="imagenes">
                <?php foreach($imagenes as $imagen) : ?>
                    <section class="imagen">
                        <p class="imagen_imagen"> <?= $imagen->getImagen(); ?> </p>

                        <p class="usuario"> <?= $imagen->getUsuario(); ?> </p>                        
                    </section>

                <?php endforeach; ?>
            </section>



            <section class="opiniones">
                <h2>Comentarios</h2>
                <hr>
            </section>

            <section class="comentarios">
                <?php foreach($comentarios as $comentario) : ?>
                    <section class="comentario" id="opinion">
                        <h4> <?= $comentario->getUsuario(); ?> </h4>

                        <hr>

                        <p class="contenido"> <?= $comentario->getContenido(); ?> </p>

                    </section>
                <?php endforeach; ?>
            </section>


        </section>



    </section>

<?php endif;?>

