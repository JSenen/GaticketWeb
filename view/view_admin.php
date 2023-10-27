<?php
include('view_header.php');
$fecha_actual = date('d-m-Y');
?>
<header id="header">
<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/Gaticket.png"  alt="" width="100" height="100">>
        <li class="nav-item">
        <a class="nav-link" href="#">ADMINISTRADOR</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">PONER TIP</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=admin&action=ticketlist">Listado</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Salir</a>
        </li>
    </ul>
</nav>
</header>