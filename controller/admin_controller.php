<?php
require_once './model/api.php';
require_once './model/domain/Net.php';
require_once './model/domain/User.php';
require_once './model/domain/Department.php';
require_once './model/domain/Device.php';
require_once './model/domain/Type.php';
require_once './model/domain/Incidence.php';
require_once './model/domain/IncidenceHistory.php';
require_once './model/domain/Messages.php';

/** Funcion que administra los tickets de incidencia por parte del administrador
 * @param int $adminId Numero Id del administrador
 * @param array $incidences Listado de las incidencias 
 * @return array listadminincidences($incidences) Listado con todas las incidencias
 */
function ticketlist(){

    //Obtner el Id de usuario administrador
    session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];

    include './model/model_adminincidences.php';
    $incidences = getAllSomeThing('incidences');
    include './view/view_admin.php';
    listadminincidences($incidences);
}
/** Funcion que maneja la resolucion de incidencias y los mensajes
 *  @param int $adminTip TIP del adminsitrador
 */
function getIncidence($idIncidence){
     // Comprobamos que la sesión esté iniciada
     if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $user['userId']= $_SESSION['user_id'];
    $user['userTip'] = $_SESSION['user_tip'];
    $adminId = $user['userId'];
    $adminTip = $user['userTip'];
    $incidenceCatch = new Incidence();
    $messageGetSet = new Messages();
    //Asociar Incidence a admin
    $incidenceCatch->giveIncidenceAdmin($idIncidence,$adminId);
    //Buscar todos los datos de la incidencia y cambiar estado
    $incidenceToSolve = $incidenceCatch->searchIncidence($idIncidence);
    //Obtener todos los mensajes o finalizar
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submitMessage"])) {
            // Procesar el formulario de mensajes
            $messageCommit = $_POST["messageCommit"];
            $messageGetSet->adminMessages($idIncidence, $adminId);
            
        } elseif (isset($_POST["submitSolution"])) {
            // Procesar el formulario de finalizar incidencia
            $solution = $_POST["solution"];
            // Pasa $incidenceToSolve como argumento a finsihIncidence
            $incidenceCatch->finsihIncidence($idIncidence, $incidenceToSolve, $solution,$adminTip);
            
        } 
    }
    //Leer todos los mensajes de la incidencia
    $listmessages = $incidenceCatch->getAllMenssagesIncidence($idIncidence);
    include './view/view_admingetincidences.php';
    

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
    $userInstance = new User();
    //Mostrar formulario añadir usuarios
    include './view/view_adduser.php';
    $userInstance->recordUserfromAdmin();

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
    $listip = getAllSomeThing($urlty);
    //3º Departamento
    $urldep = 'departments';
    $listdepart = getAllSomeThing($urldep);
    //Mostrar formulario añadir dispositivo
    include './view/view_adddevice.php';
    recordDeviceAdmin();


}
//==== ELIMINAR DISPOSITIVO =====
function deleteDevice($idDevice){
    session_start();
    $user['userId'] = $_SESSION['user_id'];
    $adminId = $user['userId'];

    // Obtener usuario seleccionado
    eraseDevice($idDevice); // Pasar $iduser como argumento

}

//==== ELIMINAR USUARIO =====
function deleteUser($iduser) {
    session_start();
    $user['userId'] = $_SESSION['user_id'];
    $adminId = $user['userId'];

    // Obtener usuario seleccionado
    $userInstance = new User();
    $userInstance->eraseUser($iduser); // Pasar $iduser como argumento
}

//==== PAGINA ADMIN DISPOSITIVOS ========
function deviceChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    $deviceList = getAllSomeThing("device");
    include './model/model_admindevices.php';
    include './view/view_admin.php';
    listDevices($deviceList);

}
//======= ADMIN AÑADIR DEPARTAMENTO ====
function addDepart(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   

    include './view/view_adddepart.php';
    $departmentInstance = new Department();
    $departmentInstance->recordNewDepart();
    
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
    $typeToErase = new Type();
   $typeToErase->eraseType($id);
}
//======= ADMIN NET LIST ===========
function netChanges(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    
    include './model/model_adminnet.php';
    $netlist = getAllSomeThing('net');
    include './view/view_admin.php';
    listNet($netlist);
}
//======= LIBERAR NET IP ===========
function freeIp($idNet){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  
    $netInstance = new Net();
    $netInstance->eraseIp($idNet);
}
//======= AGREGAR IP  ===========
function addIp(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    $netInstance = new Net();
    //Mostrar formulario añadir nuevo tipo dispositivo
    include './view/view_addip.php';
    $netInstance->recordNewIp();

}
//======= ASIGNAR IP A DISPOSITIVO =======

function giveIp($deviceId){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }   
    //Obtener todas las Ip
    $device = getDeviceById($deviceId);
    $listIp = getAllSomeThing('net');
    include './view/view_addiptodevice.php';
    setIpDevice($device);
    
}
//======= BORRAR DEPARTAMENTO ========
function deleteDepart($id){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  
    $departmentInstance = new Department();
    $departmentInstance->eraseDepart($id);
}
//======== UPDATE DEPARTAMENTO =========
function updateDepart($idDepart){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  

    $url = 'departments/'.$idDepart;
    $depart = getAllSomeThing($url);
    include './view/view_updatedepart.php';
    $departInstance = new Department();
    $departInstance->changeDepart($idDepart);
    header('Location: index.php?controller=admin&action=departmentChanges');
}
//======== UPDATE USER ================
function updateUser($idUser){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $user['userId']= $_SESSION['user_id'];
    $adminId = $user['userId'];
    }  

    $userInstance = new User();
    //Buscamos el usuario
    $userdata = $userInstance->getOneUser($idUser);
    $rol = $userdata['userRol'];
    
    //Segun el tipo de rol, le pasamos el contrario
    if($rol == 'usuario') {
        $rol = 'administrador';
    }else{
        $rol = 'usuario';
    }
    //Cambiamos el rol
    
    $userInstance->changeRol($idUser,$rol);
   
}   

//========= PAGINA HISTORIAL ========
function historyList(){
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    $incidencesHsitory = new IncidenceHistory();
    $listHistory = $incidencesHsitory->getAllHistory();
    include './view/view_adminhistory.php';
    }
}


?>

