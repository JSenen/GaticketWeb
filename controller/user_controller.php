<?php
require_once './model/api.php';

function firstPage(){
    session_start();
    include('./view/view_user.php');
    recordTicket();
}

function listIncidencesUser(){
    include('./view/view_userincidences.php');
}
?>