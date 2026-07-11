<?php

include("../includes/header.php");
include("../includes/sidebar.php");

if (!isset($conn)) {
    die("Database connection error: \$conn is not defined.");
}
/*==============================
System Information
===============================*/

$phpVersion = phpversion();

$mysqlVersion = mysqli_get_server_info($conn);

$databaseStatus = "Connected";

$geminiStatus = "Connected";

$dompdfStatus = class_exists('Dompdf\Dompdf')
? "Installed"
: "Not Installed";

?>

<div class="d-flex justify-content-between align-items-center mb-5">

<div>

<h2 class="fw-bold">

<i class="bi bi-gear-fill text-primary"></i>

System Settings

</h2>

<p class="text-muted">

Manage administrator information and system configuration.

</p>

</div>

</div>

<div class="card shadow mb-4">

<div class="card-header bg-primary text-white">

Administrator Information

</div>

<div class="card-body">

<table class="table">

<tr>

<th width="220">

Administrator

</th>

<td>

<?= $_SESSION['admin_name']; ?>

</td>

</tr>

<tr>

<th>

Role

</th>

<td>

System Administrator

</td>

</tr>

<tr>

<th>

Session

</th>

<td>

Active

</td>

</tr>

</table>

</div>

</div>

<div class="card shadow mb-4">

<div class="card-header bg-success text-white">

System Information

</div>

<div class="card-body">

<table class="table">

<tr>

<th>

Application Version

</th>

<td>

1.0

</td>

</tr>

<tr>

<th>

PHP Version

</th>

<td>

<?= $phpVersion ?>

</td>

</tr>

<tr>

<th>

MySQL Version

</th>

<td>

<?= $mysqlVersion ?>

</td>

</tr>

<tr>

<th>

Database Status

</th>

<td>

<span class="badge bg-success">

<?= $databaseStatus ?>

</span>

</td>

</tr>

<tr>

<th>

Google Gemini API

</th>

<td>

<span class="badge bg-success">

<?= $geminiStatus ?>

</span>

</td>

</tr>

<tr>

<th>

Dompdf

</th>

<td>

<span class="badge bg-success">

<?= $dompdfStatus ?>

</span>

</td>

</tr>

</table>

</div>

</div>

<div class="card shadow mb-4">

<div class="card-header bg-dark text-white">

Project Information

</div>

<div class="card-body">

<table class="table">

<tr>

<th width="220">

Project

</th>

<td>

Career Recommendation System

</td>

</tr>

<tr>

<th>

Developer

</th>

<td>

Sefakor Y. A. Osei

</td>

</tr>

<tr>

<th>

University

</th>

<td>

University of Greenwich

</td>

</tr>

<tr>

<th>

Programme

</th>

<td>

MSc Computer Science

</td>

</tr>

<tr>

<th>

Academic Year

</th>

<td>

2025 / 2026

</td>

</tr>

</table>

</div>

</div>

<?php

include("../includes/footer.php");

?>