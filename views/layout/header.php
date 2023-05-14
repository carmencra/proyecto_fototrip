<header>

    <nav class="menu" id="menu">
        <ul>
            <li class="active"><a href="index.html">Inicio</a></li>

            <!-- esto llama a la función del controlador no a la vista!!! -->

            <!--   < ?=base_url? > (sin espacios) -->

            <!-- <li><a href="  (aquí lo de base url)  comentario/index">Opiniones</a></li>
            <li><a href="  (aquí lo de base url)  imagen/index">Galer&iacute;a</a></li> -->
        </ul>

        <img src="/images/persona.png">
    </nav> 

</header>




<a href="<?=base_url?>">
    <h1>TIENDA DE ZAPATOS</h1>
</a>

<h2>Para probar la página:</h2>
<b>Admin:</b> admin@gmail.com; admin <br>
<b>Usuario:</b> bcallejon@iesayala.com; belen1234<br><br>


<nav>
    
    <li><a href="<?=base_url?>carrito/index">Carrito</a></li>

    <?php if(isset($_SESSION['usuario'])): ?>
        <li><a href="<?=base_url?>usuario/modificar">Modificar datos usuario</a></li>
        <li><a href="<?=base_url?>usuario/cerrar">Cerrar sesión</a></li>

            
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == true): ?>
            
            <li><a href="<?=base_url?>categoria/index">Gestionar categorias</a></li>

            <li><a href="<?=base_url?>producto/index">Gestionar productos</a></li>  
        
        <?php else: ?>
            <li><a href="<?=base_url?>pedido/index">Mis pedidos</a></li>

        <?php endif;?>

    <?php else: ?>
        <li><a href="<?=base_url?>usuario/login">Login</a></li>
        <li><a href="<?=base_url?>usuario/registro">Registro</a></li>

    <?php endif;?>

</nav>



<?php 
use Repositories\CategoriaRepository;

$categorias= CategoriaRepository::listar();
?>


<ul>
    <?php foreach($categorias as $cate): ?>
        <li>
            <a href="<?=base_url?>Categoria/ver_categoria&id=<?=$cate['id']?>"> <?=$cate['nombre'] ?> </a>
        </li>
    <?php endforeach; ?>
</ul>

