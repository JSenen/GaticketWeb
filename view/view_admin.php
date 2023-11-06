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
.submenu {
    margin-left: 0; /* Alinea los submenús con "Gestion" */
    padding-left: 20px; /* Agrega un margen a los submenús para que estén indentados */
}

</style>
<header id="header">
<nav class="navbar-dark bg-dark navbar-vertical show " style="width: 155px">
    <ul class="navbar-nav">
        <img src="./resources/img/GaticketAdmin.jpeg"  alt="" width="130" height="130">>
        <li class="nav-item">
            <a class="nav-link" href="#" style="color: yellow;">ADMINISTRADOR</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><?php echo $_SESSION['user_tip'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=admin&action=ticketlist">Tickets</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Gestion</a>
                <ul class="submenu">
                    <li><a href="index.php?controller=admin&action=userChanges">Usuarios</a></li>
                    <li><a href="index.php?controller=admin&action=departmentChanges">Departamentos</a></li>
                    <li><a href="index.php?controller=admin&action=deviceChanges">Dispositivos</a>
                        <ul>
                            <li><a href="index.php?controller=admin&action=typeChanges">Tipos</a></li>
                            <li><a href="index.php?controller=admin&action=netChanges">Red</a></li>
                        </ul>
                    </li>
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