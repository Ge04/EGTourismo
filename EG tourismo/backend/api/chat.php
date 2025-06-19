<?php
require_once '../config/config.php';

header('Content-Type: application/json');

// Enable error logging
error_log("Chat API called at " . date('Y-m-d H:i:s'));

try {
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);
    $message = $data['message'] ?? '';

    if (empty($message)) {
        throw new Exception('No message provided');
    }

    // Log the incoming message
    error_log("Received message: " . $message);

    // Prepare the API request
    $ch = curl_init(OPENAI_API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENAI_API_KEY
    ]);

    $requestData = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Eres un asistente virtual especializado en turismo en Guinea Ecuatorial. Proporciona información precisa y útil sobre destinos, cultura, actividades, y consejos de viaje. Mantén un tono amigable y profesional.'
            ],
            [
                'role' => 'user',
                'content' => $message
            ]
        ],
        'temperature' => 0.7,
        'max_tokens' => 150
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode !== 200) {
        $error = curl_error($ch);
        error_log("API Error: " . $error);
        throw new Exception('API request failed: ' . $error);
    }

    curl_close($ch);

    // Process the response
    $responseData = json_decode($response, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log("JSON decode error: " . json_last_error_msg());
        throw new Exception('Invalid API response');
    }

    $botResponse = $responseData['choices'][0]['message']['content'] ?? '';
    
    if (empty($botResponse)) {
        throw new Exception('Empty response from API');
    }

    // Log the successful response
    error_log("Successfully generated response");
    
    echo json_encode(['response' => $botResponse]);

} catch (Exception $e) {
    error_log("Error in chat.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 