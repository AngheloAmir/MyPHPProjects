<?php

/*
Usage:
<?php
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/data/gemini.php';
    $gemini = new App\Services\GeminiService();

        try {
            $response = $gemini->generateContent($_GET['question']);
            echo $response;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
}
*/
namespace App\Services;

class GeminiService
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
        $this->apiKey = $_ENV['GEMINI_API_KEY'];
    }

    public function generateContent(string $prompt): string
    {
        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "X-goog-api-key: {$this->apiKey}"
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            throw new \Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);
        $responseData = json_decode($response, true);
        
        return $responseData['candidates'][0]['content']['parts'][0]['text'] ?? 'No response from API';
    }
}