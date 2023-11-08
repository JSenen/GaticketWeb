<!-- Intercambio general de datos con la API -->
<?php

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
            $deviceSerialNumber = $_POST['deviceSerial'];
            $deviceMAc = $_POST['deviceMac'];

           // Inicializa $endpoint a un valor predeterminado
            $endpoint = BASE_URL.'/device';

            if (isset($_POST['deviceSerial']) && !empty($_POST['deviceSerial'])) {
                $deviceSerialNumber = $_POST['deviceSerial'];
                $endpoint .= '?deviceSerial=' . $deviceSerialNumber;
            } elseif (isset($_POST['deviceMac']) && !empty($_POST['deviceMac'])) {
                $deviceMac = $_POST['deviceMac'];
                $endpoint .= '?mac=' . $deviceMac;
            } else 
            
            

                // 1º GET device según $endpoint formado
                if ($deviceSerialNumber !== null || $deviceMac !== null) {
                    $ch = curl_init($endpoint);
                    curl_setopt($ch, CURLOPT_URL, $endpoint);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    // Decodificamos Json
                    $data = json_decode($result, true);
                    // Verificar si se obtuvo una respuesta válida y si el campo "deviceId" está presente
                    if (is_array($data) && isset($data['deviceId'])) {
                        // Obtener el valor del deviceId
                        $deviceId = $data['deviceId'];
                    } else {
                        echo "No se pudo encontrar el deviceId para el número de serie o dirección MAC proporcionada."; // 
                    }
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
                        'incidenceDateFinish' => $incidenceDateFinish
                    );

                    // Agrega el dispositivo solo si se proporcionó uno
                    if ($deviceSerialNumber !== null || $deviceMac !== null) {
                        $incidencedata['device'] = array(
                            'deviceId' => $deviceId
                        );
                    }

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
                    $_SESSION['rolchange'] = "Dispositivo grabado.";
                } else {
                    $_SESSION['rolchange'] = "Error en la solicitud para grabar al tipo de dispositivo.";
                }
                
                echo '<meta http-equiv="refresh" content="0.1;url=index.php?controller=admin&action=deviceChanges">'; 
                exit(); 

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
function setIpDevice($device){
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




//============ ELIMINAR DISPOSITIVO ====================
function eraseDevice($idDevice){
    $url = BASE_URL . 'device/' . $idDevice; 
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error de cURL: " . curl_error($ch);
    } else {
        $_SESSION['rolchange'] =  "Dispositivo eliminado: ";
        header('Location: index.php?controller=admin&action=deviceChanges');
    }

    curl_close($ch);
}

// ======== DISPOSITIVOS POR TIPO ==========
function getAllByType($typeId){

    //Obtenemos nombre del tipo de dispositivo
    $url = BASE_URL.'types/'.$typeId;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $result = json_decode($url, true);
    $name = $result['typeName'];

    //Buscamos los dispositivos con el tipo.
    $urldevice = BASE_URL.'device?typeName='.$name;
    $ch = curl_init($urldevice);
    curl_setopt($ch, CURLOPT_URL, $urldevice);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($ch);
    curl_close($ch);
    //Recopila los datos 
    $devicesTypeName = json_decode($url, true);
    return $devicesTypeName;


}
?>
