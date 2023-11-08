<?php

// Verifica si la variable de entorno API_KEY está definida en el archivo .env
if (getenv('API_KEY')) {
    define('API_KEY', getenv('API_KEY'));
} else {
    // Si no se encuentra en el archivo .env,  proporcionar un valor predeterminado o mostrar un mensaje de error.
    define('API_KEY', 'Valor_Por_Defecto');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_query = $_POST["user_query"];

    
    $api_url = "https://api.openai.com/v1/chat/completions"; // Reemplaza con la URL correcta de la API

    $data = json_encode([
        "query" => $user_query,
        // Otros parámetros opcionales si es necesario
    ]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . $api_key,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error en la solicitud a ChatGPT.";
    } else {
        $result = json_decode($response, true);
        // Procesa y envia la respuesta en la página
    }

    curl_close($ch);
}
?>

<!-- Formulario HTML -->
<form method="post">
    <input type="text" name="user_query" placeholder="Ingresa tu consulta">
    <button type="submit">Enviar consulta</button>
</form>