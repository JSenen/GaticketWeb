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

}
?>
