<html>
    <head>
        <title>AI Gemini</title>
    </head>
    <body>
        <h1>AI Gemini</h1>
        <form action="" method="get">
            <input type="text" name="question" />
            <button type="submit">Ask</button>
        </form>

<?php 
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    if( isset($_GET['question']) ) {
        $apiKey = $_ENV['GEMINI_API_KEY'];
        $url    = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
        $data = [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $_GET['question']
                        ]
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "X-goog-api-key: $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        } else {
            $airesponse = json_decode( $response, true );
            echo $airesponse['candidates'][0]['content']['parts'][0]['text'];
        }
        curl_close($ch);

    }
?>






        
    </body>



</html>