
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
                        <td class="icono"> 
                            <img src="../fuente/media/images/icono_precio.png" alt="precio"/> 
                        </td>
                        <th> <?= $viaje->getPrecio() ?> € </th>
                        <td class="icono">
                            <img src="../fuente/media/images/icono_foto.png" alt="nivel fotográfico"/> 
                        </td>
                        <th> <?= $viaje->getNivel_fotografia() ?></th>
                    </tr>

                    <tr>
                        <td class="icono">
                            <img src="../fuente/media/images/icono_fecha.png" alt="fecha"/> 
                        </td>
                        <th> <?= $viaje->getFecha_inicio() ?> - <?= $viaje->getFecha_fin() ?> </th>
                        <td class="icono">
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
                        <td class="icono">
                            <?php if ($gastos->getComida() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <td> Comida </td>

                        <td class="icono">
                            <?php if ($gastos->getTransportes() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <td> Transportes </td>
                    </tr>

                    <tr>
                        <td class="icono">
                            <?php if ($gastos->getAlojamiento() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <td> Alojamiento </td>

                        <td class="icono">
                            <?php if ($gastos->getSeguro() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <td> Seguro </td>
                    </tr>

                    <tr>
                        <td class="icono">
                            <?php if ($gastos->getVuelos() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <td> Vuelos </td>

                        <td class="icono">
                            <?php if ($gastos->getGastos() == true): ?>
                                <img src="../fuente/media/images/icono_si.png" alt="sí"/> 
                            <?php else :?>
                                <img src="../fuente/media/images/icono_no.png" alt="no"/> 
                            <?php endif;?> 
                        </td>
                        <td> Gastos aparte </td>
                    </tr>                    
                    
                </table>
            </section>


        </section>



    </section>

<?php endif;?>

