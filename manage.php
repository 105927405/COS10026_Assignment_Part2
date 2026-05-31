<?php
    //////////////////////////////////////////////////////////
    //                                                      //
    //            Admin Manage System                       //
    //            Author: Blake Stone                       //
    //            Date Of Creation: 29/5/2026               //
    //            File Size: 8,009 Bytes                    //
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
    

$EOItable = 'EOI';
$EOIid_col = 'EOI_id';
$JOBtable = 'Jobs';
$JOBid_col = 'REF_NUM';
$searchEOI = isset($_GET['searchEOI']) ? $_GET['searchEOI'] : '';
$searchEOI_safe = $conn->real_escape_string($searchEOI);

if (isset($_GET['EOIdelete']) && is_numeric($_GET['EOIdelete'])) {
    $delete_id = intval($_GET['EOIdelete']);
    $stmt = $conn->prepare("DELETE FROM $EOItable WHERE $EOIid_col = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("ID $delete_id deleted successfully from $EOItable."));
    exit();
}

if (isset($_GET['JOBdelete']) && is_numeric($_GET['JOBdelete'])) {
    $delete_id = intval($_GET['JOBdelete']);
    $stmt = $conn->prepare("DELETE FROM $EOItable WHERE $EOIid_col = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("ID $delete_id deleted successfully from $JOBtable."));
    exit();
}

if (isset($_GET['EOItoggle']) && is_numeric($_GET['EOItoggle'])){
    $toggle_id = intval($_GET['EOItoggle']);
    $stmt = $conn->prepare("SELECT status FROM $EOItable WHERE $EOIid_col = ?");
    $stmt->bind_param("i", $toggle_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();

    $new_status = ($current_status === 'Accepted') ? 'Rejected' : 'Accepted';
    $stmt = $conn->prepare("UPDATE $EOItable SET status = ? WHERE $EOIid_col = ?");
    $stmt->bind_param("si", $new_status, $toggle_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("Status updated to $new_status in $EOItable."));
    exit();
}
?>

<!DOCTYPE html> 
<html lang = "en">
<?php include 'header.inc'; ?>
<body>
<div class = "ManageContainer">

    
    <h2>Welcome to the HR Manager Dashboard, <?= $_SESSION['firstname'] ?> <?= $_SESSION['lastname'] ?></h2> 
    <a href = "Logout.php">Logout</a>

 <?php
if (isset($_GET['message'])) {
    echo '<div style="color: green; font-weight: bold;">' . $_GET['message'] . '</div>';
}
?>


    <form method = "GET" action= "">
    <input type = "text" name = "searchEOI" placeholder = "Search EOI Database" value = "<?= htmlspecialchars($searchEOI) ?>">   <!--htmlspecialchars uses as a security feature-->
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
    FROM EOI
    WHERE EOI_id LIKE '%$searchEOI_safe%'
    OR first_name LIKE '%$searchEOI_safe%'
    OR last_name LIKE '%$searchEOI_safe%'
    OR email LIKE '%$searchEOI_safe%'
    OR phone LIKE '%$searchEOI_safe%'
    OR job LIKE '%$searchEOI_safe%'
    OR cl_upload LIKE '%$searchEOI_safe%'
    OR res_upload LIKE '%$searchEOI_safe%'
    OR status LIKE '%$searchEOI_safe%'"
    : "SELECT EOI_id, first_name, last_name, dob, email, phone, job, cl_upload, res_upload, status FROM EOI"; //show all results when search is empty

$EOIresults = mysqli_query($conn, $EOIquery);
if (!$EOIresults) {
    die("Query failed: ".mysqli_error($conn));
}
    if(mysqli_num_rows($EOIresults) > 0) {
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
                <td><a href='?EOItoggle=" . $row['EOI_id'] . "' onclick=\"return confirm('Change status of applicant ID {$row['EOI_id']}?');\">Toggle</a></td>
                <td><a href='?EOIdelete=" . $row['EOI_id'] . "' onclick=\"return confirm('Are you sure you want to delete applicant ID {$row['EOI_id']}?');\">Delete</a></td>
                </tr>"; 
    }
} else {
    echo "<tr><td colspan='12'> No results found.</td></tr>";
}
?>


    <form method = "GET" action= "">
    <input type = "text" name = "searchJOB" placeholder = "Search JOBs Database" value = "<?= htmlspecialchars($searchJOB) ?>">   <!--htmlspecialchars uses as a security feature-->
    <button type = "submit" value = "Search">Search</button>
</form>
<hr class = "hrSpecial">
<h3> Jobs (Jobs Table) </h3>
<table>
    <tr>
        <th> Job REF </th>
        <th> Job Name </th>
        <th> Pay </th>
        <th> DOB </th>
        <th> E-Skills </th>
        <th> P-Skills </th>
        <th> Description</th>
    </tr>
<?php
    $JOBquery = ($searchJOB) ?
    "SELECT REF_NUM, Job_Name, Pay, E_Skills, P_Skills, Description 
    FROM Jobs
    WHERE REF_NUM LIKE '%$searchJOB_safe%'
    OR Job_Name LIKE '%$searchJOB_safe%'
    OR Pay LIKE '%$searchJOB_safe%'
    OR E_Skills LIKE '%$searchJOB_safe%'
    OR P_Skills LIKE '%$searchJOB_safe%'
    OR Description LIKE '%$searchJOB_safe%'"
    : "SELECT REF_NUM, Job_Name, Pay, E_Skills, P_Skills, Description FROM Jobs"; //show all results when search is empty


$JOBresults = mysqli_query($conn, $JOBquery);
if (!$JOBresults) {
    die("Query failed: ".mysqli_error($conn));
}
    if(mysqli_num_rows($JOBresults) > 0) {
    while ($row = mysqli_fetch_assoc($JOBresults)) {
        echo "<tr>
                <td>" . $row['REF_NUM'] . "</td>
                <td>" . $row['Job_Name'] . "</td>
                <td>" . $row['Pay'] . "</td>
                <td>" . $row['E_Skills'] . "</td>
                <td>" . $row['P_Skills'] . "</td>
                <td>" . $row['Description'] . "</td>
                <td><a href='?JOBdelete=" . $row['REF_NUM'] . "' onclick=\"return confirm('Are you sure you want to delete Job ID {$row['REF_NUM']}?');\">Delete</a></td>
                </tr>"; 
    }
} else {
    echo "<tr><td colspan='12'> No results found.</td></tr>";
}
mysqli_close($conn);
?>

</div>
<?php include 'footer.inc'; ?>
</body>
</html>