<?php
include('view_header.php');
$fecha_actual = date('d-m-Y');
?>

<nav class="navbar-dark bg-dark navbar-vertical show">
    <ul class="navbar-nav">
        <img src="./resources/img/Gaticket.png"  alt="" width="100" height="100">>
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




