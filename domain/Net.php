<?php
class Net {
  public $netId;
  public $netIp;
  public $netMask;
  public $netCdir;
  public $netGateWay;
  public $netStatus;

  function __construct() {

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
// =========== UPDATE IP (LIBERAR) ===========================
function eraseIp($idNet) {

  $url = BASE_URL.'net/'.$idNet;

      // Datos que envia en la solicitud PATCH 
      $data = [
          "netStatus" => false
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
          $_SESSION['rolchange'] = 'Ip liberada ';
          header('location: index.php?controller=admin&action=netChanges');
          
         
      } else {
          $_SESSION['rolchange'] = "Error al realizar la solicitud";
          header('location: index.php?controller=admin&action=netChanges');
      }

}

}
?>
