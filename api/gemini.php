<?php

require_once("../includes/config.php");

function callGemini($prompt)
{
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

    if ($response === false) {
        return false;
    }

    $result = json_decode($response, true);

    return $result['candidates'][0]['content']['parts'][0]['text']
        ?? false;
}

function generateCareerExplanation(
    $careerName,
    $userData,
    $ruleExplanation,
    $aiProfile
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

AI Behaviour Analysis:

Confidence:
{$aiProfile['confidence']}

Motivation:
{$aiProfile['motivation']}



Technical Score:
{$aiProfile['technical']}

Creativity Score:
{$aiProfile['creativity']}

Leadership Score:
{$aiProfile['leadership']}

Communication Score:
{$aiProfile['communication']}

Problem Solving Score:
{$aiProfile['problem_solving']}


AI Career Reasoning:

Generate a personalised explanation.

Do not simply repeat the questionnaire.

Use both the questionnaire responses and the AI behavioural analysis.

Acknowledge the student's strengths.

If appropriate, acknowledge challenges without discouraging them.

Explain WHY this career fits the student.

Keep the explanation professional, encouraging and under 120 words.

";

  $response = callGemini($prompt);

    if ($response === false) {
        return $ruleExplanation;
    }

    return $response;
}

function analyzeUserProfile($userData)
{
    $activities =
        $userData['activities'] ?? '';

    $careerInterest =
        $userData['career_interest'] ?? '';

    $challenges =
        $userData['challenges'] ?? '';

    $prompt = <<<PROMPT

You are an experienced Career Psychologist, Career Counsellor and AI Career Recommendation Expert.

You are analysing a student's written responses from a career assessment questionnaire.

Your job is NOT simply to recommend careers.

Your job is to understand the student's:

• Personality
• Emotional state
• Motivation
• Confidence
• Communication ability
• Technical aptitude
• Creativity
• Leadership potential
• Problem-solving ability
• Preferred working style
• Preferred learning style
• Career aspirations

Student Responses

Activities:
$activities

Career Interest:
$careerInterest

Challenges:
$challenges

Carefully analyse the writing.

Infer hidden characteristics where appropriate.

Do not simply repeat what the student wrote.

Based on your analysis, score the student objectively.

Return ONLY valid JSON.

{
    "confidence":"High|Medium|Low",
    "motivation":"High|Medium|Low",
    "emotional_state":"text",
    "personality":"text",
    "work_style":"Independent|Team|Hybrid",
    "learning_style":"Practical|Visual|Analytical|Collaborative",

    "technical":0,
    "creativity":0,
    "leadership":0,
    "communication":0,
    "problem_solving":0,

    "strengths":[
        "",
        "",
        ""
    ],

    "weaknesses":[
        "",
        "",
        ""
    ],

    "recommended_careers":[
        "",
        "",
        ""
    ],

    "reasoning":"Explain briefly why these careers fit this student."
}

Important Rules

• Scores must be between 0 and 100.

• Return ONLY JSON.

• Do not include markdown.

• Do not include explanations outside the JSON.

PROMPT;

    $response = callGemini($prompt);

    if ($response === false) {
        return [];
    }

   echo "<h2>Gemini Raw Response</h2>";
echo "<pre>";
echo htmlspecialchars($response);
echo "</pre>";
exit();
}
?>