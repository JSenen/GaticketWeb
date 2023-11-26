<?php
class Type{

    public $typeId;
    public $typeName;

    function __construct(){}


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

}
?>

