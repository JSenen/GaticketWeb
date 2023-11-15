<?php
class Messages{
    
    public $idMenssage;
    public $messageCommit;
    public $timeMessage;

    /** Función que guarda los mensajes entre usuarios y administradores
     * @param string $messageCommit Cuerpo del mensaje
     * @param DateTime $timeMessage hora de envio del mensaje
     * @param string $endpoint_device endpoint de la api para el registro de mensajes
     * @param int $idIncidence Numero Id de la incidencia
     * @param int $idAdmin Numero Id del que envia el mensaje
     * @param array $response Listado de los mensajes obtenidos de la api
     * @return array lista de mensajes por Id de incidencia e Id de usuario
     */
   function adminMessages($idIncidence,$idUser){
   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recopila los datos del mesnaje
        $messageCommit = $_POST['messageCommit'];
        // Obtener la fecha y hora actuales en el formato "2023-11-11T19:15:01" para la API
        $timeMessage = date('Y-m-d\TH:i:s');
        // Combinar el mensaje y la fecha en un array
        $data = [
            'messageCommit' => $messageCommit,
            'timeMessage' => $timeMessage
        ];
        // Inicializa $endpoint a un valor predeterminado
        $endpoint_device = BASE_URL . 'messages/'.$idIncidence.'/'.$idUser;

        // Inicializa cURL
        $ch = curl_init($endpoint_device);

        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Envía los datos en formato JSON

        // Configura las cabeceras
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            // Puedes agregar otras cabeceras según sea necesario
        ]);

        // Ejecuta la solicitud cURL
        $response = curl_exec($ch);

        // Cierra la sesión cURL
        curl_close($ch);
    }
    
    
   }
    /** Función que obtiene todos los mensajes desde el Id de una incidencia
     * @param string $urlmessage url de peticion a la api
     * @param string $idIncidence Numero Id de la incidencia
     * @param int $idIncidence Numero Id de la incidencia
     * @param int $idAdmin Numero Id del que envia el mensaje
     * @param array $response Listado de los mensajes obtenidos de la api
     * @return array lista de mensajes por Id de incidencia
     */
   function getAllMessages($idIncidence){

    $urlmessage = BASE_URL.'message/'.$idIncidence;
    $ch = curl_init($urlmessage);
    curl_setopt($ch, CURLOPT_URL, $urlmessage);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $urnet = curl_exec($ch);
    
    $messages = json_decode($urlmessage, true);
    curl_close($ch);

    return $messages;
    
   }
   

}

?>