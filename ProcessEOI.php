<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'settings.php';

// Connect to MySQL
        $conn = new mysqli($host, $user, $password, $database);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
function to_null_if_empty($value)
{
    return trim($value)===''?null:$value;
}

//Pull data from form via $_POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            header('Location: EOI.php');
            exit();
        }
//peronsal infomation 
        $F_name = $_POST['F_name'];
        $L_name = $_POST['L_name'];
        $DOB = $_POST['DOB'];
        $Email = $_POST['Email'];
        $Phone_NUM = $_POST['Phone_NUM'];
        $Gender = $_POST['Gender'];

        $errors = [];

// first name valadation
        if (!preg_match('/^[A-Za-z]+$/', $F_name))
            {
                $errors[] = "First Name must only contain letters";
            }
// last name valadation
         if (!preg_match('/^[A-Za-z]+$/', $L_name))
            {
                $errors[] = "Last Name must only contain letters";
            }
// phone number valadation
         if (!preg_match('/^[0-9]{10}$/', $Phone_NUM))
            {
                $errors[] = "Phone number must only have 10 numbers";
            }
//DOB validation 
$birthDate = new DateTime($DOB);
$today = new DateTime();
$age = $today->diff($birthDate)->y;
if ($age < 18)
    {
        $errors[] = "Applicants must be 18 or older to apply";
    }
    
//job selection
        $Job = $_POST['Job'];
//days applicant is available and the time they can work
        $monday = isset($_POST['monday']) ?1:0;
        $montimein = to_null_if_empty($_POST['montimein']);
        $montimeout = to_null_if_empty($_POST['montimeout']);
        $tuesday = isset($_POST['tuesday']) ?1:0;
        $tuetimein = to_null_if_empty($_POST['tuetimein']);
        $tuetimeout = to_null_if_empty($_POST['tuetimeout']);
        $wednesday = isset($_POST['wednesday']) ?1:0;
        $wedtimein = to_null_if_empty($_POST['wedtimein']);
        $wedtimeout = to_null_if_empty($_POST['wedtimeout']);
        $thursday = isset($_POST['thursday']) ?1:0;
        $thurtimein = to_null_if_empty($_POST['thurtimein']);
        $thurtimeout = to_null_if_empty($_POST['thurtimeout']);
        $friday = isset($_POST['friday']) ?1:0;
        $fritimein = to_null_if_empty($_POST['fritimein']);
        $fritimeout = to_null_if_empty($_POST['fritimeout']);
        $saturday = isset($_POST['saturday']) ?1:0;
        $sattimein = to_null_if_empty($_POST['sattimein']);
        $sattimeout = to_null_if_empty($_POST['sattimeout']);
        $sunday = isset($_POST['sunday']) ?1:0;
        $suntimein = to_null_if_empty($_POST['suntimein']);
        $suntimeout = to_null_if_empty($_POST['suntimeout']);
//home address for applicant
        $Address = $_POST['Address'];
        $Suburb = $_POST['Suburb'];
        $State = $_POST['State'];
        $Post_Code = $_POST['Post_Code'];
//phone number valadation
         if (!preg_match('/^[0-9]{4}$/', $Post_Code))
            {
                $errors[] = "Post Code must only have 4 numbers";
            }
//preselected skills the applicants can pick from
        $communication = isset($_POST['communication']) ?1:0;
        $teamwork = isset($_POST['teamwork']) ?1:0;
        $time = isset($_POST['time']) ?1:0;
        $cs = isset($_POST['cs']) ?1:0;
        $BPS = isset($_POST['BTS']) ?1:0;
        $APS = isset($_POST['APS']) ?1:0;
        $BDS = isset($_POST['BDS']) ?1:0;
        $ADS = isset($_POST['ADS']) ?1:0;
        $BTS = isset($_POST['BTS']) ?1:0;
        $ATS = isset($_POST['ATS']) ?1:0;
        $JS = isset($_POST['Js']) ?1:0;
        $Extra_Skills = $_POST['Extra_Skills'];
        $Write_Letter = $_POST['Write_Letter'];


//Cover Letter validation (optional)
    if (
        isset($_FILES['Cover_Letter']) &&
        $_FILES['Cover_Letter']['error'] === UPLOAD_ERR_OK)
    {
        $coverExtension = strtolower(
            pathinfo($_FILES['Cover_Letter']['name'], PATHINFO_EXTENSION));

    if ($coverExtension !== 'pdf')
        {
            $errors[] = "Cover Letter must be a PDF file.";
        }
    }

//Resume validation (required)
    if (
        isset($_FILES['Resume']) &&
        $_FILES['Resume']['error'] === UPLOAD_ERR_OK)
    {
        $resumeExtension = strtolower(
            pathinfo($_FILES['Resume']['name'], PATHINFO_EXTENSION));

        if ($resumeExtension !== 'pdf')
            {
                $errors[] = "Resume must be a PDF file.";
            }
    }

if (!empty($errors))
{
    header('Location: EOI.php?error=' . urlencode(implode(', ', $errors)));
    exit();
}


if (!empty($errors))
{
    header('Location: EOI.php?error=' . urlencode(implode(', ', $errors)));
    exit();
}

/* 
        if (!empty($errors))
            {
                foreach ($errors as $error)
                    {
                        echo "<p>$error</p>";
                    }
                    exit();
            }
*/

//file upload for both the coverletter and the resume
        $coverletter = null;

    if (
        isset($_FILES['Cover_Letter']) &&
        $_FILES['Cover_Letter']['error'] === 0)
            {
                $coverletter = file_get_contents($_FILES['Cover_Letter']['tmp_name']);
            }

         if (!isset($_FILES['Resume']) || $_FILES['Resume']['error'] !==0)
        {
            die("Error uploading your Resume!");
        }


        $Cover_Letter = file_get_contents($_FILES['Cover_Letter']['tmp_name']);
        $Resume = file_get_contents($_FILES['Resume']['tmp_name']);

        $stmt = $conn->prepare("INSERT INTO EOI (F_name, L_name, DOB, Email, Phone_NUM, Gender,
        Job, monday, montimein, montimeout, tuesday, tuetimein, 
        tuetimeout, wednesday, wedtimein, wedtimeout, thursday, 
        thurtimein, thurtimeout, friday, fritimein, fritimeout, 
        saturday, sattimein, sattimeout, sunday, suntimein, suntimeout,
        Address, Suburb, State, Post_Code, communication, teamwork, time,
        cs, BPS, APS, BDS, ADS, BTS, ATS, JS, Extra_Skills, Cover_Letter,
        Write_Letter, Resume)
        VALUES
        (
        ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );        

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

//bind parameters
        $stmt->bind_param("sssssssissississississississssssiiiiiiiiiiissss",
        $F_name, $L_name, $DOB, $Email, $Phone_NUM, $Gender, $Job, 
        $monday, $montimein, $montimeout, $tuesday, $tuetimein, $tuetimeout, 
        $wednesday, $wedtimein, $wedtimeout, $thursday, $thurtimein, $thurtimeout, 
        $friday, $fritimein, $fritimeout, $saturday, $sattimein, $sattimeout, 
        $sunday, $suntimein, $suntimeout, $Address, $Suburb, $State, $Post_Code, 
        $communication, $teamwork, $time, $cs, $BPS, $APS, $BDS, $ADS, $BTS, $ATS, $JS, 
        $Extra_Skills, $Cover_Letter, $Write_Letter, $Resume
        );

// Execute and check success
        if ($stmt->execute()) {
            header('Location: EOI.php?message=' . urlencode('Applcation Submitted Seccessfully.'));
            exit();
        } 
        else {
            echo "Error: " . $stmt->error;
            header('Location: EOI.php?error=' . urlencode('An Error Occured.'));
            exit();
        }

        $stmt->close();
        $conn->close();


    