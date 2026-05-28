<?php
    //////////////////////////////////////////////////////////
    //                                                      //
    //            Login System                              //
    //            Author: Blake Stone                       //
    //            Date Of Creation: 28/5/2026               //
    //            File Size:  Bytes                         //
    //                                                      //
    //////////////////////////////////////////////////////////

session_start();
$_SESSION["isloggedon"] = false;

require_once 'settings.php';
$error = '';
$message = '';
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}

