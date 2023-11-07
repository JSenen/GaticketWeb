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


}
?>

