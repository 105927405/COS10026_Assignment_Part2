<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'settings.php';

        // Connect to MySQL
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }
function to_null_if_empty($value)
{
    return trim($value)===''?null:$value;
}

//Pull data from form via $_POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstname = $_POST['F_name'];
    $lastname = $_POST['L_name'];
    $DOB = $_POST['DOB'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone_NUM'];
    $gender = $_POST['Gender'];

    $address = $_POST['Address'];
    $suburb = $_POST['Suburb'];
    $state = $_POST['State'];
    $postcode = $_POST['Post_Code'];

    $communacation = isset($_POST['communacation']) ?1:0;
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
    $resume = $_POST['Resume']