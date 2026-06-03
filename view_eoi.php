<?php
session_start();
require_once 'settings.php';

if (!isset($_SESSION["isloggedon"]) || $_SESSION["isloggedon"] !== true || $_SESSION["role"] !== 'HR') {
    die("Access denied.");
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid EOI ID.");
}

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$eoi_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM EOI WHERE EOI_ID = ?");
$stmt->bind_param("i", $eoi_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("EOI record not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>EOI Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        td:first-child {
            font-weight: bold;
            width: 250px;
        }
    </style>
</head>
<body>

<h2>EOI Application #<?= $row['EOI_ID'] ?></h2>

<table>
<?php
foreach ($row as $field => $value) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($field) . "</td>";
    echo "<td>" . nl2br(htmlspecialchars($value)) . "</td>";
    echo "</tr>";
}
?>
</table>

</body>
</html>