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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//peronsal infomation 
        $firstname = $_POST['F_name'];
        $lastname = $_POST['L_name'];
        $DOB = $_POST['DOB'];
        $email = $_POST['Email'];
        $phone = $_POST['Phone_NUM'];
        $gender = $_POST['Gender'];
//days applicant is available and the time they can work
        $monday = isset($_POST['monday']) ?1:0;
        $mondaystart = to_null_if_empty($_POST['monday-start']);
        $mondayend = to_null_if_empty($_POST['monday-end']);
        $tuesday = isset($_POST['tuesday']) ?1:0;
        $tuesdaystart = to_null_if_empty($_POST['tuesday-start']);
        $tuesdayend = to_null_if_empty($_POST['tuesday-end']);
        $wednesday = isset($_POST['wednesday']) ?1:0;
        $wednesdaystart = to_null_if_empty($_POST['wednesday-start']);
        $wednesdayend = to_null_if_empty($_POST['wednesday-end']);
        $thursday = isset($_POST['thursday']) ?1:0;
        $thursdaystart = to_null_if_empty($_POST['thursday-start']);
        $thursdayend = to_null_if_empty($_POST['thursday-end']);
        $friday = isset($_POST['friday']) ?1:0;
        $fridaystart = to_null_if_empty($_POST['friday-start']);
        $fridayend = to_null_if_empty($_POST['friday-end']);
        $saturday = isset($_POST['saturday']) ?1:0;
        $saturdaystart = to_null_if_empty($_POST['saturday-start']);
        $saturdayend = to_null_if_empty($_POST['saturday-end']);
        $sunday = isset($_POST['sunday']) ?1:0;
        $sundaystart = to_null_if_empty($_POST['sunday-start']);
        $sundayend = to_null_if_empty($_POST['sunday-end']);
//home address for applicant
        $address = $_POST['Address'];
        $suburb = $_POST['Suburb'];
        $state = $_POST['State'];
        $postcode = $_POST['Post_Code'];
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
        $extraskills = $_POST['Extra_Skills'];
        $writeletter = $_POST['Write_Letter'];
        
//file upload for both the coverletter and the resume
        if (!isset($_FILES['Cover_Letter']) || $_FILES['Cover_Letter']['error'] !==0)
        {
            die("Error uploading your coverletter!");
        }

         if (!isset($_FILES['Resume']) || $_FILES['Resume']['error'] !==0)
        {
            die("Error uploading your Resume!");
        }


        $coverletter = file_get_contents($_FILES['Cover_Letter']['tmp_name']);
        $resume = file_get_contents($_FILES['Resume']['tmp_name']);




    }