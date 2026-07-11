<?php

require_once("../../vendor/autoload.php");
require_once("../../includes/db.php");

use Dompdf\Dompdf;

if (!isset($conn) || !$conn) {
    die("Database connection error");
}

/*==================================
Retrieve Report Data
==================================*/

$totalUsers=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) total FROM users")
)['total'];

$totalAssessments=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) total FROM assessment_responses")
)['total'];

$totalRecommendations=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) total FROM recommendations")
)['total'];

$totalFeedback=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT COUNT(*) total FROM feedback")
)['total'];

$averageRating=mysqli_fetch_assoc(
mysqli_query($conn,
"SELECT AVG(rating) average_rating FROM feedback")
)['average_rating'];

$topCareer=mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT career_name,
COUNT(*) total
FROM recommendations
GROUP BY career_name
ORDER BY total DESC
LIMIT 1
"));

ob_start();

include(__DIR__ . "/../templates/reports_template.php");

$html=ob_get_clean();

$dompdf=new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper("A4","portrait");

$dompdf->render();

$dompdf->stream(
"Administrative_Report.pdf",
["Attachment"=>true]
);

exit;

?>