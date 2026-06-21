<?php

require_once("../includes/config.php");

function generateCareerExplanation(
    $careerName,
    $userData,
    $ruleExplanation
) {

    $prompt = "

You are a career guidance assistant.

Career:
$careerName

Student Information:
Course: {$userData['course']}
Level: {$userData['level']}
Interests: " . implode(", ", $userData['interest']) . "
Skill: {$userData['skill']}
Environment: {$userData['environment']}
Goals: " . implode(", ", $userData['goal']) . "

Student Reflections:
Activities:
{$userData['activities']}

Career Interest:
{$userData['career_interest']}

Challenges:
{$userData['challenges']}

Generate a short professional explanation
under 80 words explaining why this career
may suit the student.

";

    $url =
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key="
        . GEMINI_API_KEY;

    $data = [
        "contents" => [[
            "parts" => [[
                "text" => $prompt
            ]]
        ]]
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/json",
            "method" => "POST",
            "content" => json_encode($data),
            "ignore_errors" => true
        ]
    ];

    $context =
        stream_context_create($options);

    $response =
        @file_get_contents(
            $url,
            false,
            $context
        );

    // If API fails → fallback
    if ($response === false) {
        return $ruleExplanation;
    }

    $result =
        json_decode($response, true);

    return $result['candidates'][0]
    ['content']['parts'][0]['text']
    ?? $ruleExplanation;
}