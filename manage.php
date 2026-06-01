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
$USERtable = 'Users';
$USERid_col = 'User_ID';
$searchEOI = isset($_GET['searchEOI']) ? $_GET['searchEOI'] : '';
$searchEOI_safe = $conn->real_escape_string($searchEOI);
$searchJOB = isset($_GET['searchJOB']) ? $_GET['searchJOB'] : '';
$searchJOB_safe = $conn->real_escape_string($searchJOB);
$searchUSER = isset($_GET['searchUSER']) ? $_GET['searchUSER'] : '';
$searchUSER_safe = $conn->real_escape_string($searchUSER);

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
    $stmt = $conn->prepare("DELETE FROM $JOBtable WHERE $JOBid_col = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("ID $delete_id deleted successfully from $JOBtable."));
    exit();
}

if (isset($_GET['USERdelete']) && is_numeric($_GET['USERdelete'])) {
    $delete_id = intval($_GET['USERdelete']);
    $stmt = $conn->prepare("DELETE FROM $USERtable WHERE $USERid_col = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("ID $delete_id deleted successfully from $USERtable."));
    exit();
}

if (isset($_GET['EOItoggle']) && is_numeric($_GET['EOItoggle'])){
    $toggle_id = intval($_GET['EOItoggle']);
    $stmt = $conn->prepare("SELECT Status FROM $EOItable WHERE $EOIid_col = ?");
    $stmt->bind_param("i", $toggle_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();

    $new_status = ($current_status === 'Accepted') ? 'Rejected' : 'Accepted';
    $stmt = $conn->prepare("UPDATE $EOItable SET Status = ? WHERE $EOIid_col = ?");
    $stmt->bind_param("si", $new_status, $toggle_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("EOI ID $toggle_id Status updated to $new_status in $EOItable."));
    exit();
}

if (isset($_GET['ROLEtoggle']) && is_numeric($_GET['ROLEtoggle'])){

    $usertoggle_id = intval($_GET['ROLEtoggle']);

    $stmt = $conn->prepare("SELECT Role FROM $USERtable WHERE $USERid_col = ?");
    $stmt->bind_param("i", $usertoggle_id);
    $stmt->execute();
    $stmt->bind_result($current_role);
    $stmt->fetch();
    $stmt->close();

    $new_role = ($current_role === 'HR') ? 'BLANK' : 'HR';
    $stmt = $conn->prepare("UPDATE $USERtable SET Role = ? WHERE $USERid_col = ?");
    $stmt->bind_param("si", $new_role, $usertoggle_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("User ID $usertoggle_id Role updated to $new_role in $USERtable."));
    exit();

}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"];
    $target_user = trim(strtolower($_POST["target_user"]));

    if ($action === "change_password") {
        $new_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE Users SET Password = ? WHERE Username = ?");
        $stmt->bind_param("ss", $new_password, $target_user);
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?message=" . urlencode("Password updated for $target_user."));
            exit();
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=" . urlencode("Failed to update password."));
            exit();
        }
    }

}
?>

<!DOCTYPE html> 
<html lang = "en">
<?php include 'header.inc'; ?>
<body>
<div class = "TextContainer">

    
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
    "SELECT EOI_id, F_Name, L_Name, Email, Phone_Num, Job, Cover_Letter, Resume, Status 
    FROM EOI
    WHERE EOI_id LIKE '%$searchEOI_safe%'
    OR F_Name LIKE '%$searchEOI_safe%'
    OR L_Name LIKE '%$searchEOI_safe%'
    OR Email LIKE '%$searchEOI_safe%'
    OR Phone_Num LIKE '%$searchEOI_safe%'
    OR Job LIKE '%$searchEOI_safe%'
    OR Cover_Letter LIKE '%$searchEOI_safe%'
    OR Resume LIKE '%$searchEOI_safe%'
    OR Status LIKE '%$searchEOI_safe%'"
    : "SELECT EOI_id, F_Name, L_Name, Email, Phone_Num, Job, Cover_Letter, Resume, Status FROM EOI"; //show all results when search is empty

$EOIresults = mysqli_query($conn, $EOIquery);
if (!$EOIresults) {
    die("Query failed: ".mysqli_error($conn));
}
    if(mysqli_num_rows($EOIresults) > 0) {
    while ($row = mysqli_fetch_assoc($EOIresults)) {
        echo "<tr>
                <td>" . $row['EOI_id'] . "</td>
                <td>" . $row['F_Name'] . "</td>
                <td>" . $row['L_Name'] . "</td>
                <td>" . $row['Email'] . "</td>
                <td>" . $row['Phone_Num'] . "</td>
                <td>" . $row['Job'] . "</td>
                <td><a href='download.php?id=" .urlencode($row['EOI_id']) . "&type=cl'>Download</a></td>
                <td><a href='download.php?id=" .urlencode($row['EOI_id']) . "&type=res'>Download</a></td>
                <td>" . $row['Status'] . "</td>
                <td><a href='?EOItoggle=" . $row['EOI_id'] . "' onclick=\"return confirm('Change status of applicant ID {$row['EOI_id']}?');\">Toggle</a></td>
                <td><a href='?EOIdelete=" . $row['EOI_id'] . "' onclick=\"return confirm('Are you sure you want to delete applicant ID {$row['EOI_id']}?');\">Delete</a></td>
                </tr>"; 
    }
} else {
    echo "<tr><td colspan='12'> No results found.</td></tr>";
}
?>
</table>


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
        <th> Delete </th>
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
?>
</table>

    <form method = "GET" action= "">
    <input type = "text" name = "searchUSER" placeholder = "Search USER Database" value = "<?= htmlspecialchars($searchUSER) ?>">   <!--htmlspecialchars uses as a security feature-->
    <button type = "submit" value = "Search">Search</button>
</form>
<hr class = "hrSpecial">
<h3> Users (User Table) </h3>
<table>
    <tr>
        <th> User ID </th>
        <th> Username </th>
        <th> First Name </th>
        <th> Last Name </th>
        <th> Role </th>
        <th> Change </th>
        <th> Delete </th>
    </tr>

<?php
    $USERquery = ($searchUSER) ?
    "SELECT User_ID, Username, F_Name, L_Name, Role 
    FROM Users
    Where User_ID LIKE '%$searchUSER_safe%'
    OR Username LIKE '%$searchUSER_safe%'
    OR F_Name LIKE '%$searchUSER_safe%'
    OR L_Name LIKE '%$searchUSER_safe%'
    OR Role LIKE '%$searchUSER_safe%'"
    : "SELECT User_ID, Username, F_Name, L_Name, Role FROM Users"; //show all results when search is empty


$USERresults = mysqli_query($conn, $USERquery);
if (!$USERresults) {
    die("Query failed: ".mysqli_error($conn));
}
    if(mysqli_num_rows($USERresults) > 0) {
    while ($row = mysqli_fetch_assoc($USERresults)) {
        echo "<tr>
                <td>" . $row['User_ID'] . "</td>
                <td>" . $row['Username'] . "</td>
                <td>" . $row['F_Name'] . "</td>
                <td>" . $row['L_Name'] . "</td>
                <td>" . $row['Role'] . "</td>
                <td><a href='?ROLEtoggle=" . $row['User_ID'] . "' onclick=\"return confirm('Are you sure you want to change the rol of User ID {$row['User_ID']}?');\">Change Role</a></td>
                <td><a href='?USERdelete=" . $row['User_ID'] . "' onclick=\"return confirm('Are you sure you want to delete User ID {$row['User_ID']}?');\">Delete</a></td>
                </tr>"; 
    }
} else {
    echo "<tr><td colspan='12'> No results found.</td></tr>";
}
mysqli_close($conn);
?>
</table>

</div>
<?php include 'footer.inc'; ?>
</body>
</html>