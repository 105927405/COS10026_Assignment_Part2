<?php
    //////////////////////////////////////////////////////////
    //                                                      //
    //            Create User System                        //
    //            Author: Blake Stone                       //
    //            Date Of Creation: 29/5/2026               //
    //            File Size: 3,745 Bytes                    //
    //                                                      //
    //////////////////////////////////////////////////////////

    require_once 'settings.php';

      //connect to mysql database
        $conn = new mysqli($host, $user, $password, $database);
        if ($conn->connect_error) {
            die("Database connection failed: " . $conn->connect_error);
        }

    $error = '';
    if (isset($_GET['error'])) {
        $error = urldecode($_GET['error']);
    }

    //pull data from form via local $_POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $raw_username = $_POST['username'];
        $raw_Fname = $_POST['firstname'];
        $raw_Lname = $_POST['lastname'];
        $raw_password = $_POST['password'];
        $user_role = 'BLANK'; // default status


        //debug (dump all data currently entered in $_POST) (deactivated with comment)
        //var_dump($_POST);

        //make full name all lowercase for consistency and to prvent multiple of the same username with different capitalisation
        $fixed_username = strtolower($raw_username);

         $check_user = $conn->prepare("SELECT COUNT(*) FROM Users WHERE Username = ?");
        $check_user->bind_param("s", $fixed_username);
        $check_user->execute();
        $check_user->bind_result($count);
        $check_user->fetch();
        $check_user->close();

        if ($count > 0) {
    header("Location: Create_User.php?error=" . urlencode("Username already exists. Please choose another."));
    exit();
    }

        
        //hash password for security
        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);
        
        
      

        $stmt = $conn->prepare("INSERT INTO Users (Username, Password, F_Name, L_Name, Role) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        //bind parameters
        $stmt->bind_param("sssss", $fixed_username, $hashed_password, $raw_Fname, $raw_Lname, $user_role);

        //rxecute and check success
        if ($stmt->execute()) {
            //redirect on success
            header('Location: Login_Page.php?message=' . urlencode('Account created successfully.'));
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
      
        
    }

?>
<!DOCTYPE html>
<html lang = "en">
    <?php include 'header.inc'; ?>

    <h2>Create User</h2>
    <?php if ($error): ?>
        <div style = "color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method = "post" action = "">
        <label for = "username">Username:</label>
        <input type = "text" name = "username" id = "username" required>

        <label for = "firstname">First Name:</label>
        <input type = "text" name = "firstname" id = "firstname" required>

        <label for = "lastname">Last Name:</label>
        <input type = "text" name = "lastname" id = "lastname" required>

        <label for = "password">Password:</label>
        <input type = "password" name = "password" id = "password" required>

        <button type="submit" name="submit">Create User</button>
    </form>

 <?php include 'footer.inc'; ?>
</body>
</html>