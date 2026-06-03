<?php
require_once 'settings.php';

if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Missing parameters.");
}

$eoi_id = intval($_GET['id']);

switch ($_GET['type']) {
    case 'cl':
        $column = 'Cover_Letter';
        $filename = "Cover_Letter_" . $eoi_id . ".pdf";
        break;

    case 'res':
        $column = 'Resume';
        $filename = "Resume_" . $eoi_id . ".pdf";
        break;

    default:
        die("Invalid file type.");
}

$conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

$stmt = $conn->prepare("SELECT $column FROM EOI WHERE EOI_id = ?");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $eoi_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("File not found.");
}

$stmt->bind_result($file_data);
$stmt->fetch();

$stmt->close();
$conn->close();

if (empty($file_data)) {
    die("No file stored.");
}

if (ob_get_level()) {
    ob_end_clean();
}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . strlen($file_data));

echo $file_data;
exit;
?>