<?php
include('view_header.php');
$fecha_actual = date('d-m-Y');
?>
<header id="header">
<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/GATLogo.jpeg"  alt="" width="130" height="130">>
        <li class="nav-item">
        <a class="nav-link" href="#"><?php echo $_SESSION['user_tip'] ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php?controller=user&action=firstPage">Grabar Ticket</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" style="color: yellow;">Listado</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Salir</a>
        </li>
    </ul>
</nav>
</header>
<!-- Start Page content holder -->
<div class="page-content p-5 text-gray" id="content" style="margin-left: 7%; min-height: 100vh;">






