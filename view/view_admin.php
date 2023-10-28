<?php
include('view_header.php');
$fecha_actual = date('d-m-Y');
?>
<style>
    /* Oculta los submenús por defecto */
.submenu {
    display: none;
}

/* Muestra los submenús cuando se hace clic en la opción "Gestión" */
.nav-item:hover .submenu {
    display: block;
       
}
.submenu li a {
    list-style: none;
    text-decoration: none;
    color: white;
}

</style>
<header id="header">
<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/GaticketAdmin.jpeg"  alt="" width="100" height="100">>
        <li class="nav-item">
            <a class="nav-link" href="#">ADMINISTRADOR</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><?php echo $_SESSION['user_tip'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=admin&action=ticketlist" style="color: yellow;">Listado</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Gestion</a>
                <ul class="submenu">
                    <li><a href="#">Usuarios</a></li>
                    <li><a href="#">Dispositivos</a></li>
                    <li><a href="#">Red</a></li>
                </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Salir</a>
        </li>
    </ul>
</nav>
</header>
<!-- Start Page content holder -->
<div class="page-content p-5 text-gray" id="content" style="margin-left: 7%; min-height: 100vh;">