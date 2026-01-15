<?php
error_reporting(0);
ob_clean();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Read input
$input = json_decode(file_get_contents('php://input'), true);
$user_msg = trim($input['message'] ?? '');

if ($user_msg === '') {
    echo json_encode(['reply' => "Please ask about trip, itinerary, or places!"]);
    exit;
}

// Free Groq Model
$groq_model = "llama-3.1-8b-instant";

// Your API Key
$groq_api_key = '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'; 

// System + User messages
$messages = [
    [
        "role" => "system",
        "content" => "You are DreamBot — expert travel planner."
    ],
    [
        "role" => "user",
        "content" => $user_msg
    ]
];

// Prepare payload
$payload = [
    "model" => $groq_model,
    "messages" => $messages,
    "max_tokens" => 650,
    "temperature" => 0.4
];

$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $groq_api_key",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
curl_close($ch);

// If Groq returned HTML → show it so you can debug
if (!json_decode($response, true)) {
    echo json_encode([
        'reply' => "⚠️ INVALID RESPONSE FROM SERVER:\n\n" . $response
    ]);
    exit;
}

$decoded = json_decode($response, true);
$reply = $decoded['choices'][0]['message']['content'] ?? "Sorry, no response.";

echo json_encode(['reply' => $reply]);
?>
