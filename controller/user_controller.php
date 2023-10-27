<?php
require_once './model/api.php';

function firstPage(){
    session_start();
    include('./view/view_user.php');
    recordTicket();
}

function listIncidencesUser(){
    
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $userId = $user['userId'];

    include('./model/model_userincidences.php');
    $userincidences = getUserIncidences($userId);

    include('./view/view_userincidences.php');
    listUserIncidences($userincidences);
}
?>