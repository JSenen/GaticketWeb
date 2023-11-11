<?php
class Messages{
    
    public $idMenssage;
    public $messageCommit;
    public $timeMessage;

   function adminMessages($idIncidence,$idAdmin){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
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
        $endpoint_device = BASE_URL . 'messages/'.$idIncidence.'/'.$idAdmin;

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

}

?>