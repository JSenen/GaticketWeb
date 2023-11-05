<!-- Intercambio de datos con la API -->
<?php
include './resources/config.php';

// =========== ELIMINAR USUARIO POR ID =====================

function eraseUser($idUser){
    
    $url = BASE_URL . 'user/' . $idUser; // Agrega "/" para formar la URL completa
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        echo "Solicitud DELETE exitosa. Respuesta del servidor: " . $response;
        header('Location: index.php?controller=admin&action=userChanges');
    }

    curl_close($ch);

}
// =========== ELIMINAR TIPO ===========================
function eraseType($idType){

    $url = BASE_URL . 'type/' . $idType; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        echo "Solicitud DELETE exitosa. Respuesta del servidor: " . $response;
        header('Location: index.php?controller=admin&action=typeChanges');
    }

    curl_close($ch);


}
// =========== ELIMINAR IP (LIBERAR) ===========================
function eraseIp($id) {

    $url = BASE_URL . 'net/' . $id; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        echo "Solicitud DELETE exitosa. Respuesta del servidor: " . $response;
        header('Location: index.php?controller=admin&action=netChanges');
    }

    curl_close($ch);

}
// =========== COMPROBAR LOGIN ===========================
function conection_login($tip,$clave){                                                  
    $url = BASE_URL.'users';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $data = json_decode($response, true); 

     // Buscar el usuario que coincide con el TIP y la clave
     foreach ($data as $user) {
        
        if ($user['userTip'] == $tip ){

            //Verificar si la contraseña ingresada coincide con la alamacenada(hash)
            if (password_verify($clave,$user['userPassword'])){
                session_start(); //Iniciamos sesion del usuario
                $_SESSION['user_id'] = $user['userId'];
                $_SESSION['user_tip'] = $user['userTip']; 
                $_SESSION['user_rol'] = $user['userRol']; 
                
                setcookie('gaticket', '', 86400); //Establecemos una cookie de 1 dia
                if($user['userRol'] === 'administrador'){
                    // Envio a pagina de administradors
                header('location:index.php?controller=admin&action=ticketlist');
                } else {
                    //Envio a pagina de usuarios
                header('location:index.php?controller=user&action=firstPage'); 
                }

            }
            
        } else {
            // Login erroneo
    $_SESSION['login_error'] = "LOGIN FALLIDO"; // Almacena el mensaje de error en una variable de sesión
    session_write_close(); // Borramos sesiones anteriores
    header("Refresh: 3; url=index.php");
        }
       
    }
    

}

// =========== GRABAR TICKET ================================
function recordTicket(){
    
    //Comprobamos que session este iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

        $fecha_actual = date('d/m/y');

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $incidenceCommit = $_POST['commit_incidence'];
            $incidenceTheme = strtoupper($_POST['theme_incidence']);
            $incidenceStatus = "active";
            $incidenceDate = $fecha_actual;
            $incidenceDateFinish = ""; 
            $deviceSerialNumber = $_POST['device_serialnumber'];
            if (!isset($_POST['device_serialnumber']) || empty($_POST['device_serialnumber'])) {
                $deviceSerialNumber = "SIN DATOS";
            }

            // 1º Buscar  Id device por serial number
            $endpointserial = BASE_URL.'/device?deviceSerial='.$deviceSerialNumber;
            $ch = curl_init($endpointserial);
            curl_setopt($ch, CURLOPT_URL, $endpointserial);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            //Decodificamos Json
            $data = json_decode($result, true);
            // Verificar si se obtuvo una respuesta válida y si el campo "deviceId" está presente
                if (is_array($data) && isset($data['deviceId'])) {
                    // Obtener el valor del deviceId
                    $deviceId = $data['deviceId'];
                } else {
                    echo "No se pudo encontrar el deviceId para el número de serie proporcionado."; //TODO mostrar error a usuario
                }

             //Recopila datos del usuario grabo ticket
            $userId = $_SESSION['user_id'];
            $userTip = $_SESSION['user_tip'];
            
            // Define los datos que se enviarán a la API
            $incidencedata = array(
                'incidenceCommit' => $incidenceCommit,
                'incidenceTheme' => $incidenceTheme,
                'incidenceStatus' =>  $incidenceStatus,
                'incidenceDate' => $incidenceDate,
                'incidenceDateFinish' => $incidenceDateFinish,
                'device' => $deviceId
            );

            // Realiza una solicitud POST a la API para grabar una incidencia
            $url = BASE_URL.'incidence/'.$userId;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($incidencedata));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            $response = curl_exec($ch);

            // Después de procesar la solicitud, redirigir de nuevo a la misma página
            header('Location: index.php?controller=user&action=listIncidencesUser');
            exit(); // asegura de que el script se detenga aquí
        
     } else {
            echo "Acceso no permitido.";
        }
}

//===================== LISTAR INCIDENCIAS USUARIO ==================================
function getUserIncidences($userId){
    
    $urllistincidences = BASE_URL.'incidences/user/'.$userId;
    $ch = curl_init($urllistincidences);
    curl_setopt($ch, CURLOPT_URL, $urllistincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado de incidencias del usuario
    //Decodificamos json
    $userincidences = json_decode($result, true);
            
    return $userincidences;

}
//===================== LISTAR INCIDENCIAS DISPOSITIVOS ==================================
function getDeviceIncidences($deviceId){
    $urllistincidences = BASE_URL.'incidences/device/'.$deviceId;
    $ch = curl_init($urllistincidences);
    curl_setopt($ch, CURLOPT_URL, $urllistincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado de incidencias del usuario
    //Decodificamos json
    $deviceIncidences = json_decode($result, true);
            
    return $deviceIncidences;
}

//==================== LISTAR INCIDENCIAS ADMINISTRADOR ===============================

function getAllIncidences(){

    $urladminincidences = BASE_URL.'incidences';
    $ch = curl_init($urladminincidences);
    curl_setopt($ch, CURLOPT_URL, $urladminincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado total de incidencias
    $adminincidences = json_decode($result, true);

    if(is_array($adminincidences) && !empty($adminincidences)){
        return$adminincidences;
    }else{
        return [];
    }
            
    

}

//==================== DATOS DEPARTAMENTO USUARIO ==========================================

function getUserDepartment($userid){

    $urlUserDepart = BASE_URL.'department/'.$userid;
    $ch = curl_init($urlUserDepart);
    curl_setopt($ch, CURLOPT_URL, $urlUserDepart);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos del departamento del usuario
    $userdepart = json_decode($result, true);
            
    return $userdepart;

}
//================== TODOS LOS USUARIOS ============================================

function getAllUsers(){

    //Listamos los usuarios
    $urlUser = BASE_URL.'users';
    $ch = curl_init($urlUser);
    curl_setopt($ch, CURLOPT_URL, $urlUser);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultusers = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $userlist = json_decode($resultusers, true);

    return $userlist;
}

//================== TODOS LOSDEPARTAMENTOS ============================================

function getAllDepartments(){

    //Listamos los usuarios
    $urlDepart = BASE_URL.'departments';
    $ch = curl_init($urlDepart);
    curl_setopt($ch, CURLOPT_URL, $urlDepart);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultdepart = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $departlist = json_decode($resultdepart, true);

    return $departlist;
}
//=================== TODOS LOS DISPOSITIVOS =========================================
function getAllDevices(){
     //Listamos los usuarios
     $urlDepart = BASE_URL.'device';
     $ch = curl_init($urlDepart);
     curl_setopt($ch, CURLOPT_URL, $urlDepart);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $resultdepart = curl_exec($ch);
     curl_close($ch);
 
     //Recopila los datos 
     $devicelist = json_decode($resultdepart, true);
 
     return $devicelist;
}
//================== BUSCAR 1 USUARIO ============================================

function getOneUser($idUser){

    //Listamos los usuarios
    $urlUser = BASE_URL.'users/'.$idUser;
    $ch = curl_init($urlUser);
    curl_setopt($ch, CURLOPT_URL, $urlUser);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultusers = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $userdata = json_decode($resultusers, true);
    return $userdata;
}


// =========== AÑADIR NUEVO USUARIO ================================
function recordUserfromAdmin(){
    
    //Comprobamos que session este iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Verifica si se está realizando una solicitud POST desde el formulario
            // Recopila los datos del formulario en los campos name
            $userTip = strtoupper($_POST['user_tip']);
            $userMail = $_POST['user_mail'];
            $userPassword = $_POST['user_password'];
            $userRol = $_POST['user_rol'];
            $departmentId = $_POST['department_id'];

            // 1º Grabamos nuevo usuario
            // Define los datos que se enviarán a la API
            $userdata = array(
                'userMail' => $userMail,
                'userPassword' =>  $userPassword,
                'userTip' => $userTip,
                'userRol' => $userRol
            );

            // Realiza una solicitud POST a la API para grabar un usuario
            $urlsave = BASE_URL.'users';
            $ch = curl_init($urlsave);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userdata));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            $responseSaveUSer = curl_exec($ch);

            // Realiza una solicitud GET para obtener todos los usuarios
            $urlGetUsers = BASE_URL . 'users';
            $ch = curl_init($urlGetUsers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseGetUsers = curl_exec($ch);

            if ($responseGetUsers !== false) {
                // Decodifica la respuesta JSON
                $userList = json_decode($responseGetUsers, true);
                
                // Encuentra el último usuario en la lista
                $lastUser = end($userList);  
                $newUserId = $lastUser['userId'];

                if (!empty($newUserId)) {
                    // Realiza una solicitud POST a la API para grabar un usuario en el departamento
                    $urlsavedepart = BASE_URL . 'user/' . $newUserId . '/' . $departmentId;
                    $ch = curl_init($urlsavedepart);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    $response = curl_exec($ch);

                    if ($response !== false) {
                        // La solicitud se realizó con éxito                     
                        $message = "Usuario grabado exitosamente.";
                    } else {
                        $message = "Error en la solicitud para grabar al usuario en el departamento.";
                    }
                    
                    echo '<p>' . $message . '</p>';
                  
                    // Redirecciona después de 3 segundos
                    echo '<meta http-equiv="refresh" content="3;url=index.php?controller=admin&action=userChanges">'; 
                    exit();

                } else {
                    echo "Error al obtener el ID del nuevo usuario.";
                }
            }
        }
        
    }
//=============== AÑADIR DISPOSITIVO ==================================
function recordDeviceAdmin(){
  
 //Comprobamos que session este iniciada
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recopila los datos del formulario en los campos name de la vista
        $deviceHd = strtoupper($_POST['device_hd']);
        $deviceRam = $_POST['device_ram'];
        $deviceSerie = $_POST['device_serial'];
        $deviceMac = $_POST['device_mac'];
        $deviceModel = strtoupper($_POST['device_model']);
        $DateBuy = $_POST['device_dateget'];
        $DateStart = $_POST['device_dad'];
        
        //Convertimos las fechas al formato que admite la API
        // Convierte la fecha al formato "dd/MM/yyyy"
        $deviceDateBuy = date('d/m/Y', strtotime($DateBuy));
        $deviceDateStart = date('d/m/Y', strtotime($DateStart));
        
        $departmentId = $_POST['department_id'];
        $typeId = $_POST['type_id'];

        

        // 1º Grabamos nuevo dispositivo
        // Define los datos que se enviarán a la API
        $deviceData = array(
            "deviceHd" => $deviceHd,
            "deviceRam" => $deviceRam,
            "deviceMac" => $deviceMac,
            "deviceSerial" => $deviceSerie,
            "deviceModel" => $deviceModel,
            "deviceDateBuy" => $deviceDateBuy,
            "deviceDateStart" => $deviceDateStart
        );

        // Realiza una solicitud POST a la API para grabar dispositivo
        $urlsave = BASE_URL.'device';
        $ch = curl_init($urlsave);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($deviceData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        $responseSaveDevice = curl_exec($ch);

        // Realiza una solicitud GET para obtener todos los dispositivos
        $urlGetDevice = BASE_URL . 'device';
            $ch = curl_init($urlGetDevice);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $responseGetDevice = curl_exec($ch);

        if ($responseGetDevice !== false) {
            // Decodifica la respuesta JSON
            $deviceList = json_decode($responseGetDevice, true);
            
            // Encuentra el último dispositivo en la lista
            $lastDevice = end($deviceList);  
            $newDevice = $lastDevice['deviceId'];

            if (!empty($newDevice)) {
                // Realiza una solicitud POST a la API para grabar dispositivo en el departamento
                $urlsavedepart = BASE_URL . 'department/' . $newDevice . '/' . $departmentId;
                $ch = curl_init($urlsavedepart);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_POST, 1);
                $response = curl_exec($ch);

                if ($response !== false) {
                    // La solicitud se realizó con éxito                     
                    $message = "Dispositivo grabado exitosamente.";
                } else {
                    $message = "Error en la solicitud para grabar al dispositivo en el departamento.";
                }
                
                echo '<p>' . $message . '</p>';
                // Realiza una solicitud POST a la API para grabar tipo al dispositivo
                $urlsavetype = BASE_URL . 'device/' . $newDevice . '/' . $typeId;
                $ch = curl_init($urlsavetype);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_POST, 1);
                $response = curl_exec($ch);

                if ($response !== false) {
                    // La solicitud se realizó con éxito                     
                    $message = "Dispositivo grabado exitosamente.";
                } else {
                    $message = "Error en la solicitud para grabar al tipo de dispositivo.";
                }
                /* // Redirecciona después de 3 segundos
                echo '<meta http-equiv="refresh" content="3;url=index.php?controller=admin&action=deviceChanges">'; 
                exit(); */

            } else {
                echo "Error al obtener el ID del nuevo dispositivo.";
            }
        } 
    }
    
}
//=============== AÑADIR NUEVO TIPO =================================
function recordNewType(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // Recopila los datos del nuevo tipo de dispositivo
            $typeName = strtoupper($_POST['typeName']);
            
            // Define los datos que se enviarán a la API
            $typeData = array(
                "typeName" => $typeName,
            );
            // Realiza una solicitud POST a la API para grabar tippo
            $urlsave = BASE_URL.'types';
            $ch = curl_init($urlsave);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($typeData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_exec($ch);

            $_SESSION['typesave'] = "Nuevo tipo grabado"; // Almacena el mensaje en una variable de sesión
            header('Location: index.php?controller=admin&action=typeChanges');

        }
         

}
//=============== AÑADIR IP ==================================
function recordNewIp(){

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
        // Recopila los datos de la nueva IP
        $netGateWay = $_POST['netGateWay'];
        $netIp = $_POST['netIp'];
        $netMask = $_POST['netMask'];
        $netCdir = '/'.$_POST['netCdir'];
        $netStatus = false;

        
        // Define los datos que se enviarán a la API
        $netData = array(
            "netGateWay" => $netGateWay,
            "netIp" => $netIp,
            "netMask" => $netMask,
            "netCdir" => $netCdir,
            "netStatus" => $netStatus
        );
        // Realiza una solicitud POST a la API para grabar tippo
        $urlsave = BASE_URL.'net';
        $ch = curl_init($urlsave);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($netData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_exec($ch);

        $_SESSION['netsave'] = "Nueva ip grabada"; // Almacena el mensaje en una variable de sesión
        header('Location: index.php?controller=admin&action=netChanges');

    }
     

}

//=============== BUSCAR TODOS ==================================
function getAllSomeThing($something){
     //Listamos los tipos
     $usrsome = BASE_URL.$something;
     $ch = curl_init($usrsome);
     curl_setopt($ch, CURLOPT_URL, $usrsome);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     $usrsome = curl_exec($ch);
     curl_close($ch);
 
     //Recopila los datos 
     $resultlist = json_decode($usrsome, true);
 
     return $resultlist;

}
//============ BUSCAR IPs Y DISPOSITIVO POR IP ======================
function getDeviceIp($ip){
    
    //Listamos la red en totalidad
    $urnet = BASE_URL.'device?ideviceIp='.$ip;
    $ch = curl_init($urnet);
    curl_setopt($ch, CURLOPT_URL, $urnet);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $urnet = curl_exec($ch);
    
    $deviceIp = json_decode($urnet, true);
    curl_close($ch);

    return $deviceIp;
}
// ============ BUSCAR DISPOSITIVO POR ID ===========================
function getDeviceById($id){
    //Listamos los tipos
    $url = BASE_URL.'device/'.$id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $result = json_decode($url, true);

    return $result;

}
// ========== ASIGNAR IP A DISPOSITIVO ============================
function setIpDevice(){
    //Comprobamos que session este iniciada
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recopila los datos del formulario en los campos name de la vista
        $netId = $_POST['netId'];
        $deviceId = $_POST['deviceId'];

        // Realiza una solicitud POST a la API para grabar tippo
        $urlsave = BASE_URL.'net/'.$netId.'/'.$deviceId;
        $ch = curl_init($urlsave);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($netData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_exec($ch);

        echo '<div class="container">';
        echo '<span>IP asignada</span>';
        echo '</div>';
                      
        header("Refresh: 10; url=index.php?controller=admin&action=deviceChanges.php");

        
}
}

//================ AGREGAR DEPARTAMENTO ===================
function recordNewDepart(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // Recopila los datos del nuevo tipo de dispositivo
            $departName = strtoupper($_POST['departmentName']);
            $departPhone = $_POST['departmentPhone'];
            $departMail = $_POST['departmentMail'];
            $departCity = $_POST['departmentCity'];
            // Define los datos que se enviarán a la API
            $departData = array(
                "departmentName" => $departName,
                "departmentPhone" => $departPhone,
                "departmentMail" => $departMail,
                "departmentCity" => $departCity
            );
            // Realiza una solicitud POST a la API para grabar departamento
            $urlsave = BASE_URL.'departments';
            $ch = curl_init($urlsave);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($departData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_exec($ch);

            $_SESSION['deparsave'] = "Nuevo departamento grabado"; // Almacena el mensaje en una variable de sesión
            header('Location: index.php?controller=admin&action=departmentChanges');

        }
         
}
//===================== ELIMINAR DEPARTAMENTO ==================
function eraseDepart($idDepart){
    $url = BASE_URL . 'departments/' . $idDepart; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        echo "Solicitud DELETE exitosa. Respuesta del servidor: " . $response;
        header('Location: index.php?controller=admin&action=departmentChanges');
    }

    curl_close($ch);
}
//=========== UPDATE DEPARTAMENTO ===============
function changeDepart($idDepart){

 if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // Recopila los datos del nuevo tipo de dispositivo
            $departName = strtoupper($_POST['departmentName']);
            $departPhone = $_POST['departmentPhone'];
            $departMail = $_POST['departmentMail'];
            $departCity = $_POST['departmentCity'];
            // Define los datos que se enviarán a la API
            $departData = array(
                "departmentName" => $departName,
                "departmentPhone" => $departPhone,
                "departmentMail" => $departMail,
                "departmentCity" => $departCity
            );
            // Realiza una solicitud POST a la API para grabar departamento
            $urlupdate = BASE_URL.'departments/'.$idDepart;
            $ch = curl_init($urlupdate);
            // Configurar cURL para una solicitud PUT
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            // Codificar los datos como JSON
            $data_json = json_encode($departData);
            // Establecer el cuerpo de la solicitud con los datos JSON
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            // Configurar las cabeceras adecuadas
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            // Ejecutar la solicitud PUT
            $response = curl_exec($ch);
            // Cerrar la sesión cURL
            curl_close($ch);

            $_SESSION['deparsave'] = "Nuevo departamento grabado"; // Almacena el mensaje en una variable de sesión
            

        }         
}
//======== CHANGE ROL =============
function changeRol($idUser,$rol){

        
        $url = BASE_URL.'user/'.$idUser;

        // Datos que envia en la solicitud PATCH 
        $data = [
            "userRol" => $rol
        ];

        $data_string = json_encode($data);

        // Inicializa una instancia de cURL
        $ch = curl_init($url);

        // Configura la solicitud cURL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Indica que es una solicitud PATCH
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // Define los datos a enviar
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json', // Especifica el tipo de contenido (en este caso, JSON)
        ]);

        // Realiza la solicitud cURL y obtén la respuesta
        $response = curl_exec($ch);

        // Cierra la instancia cURL
        curl_close($ch);

        // Maneja la respuesta 
        if ($response) {
            $_SESSION['rolchange'] = 'Rol modificado con exito ';
            header('location: index.php?controller=admin&action=userChanges');
            
           
        } else {
            $_SESSION['rolchange'] = "Error al realizar la solicitud";
            header('location: index.php?controller=admin&action=userChanges');
        }

}
?>
