<?php
class Device{

    public $deviceId;
    public $deviceHd;
    public $deviceRam;
    public $deviceMAc;
    public $deviceSerial;
    public $deviceModel;
    public $deviceDateBuy;
    public $deviceDateStart;

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
    $urldevice = BASE_URL.'device?typeId='.$typeId;
    $ch = curl_init($urldevice);
    curl_setopt($ch, CURLOPT_URL, $urldevice);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($ch);
    curl_close($ch);
    //Recopila los datos 
    $devicesTypeName = json_decode($url, true);
    return $devicesTypeName;
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

}
?>

