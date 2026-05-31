<?php
    //////////////////////////////////////////////////////////
    //                                                      //
    //            Admin Manage System                       //
    //            Author: Blake Stone                       //
    //            Date Of Creation: 29/5/2026               //
    //            File Size: 5,571 Bytes                    //
    //                                                      //
    //////////////////////////////////////////////////////////


session_start();
require_once 'settings.php';

//development error reporting
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if (!isset($_SESSION["isloggedon"]) || $_SESSION["isloggedon"] !== true || $_SESSION["role"] !== 'HR') {
    header("Location: Login_Page.php?message=" . urlencode("You must be logged in with the 'HR' role to access this page."));
    exit();
}

//connect to mysql database
 $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }
    
function GetTableName() {
    return 'EOI';
}

function GetIdColumnName() {
    return 'EOI_ID';
}

$table = GetTableName();
$id_col = GetIdColumnName($table);
$sql_table = $conn->real_escape_string($table);
$searchEOI = isset($_GET['searchEOI']) ? $_GET['searchEOI'] : '';
$searchEOI_safe = $conn->real_escape_string($searchEOI);

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM $sql_table WHERE $id_col = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("ID $delete_id deleted successfull from $table."));
    exit();
}

if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])){
    $toggle_id = intval($_GET['toggle']);
    $stmt = $conn->prepare("SELECT status FROM $table WHERE $id_col = ?");
    $stmt->bind_param("i", $toggle_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();

    $new_status = ($current_status === 'Accepted') ? 'Rejected' : 'Accepted';
    $stmt = $conn->prepare("UPDATE $sql_table SET status = ? WHERE $id_col = ?");
    $stmt->bind_param("si", $new_status, $toggle_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("Status updated to $new_status in $table."));
    exit();
}
?>

<!DOCTYPE html> 
<html lang = "en">
<?php include 'header.inc'; ?>
<div class = "ManageContainer">
<body>
    
    <h2>Welcome to the HR Manager Dashboard, <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></h2> 
    <a href = "Logout.php">Logout</a>


    <form method = "GET" action= "">
    <input type = "text" name = "searchEOI" placeholder = "Search EOI Database" value = "<?= $searchEOI ?>">
    <button type = "submit" value = "Search">Search</button>
</form>
<hr class = "hrSpecial">
<h3> Applicants (EOI Table) </h3>
<table>
    <tr>
        <th> EOI ID </th>
        <th> First Name </th>
        <th> Last Name </th>
        <th> DOB </th>
        <th> Email </th>
        <th> Phone </th>
        <th> Job </th>
        <th> Cover Letter </th>
        <th> Resume </th>
        <th> Status </th>
        <th> Change </th>
        <th> Delete </th>
    </tr>
<?php
    $EOIquery = ($searchEOI) ?
    "SELECT EOI_id, first_name, last_name, dob, email, phone, job, cl_upload, res_upload, status 
    FROM Application
    WHERE EOI_id LIKE '%$searchEOI_safe%'
    OR first_name LIKE '%$searchEOI_safe%'
    OR last_name LIKE '%$searchEOI_safe%'
    OR email LIKE '%$searchEOI_safe%'
    OR phone LIKE '%$searchEOI_safe%'
    OR job LIKE '%$searchEOI_safe%'
    OR cl_upload LIKE '%$searchEOI_safe%'
    OR res_upload LIKE '%$searchEOI_safe%'
    OR status LIKE '%$searchEOI_safe%'"
    : "SELECT applicant_id, first_name, last_name, dob, email, phone, job, cl_upload, res_upload, status FROM Application";

$EOIresults = mysqli_query($conn, $EOIquery);
if (!$EOIresults) {
    die("Query failed: ".mysqli_error($conn));
}
    if(mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($EOIresults)) {
        echo "<tr>
                <td>" . $row['EOI_id'] . "</td>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['dob'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['phone'] . "</td>
                <td>" . $row['job'] . "</td>
                <td><a href='download.php?id=" .urlencode($row['EOI_id']) . "&type=cl'>Download</a></td>
                <td><a href='download.php?id=" .urlencode($row['EOI_id']) . "&type=res'>Download</a></td>
                <td>" . $row['status'] . "</td>
                <td><a href='?toggle=" . $row['EOI_id'] . "&table=Application' onclick=\"return confirm('Change status of applicant ID {$row['EOI_id']}?');\">Toggle</a></td>
                <td><a href='?delete=" . $row['EOI_id'] . "&table=Application' onclick=\"return confirm('Are you sure you want to delete applicant ID {$row['EOI_id']}?');\">Delete</a></td>
                </tr>"; 
    }
} else {
    echo "<tr><td colspan='12'> No results found.</td></tr>";
}
?>




mysqli_close($conn);
<?php include 'footer.inc'; ?>
</body>
</html>