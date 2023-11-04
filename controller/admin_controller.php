<?php
require_once './model/api.php';

//==== MODIFICAR ADMIN TICKETS =====
function ticketlist(){

    //Obtner el Id de usuario administrador
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminincidences.php';
    $incidences = getAllIncidences();
    include './view/view_admin.php';
    listadminincidences($incidences);
}
//==== PAGINA ADMIN USUARIOS =====
function userChanges(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminusers.php';
    $userList = getAllUsers();
    include './view/view_admin.php';
    listUsers($userList);
}
//==== AÑADIR USUARIO =====
function addUser(){

    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    
    //1º Capturar la lista de departamentos
    $listdepartment = getAllDepartments();
    //Mostrar formulario añadir usuarios
    include './view/view_adduser.php';
    recordUserfromAdmin();

}
//==== AÑADIR TIPO DISPOSITIVO =====
function addType(){

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   

    //Mostrar formulario añadir nuevo tipo dispositivo
    include './view/view_addtype.php';
    recordNewType();

}
//==== AÑADIR DISPOSITIVO ====
function addDevice(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    //1º Capturar la lista de tipos
    $url = 'types';
    $listtypes = getAllSomeThing($url);
    //2º Capturar IP disponibles
    $urlty = 'net';
    $listip = getAllIps($urlty);
    //3º Departamento
    $urldep = 'departments';
    $listdepart = getAllSomeThing($urldep);
    //Mostrar formulario añadir dispositivo
    include './view/view_adddevice.php';
    recordDeviceAdmin();


}

//==== ELIMINAR USUARIO =====
function deleteUser($iduser) {
    session_start();
    $user['userId'] = $_SESSION['user_id'];
    $adminId = $user['userId'];

    // Obtener usuario seleccionado
    eraseUser($iduser); // Pasar $iduser como argumento
}

//==== PAGINA ADMIN DISPOSITIVOS ========
function deviceChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   

    include './model/model_admindevices.php';
    $deviceList = getAllDevices();
    include './view/view_admin.php';
    listDevices($deviceList);

}
//======= ADMIN DEPARTAMENTOS ==========
function departmentChanges(){
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_admindepart.php';
    $departlist = getAllDepartments();
    include './view/view_admin.php';
    listDepart($departlist);
}
//======== ADMIN TIPOS =================
function typeChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    
    include './model/model_admintypes.php';
    $typelist = getAllSomeThing('types');
    include './view/view_admin.php';
    listTypes($typelist);
    
}
//======= ADMIN BORRAR TIPO ===========
function deleteType($id){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  
    eraseType($id);
}
?>

