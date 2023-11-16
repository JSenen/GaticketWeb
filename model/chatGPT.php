<?php
function talkChatGpt($user_query){
    // Obtén la API key de las variables de entorno

    $api_url = "https://api.openai.com/v1/chat/completions"; 

    $data = json_encode([
        "model" => "gpt-3.5-turbo",
        "messages" => [],  
        "temperature" => 0.5,
        "max_tokens" => 256,
        "query" => $user_query  // Añade el query d
    ]);

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer " . API_KEY,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error en la solicitud a ChatGPT: " . curl_error($ch);
        return null;
    } else {
        $result = json_decode($response, true);
        return $result['error']['message'];
    }
    
    curl_close($ch);
   
}
?>