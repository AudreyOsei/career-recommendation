<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<style>

body{

font-family:DejaVu Sans,sans-serif;

color:#333;

font-size:14px;

line-height:1.6;

margin:30px;

}

.header{

text-align:center;

border-bottom:3px solid #0d6efd;

padding-bottom:20px;

margin-bottom:30px;

}

.header h1{

color:#0d6efd;

margin:0;

font-size:28px;

}

.header h2{

margin:8px 0;

font-size:18px;

}

.header p{

color:#666;

margin-top:10px;

}

.section-title{

background:#0d6efd;

color:#fff;

padding:10px;

margin-top:30px;

font-size:16px;

font-weight:bold;

}

table{

width:100%;

border-collapse:collapse;

margin-top:15px;

}

table th{

background:#0d6efd;

color:white;

padding:10px;

border:1px solid #ddd;

}

table td{

padding:10px;

border:1px solid #ddd;

}

.summary{

margin-top:30px;

text-align:justify;

}

.footer{

margin-top:50px;

text-align:center;

font-size:12px;

color:#666;

border-top:1px solid #ccc;

padding-top:20px;

}

</style>

</head>

<body>

<div class="header">

<h1>

Career Recommendation System

</h1>

<h2>

Administrative Report

</h2>

<p>

University of Greenwich

<br>

MSc Computer Science Dissertation

</p>

</div>

<p>

<strong>Date Generated:</strong>

<?= date("d F Y H:i"); ?>

</p>

<div class="section-title">

System Statistics

</div>

<table>

<tr>

<th>Statistic</th>

<th>Value</th>

</tr>

<tr>

<td>Total Registered Users</td>

<td><?= isset($Users) ? $Users : 0 ?></td>

</tr>

<tr>

<td>Total Assessments</td>

<td><?= isset($totalAssessments) ? $totalAssessments : 0 ?></td>

</tr>

<tr>

<td>Total Recommendations</td>

<td><?= isset($totalRecommendations) ? $totalRecommendations : 0 ?></td>

</tr>

<tr>

<td>Total Feedback</td>

<td><?= isset($totalFeedback) ? $totalFeedback : 0 ?></td>

</tr>

<tr>

<td>Average User Rating</td>

<td><?= isset($averageRating) ? number_format($averageRating,1) : 0 ?>/5</td>

</tr>

<tr>

<td>Most Recommended Career</td>

<td><?= isset($topCareer['career_name']) ? htmlspecialchars($topCareer['career_name']) : 'N/A' ?></td>

</tr>

</table>

<div class="section-title">

System Summary

</div>

<div class="summary">

This administrative report provides a summary of the current performance of the Career Recommendation System. It presents key statistics relating to user registration, completed career assessments, AI-generated recommendations and user feedback. The report assists the administrator in monitoring system usage and evaluating the effectiveness of the recommendation engine.

</div>

<div class="footer">

Generated Automatically by

Career Recommendation System

<br>

© <?= date("Y") ?>

Sefakor Y. A. Osei

</div>

</body>

</html>