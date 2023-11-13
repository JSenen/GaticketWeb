<?php
class Incidence {

    public $incidencesId;
    public $incidenceCommit;
    public $incidenceStatus;
    public $incidenceDate;
    public $incidenceDateFinish;
    public $incidenceTheme;
    public $adminId;

    // =========== GRABAR TICKET ================================
function recordTicket() {
    ob_start();
    // Comprobamos que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $fecha_actual = date('d/m/y');
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recopila los datos del formulario en los campos name
        $incidenceCommit = $_POST['commit_incidence'];
        $incidenceTheme = strtoupper($_POST['theme_incidence']);
        $incidenceStatus = "active";
        $incidenceDate = $fecha_actual;
        $incidenceDateFinish = "";
        // Inicializa $endpoint a un valor predeterminado
        $endpoint_device = BASE_URL . 'device';

        // Inicializa $endpoint a un valor predeterminado
$endpoint_device = BASE_URL . 'device';
// Verifica si se proporciona deviceSerial o deviceMac
if (
    (isset($_POST['deviceSerial']) && !empty($_POST['deviceSerial'])) ||
    (isset($_POST['deviceMac']) && !empty($_POST['deviceMac']))
) {
    // Determina si es deviceSerial o deviceMac según la opción seleccionada en el formulario
    if ($_POST['typeId'] === 'deviceSerial') {
        $fieldValue = $_POST['deviceSerial'];
        $endpoint_device .= '?deviceSerial=' . $fieldValue;
    } elseif ($_POST['typeId'] === 'deviceMac') {
        $fieldValue = $_POST['deviceMac'];
        $endpoint_device .= '?mac=' . $fieldValue;
    }
    // GET device según $endpoint formado
    $ch = curl_init($endpoint_device);
    curl_setopt($ch, CURLOPT_URL, $endpoint_device);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultDevice = curl_exec($ch);
    curl_close($ch);
    // Decodificamos Json
    $dataDevice = json_decode($resultDevice, true);
    // Verificar si $dataDevice está definido y no está vacío
    if (!empty($dataDevice) && is_array($dataDevice)) {
        // Obtener el valor del deviceId si está presente
        $deviceId = isset($dataDevice[0]['deviceId']) ? $dataDevice[0]['deviceId'] : null;
    }
}
        // Recopila datos del usuario para grabar el ticket
        $userId = $_SESSION['user_id'];
        $userTip = $_SESSION['user_tip'];

        // Define los datos que se enviarán a la API
        $incidencedata = array(
            'incidenceCommit' => $incidenceCommit,
            'incidenceTheme' => $incidenceTheme,
            'incidenceStatus' => $incidenceStatus,
            'incidenceDate' => $incidenceDate,
            'incidenceDateFinish' => $incidenceDateFinish
        );   
       // Agrega el dispositivo solo si se proporcionó uno
        if (!empty($dataDevice) && isset($dataDevice[0]['deviceId'])) {
            $incidencedata['device'] = array(
                'deviceId' => $dataDevice[0]['deviceId']
            );
        } else {
            $incidencedata['device'] = null; // Si no se ha proporcionado ningún dato
        }
        // Realiza una solicitud POST a la API para grabar una incidencia
        $url = BASE_URL . 'incidence/' . $userId;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($incidencedata));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);
        //Después de procesar la solicitud, redirigir de nuevo a la pagina listado
        $_SESSION['savedticket'] = 'Incidencia recibida';
        ob_end_clean();
        header('Location: index.php?controller=user&action=listIncidencesUser'); 
    }
}
//===================== DATOS COMPLETOS INCIDENCIAS por ID ==================================
function searchIncidence($incidenceId){
    //Buscamos la incidencia
  
    $urllistincidences = BASE_URL.'incidences/'.$incidenceId;
    $ch = curl_init($urllistincidences);
    curl_setopt($ch, CURLOPT_URL, $urllistincidences);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    //Recopila el listado de incidencias del usuario
    //Decodificamos json
    $searchIncidence = json_decode($result, true);
    $idUser = $searchIncidence['user']['userId'];

    //Cambiar el estado de la incidencia a "En proceso"
    //Datos a actualizar
    if ($_SESSION['user_rol'] == 'administrador') {
      
    $dataToChange = array (
        'incidenceSatus' => 'process'
    );
    $urlchangeincidence = BASE_URL.'incidence/'.$incidenceId;
    $ch = curl_init($urlchangeincidence);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Indica que es una solicitud PATCH
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataToChange)); // Define los datos a enviar
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Especifica el tipo de contenido (en este caso, JSON)
    ]);
    // Realiza la solicitud cURL y obtén la respuesta
    $response = curl_exec($ch);
    // Cierra la instancia cURL
    curl_close($ch);

    if (curl_errno($ch)) {
        echo 'Error en la solicitud PATCH: ' . curl_error($ch);
    }
}
    //Buscamos datos del departamento del usuario
    $urllistdepart = BASE_URL.'department/'.$idUser;
    $ch = curl_init($urllistdepart);
    curl_setopt($ch, CURLOPT_URL, $urllistdepart);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resultDepart = curl_exec($ch);
    curl_close($ch);

     // Decodifica los datos del departamento
     $userDepartment = json_decode($resultDepart, true);

     // Combina la información de la incidencia y el departamento en un array
     $resultIncidence = array(
         'incidence' => $searchIncidence,
         'department' => $userDepartment
     );
            
    return $resultIncidence;
}
//======= LEER TODO LOS MENSAJES DE LA INCIDENCIA
function getAllMenssagesIncidence($idIncidence){
    //Listamos los tipos
    $usrsome = BASE_URL.'messages/'.$idIncidence;
    $ch = curl_init($usrsome);
    curl_setopt($ch, CURLOPT_URL, $usrsome);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $usrsome = curl_exec($ch);
    curl_close($ch);

    //Recopila los datos 
    $resultlist = json_decode($usrsome, true);

    return $resultlist;

}
//======= ASOCIAR INCIDENCIA A ADMINISTRADOR ====
function giveIncidenceAdmin($idIncidence,$idAdmin){

    $urlAddAdmin = BASE_URL.'incidence/admin/'.$idIncidence;
    
    //Datos a actualizar, Id de admnistrador
    $dataToChange = array (
        'adminId' => $idAdmin
    );
    $ch = curl_init($urlAddAdmin);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH'); // Indica que es una solicitud PATCH
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataToChange)); // Define los datos a enviar
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json', // Especifica el tipo de contenido (en este caso, JSON)
    ]);
    // Realiza la solicitud cURL y obtén la respuesta
    $response = curl_exec($ch);
    // Cierra la instancia cURL
    curl_close($ch);
}

//======= FINALIZAR INCIDENCIA y GRABAR A HISTORIAL ==========
function finsihIncidence($idIncidence,$incidenceToSolve,$solution,$adminTip){
    ob_start();
    // Comprobamos que la sesión esté iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
   
    // Verifica si $_SESSION['user_id'] es un array antes de acceder a sus elementos
    $userIdArray = is_array($_SESSION['user_id']) ? $_SESSION['user_id'] : array();
    $incidenceDateFinish = $fecha_actual = date('d/m/Y');

    // Accede a 'user' dentro de $_SESSION['user_id']
    $userTip = isset($incidenceToSolve['incidence']['user']['userTip']) ? $incidenceToSolve['incidence']['user']['userTip'] : null;

    // Datos a grabar
    $dataToChange = array (
        'historyTip' => $userTip,
        'historyTheme' => isset($incidenceToSolve['incidence']['incidenceTheme']) ? $incidenceToSolve['incidence']['incidenceTheme'] : null,
        'historyCommit' => isset($incidenceToSolve['incidence']['incidenceCommit']) ? $incidenceToSolve['incidence']['incidenceCommit'] : null,
        'historyDateFinish' => $incidenceDateFinish,
        'historyAdmin' => $adminTip,
        'historySolution' => $solution
        );

        $endpoint_history = BASE_URL.'history';
        $ch = curl_init($endpoint_history);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataToChange));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);  
        curl_close($ch);     
        
        //Eliminar incidencia despues de grabarla en history
        $urlDelIncidence = BASE_URL.'incidence/'.$idIncidence;
        $ch = curl_init($urlDelIncidence);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        ;
        $responsedelete = curl_exec($ch);
        curl_close($ch);
        // Redirigir después de la acción
        header('Location: index.php?controller=admin&action=ticketlist');
        exit();
    }
}
?>



