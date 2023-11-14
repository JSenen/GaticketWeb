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

}
?>

