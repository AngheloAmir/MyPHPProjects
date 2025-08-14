<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>FOR HR</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<?php
    function formatResumeToString($resume) {
        $output = "RESUME OF {$resume['name']}\n";
        $output .= str_repeat("=", 50) . "\n\n";
        $output .= "Title: {$resume['title']}\n";
        $output .= "Contact: {$resume['email']} | {$resume['phone']}\n";
        $output .= "Location: {$resume['location']}\n\n";
        $output .= "SUMMARY:\n{$resume['summary']}\n\n";
        $output .= "WORK EXPERIENCE:\n";
        foreach ($resume['work_experience'] as $job) {
            $output .= "- {$job['role']} at {$job['company']} ({$job['duration']}, {$job['location']})\n";
            if (!empty($job['responsibilities'])) {
                foreach ($job['responsibilities'] as $responsibility) {
                    $output .= "  • $responsibility\n";
                }
            }
            $output .= "\n";
        }
        
        $output .= "SKILLS:\n";
        foreach ($resume['skills'] as $category => $skills) {
            $category = ucwords(str_replace('_', ' ', $category));
            $output .= "- {$category}: " . implode(', ', $skills) . "\n";
        }
        $output .= "\n";
        
        $output .= "PROJECTS:\n";
        foreach ($resume['projects'] as $project) {
            $output .= "- {$project['name']}\n";
            $output .= "  {$project['description']}\n";
            if (isset($project['url'])) {
                $output .= "  URL: {$project['url']}\n";
            }
        }
        $output .= "\n";
        
        $output .= "EDUCATION:\n";
        foreach ($resume['education'] as $edu) {
            $output .= "- {$edu['degree']}\n";
            $output .= "  {$edu['institution']} ({$edu['duration']})\n";
            if (isset($edu['location'])) {
                $output .= "  {$edu['location']}\n";
            }
        }
        $output .= "\n";
        
        $output .= "LANGUAGES: " . implode(', ', $resume['languages']) . "\n";
        
        if (isset($resume['portfolio_url'])) {
            $output .= "Portfolio: {$resume['portfolio_url']}\n";
        }
        
        return $output;
    }
?>

<body class="bg-gray-500 flex  justify-center h-screen p-5">
    <div class="flex flex-col justify-between bg-white w-11/12 md:w-[600px] bg-gray-100">
        <div>
            <header class="flex justify-center p-2 bg-blue-500">
                <h1 class="text-lg">
                    Welcome to my
                    <span class="font-bold"> AI Powered Resume </span>
                    with PHP

                    <br />
                    <span class="text-sm">
                        Use this to check my qualification based on my resume
                    </span>
                </h1>
            </header>

            <div class="border px-5 py-2">
                <h2 class="text-lg">Suggested question:</h2>
                <p class="text-sm pl-5">
                    What is your main skills
                    <br />
                    List down your work experience
                </p>
            </div>

            <form onsubmit="<?php $_SERVER['PHP_SELF'] ?>" method="get" class="w-11/12 mx-auto flex flex-col">
                <label>Your Question to me?</label>
                <input type="text" name="question" class="border p-2 bg-gray-200 my-2"/>
                <button type="submit" class="bg-blue-500 border p-1 rounded" >Submit</button>
            </form>
            </div>
        
        <div class="border px-5 py-2 my-2 h-full">
            <h1 class="text-lg">AI Response</h1>

            <p>
            <?php 
                if (isset($_GET['question'])) {
                    require_once __DIR__ . '/vendor/autoload.php';
                    require_once __DIR__ . '/data/gemini.php';
                    $gemini = new App\Services\GeminiService();

                //generate a prompt that will be used with the AI
                    $resume     = require './data/resume.php';
                    $resumeText = formatResumeToString($resume);
                    $prompt     = 'You act like a interviewee and an hr will ask you regarding your resume Answer short as much as possible. This is the resume: ' . 
                                  $resumeText . '\nThis is the question '.
                                  $_GET['question'];

                    try {
                        $response = $gemini->generateContent( $prompt );
                        echo $response;
                    } catch (\Exception $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            ?>

            </p>
        </div>

        <footer>
            Powered by gemini-2.0-flash:generateContent
        </footer>
    </div>
</body>
    
</body>
</html>