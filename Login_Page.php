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
$error = ''; //variable used for error messages
$message = ''; //variable used for success messages, like for making an account
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}

//check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $raw_username = $_POST['username'];
    $raw_password = $_POST['password'];
    $fixed_username = strtolower(trim($raw_username)); //convert username to a all lowercase format for consistancy

    //connect to mysql database
    $conn = new mysqli($host, $user, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Prepare and execute query
    $stmt = $conn->prepare("SELECT F_Name, L_Name, Password, Role FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $fixed_username);
    $stmt->execute();
    $stmt->store_result();

    //If user found in daaatabase
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($firstname, $lastname, $hashed_password, $role);
        $stmt->fetch();

        if (password_verify($raw_password, $hashed_password)) { //comparing the stored hashed password with the entered raw password in the text box
            $_SESSION["isloggedon"] = true;
            $_SESSION["username"] = $fixed_username;
            $_SESSION["firstname"] = $firstname;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["role"] = $role;
            

            //redirect based on user role
            switch ($role) {
                case 'IT':
                    header("Location: IT_Admin.php");
                    exit();
                case 'HR':
                    header("Location: manage.php");
                    exit();
                case 'BLANK':
                    header('Location: index.php');
                    exit();
                default:
                    header("Location: index.php");
                    exit();
            }
        } else {
            $error  = 'Incorrect Password.';
            
        }
    } else {
        $error  = 'Incorrect Username.';
        
    }

    $stmt->close();
    $conn->close();
    
}
?>
<!DOCTYPE html>
<html lang = "en">
        
    <?php include 'header.inc'; ?>

    <h2>Login</h2>
    <?php if ($message): ?>
        <div style = "color: green;"><?php echo $message; ?></div> <!inline css to make messages green>
    <?php endif; ?>
    <?php if ($error): ?>
        <div style = "color: red;"><?php echo $error; ?></div> <!inline css to make error messages red>
    <?php endif; ?>
    <form method = "post" action = ""> <!post empty as php is managed within the code>
        <label for = "username">Username:</label>
        <input type = "text" name = "username" id = "username" required>

        <label for = "password">Password:</label>
        <input type = "password" name = "password" id = "password" required>

        <button type="submit" name="submit">Login</button>
    </form>
     <a href = "Create_User.php">Create An Account?</a>


 <?php include 'footer.inc'; ?>
</body>
</html>
