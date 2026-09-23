<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['reply' => 'Only POST allowed']);
    exit;
}

$userMessage = trim($_POST['message'] ?? '');
if ($userMessage === '') {
    echo json_encode(['reply' => 'Please type something.']);
    exit;
}

/* ============== config da IA google ============== */
$model   = 'gemini-2.0-flash';  
$apiKey  = ''; //KEY
/* ============================================= */

$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$payload = json_encode([
    'contents' => [
        [
            'parts' => [
                ['text' => $userMessage]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 500
    ]
]);

//logica pra tentar varias vezes
$maxRetries = 3;
$response = null;
$httpCode = 0;
//inicio do curl
for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json'
            
        ],
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_TIMEOUT        => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr  = curl_error($ch);
    curl_close($ch);

    if ($response !== false && $httpCode < 400) break;

    if ($httpCode === 429 || $response === false) {
        $delay = pow(2, $attempt);
        error_log("Gemini 429/timeout. Retrying in {$delay}s...");
        sleep($delay);
    } else {
        break;
    }
}

if ($response === false || $httpCode >= 400) {
    $err = $curlErr ?: "HTTP $httpCode";
    error_log("cURL error after retries: $err");
    echo json_encode(['reply' => 'Sorry, AI is down. Try again!']);
    exit;
}
//volta pro javascript
$apiData = json_decode($response, true);
$reply = $apiData['candidates'][0]['content']['parts'][0]['text'] ?? 'No reply.';
$reply = trim($reply);

echo json_encode(['reply' => $reply]);
