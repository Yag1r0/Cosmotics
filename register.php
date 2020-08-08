<?php

include "views/fixed/head.php";
include "views/fixed/nav.php";
 
@session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

require_once("dbcontroller.php");
$db_handle = new DBController();
 
// definisanje varijabli i postavljanje vrednosti na prazan string
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// precesuiranje podataka kada je forma submitovana
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // provera username
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
    if (empty($username)) {
        $username_err = "Please enter a username.";
    } else {
        $user = $db_handle->runQuery("SELECT * FROM users WHERE username = '{$username}';");
		if (!empty($user)) {
            $username_err = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    }
    
    // provera passworda
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;
    if (empty($password)) {
        $password_err = "Please enter a password.";     
    } elseif (strlen($password) < 6) {
        $password_err = "Password must have atleast 6 characters.";
    }
    
    // provera confirm passworda
    $confirm_password = isset($_POST["confirm_password"]) ? trim($_POST["confirm_password"]) : null;
    if (empty($confirm_password)) {
        $confirm_password_err = "Please confirm password.";    
    } elseif (empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Password did not match.";
    }
    
    // proveravamo da li su greske prazne, ako je su upisujemo u bazu novog korisnika
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $res = $db_handle->insert("INSERT INTO users (username, password, role) VALUES ('{$username}', '{$param_password}', 'user');");
        if (empty($res)) {
            echo "Something went wrong. Please try again later.";
        } else {
            header('Location: index.php');
        }
    }
    
    $db_handle->closeDB();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/login.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2 class='loginTxt'>Sign Up</h2>
        <p class='loginP'>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label><br>
                <input type="text" name="username" class="form-control ubac" value="<?php echo $username; ?>">
                <br><span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label><br>
                <input type="password" name="password" class="form-control ubac" value="<?php echo $password; ?>">
                <br><span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label class='cLabel'>Confirm Password</label><br>
                <input type="password" name="confirm_password" class="form-control ubac" value="<?php echo $confirm_password; ?>">
                <br><span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="buttonRegister" value="Submit">
                <input type="reset" class="buttonReset" value="Reset">
            </div>
            <p class='loginP'>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div> 
    <?php include "views/fixed/footer.php"; ?>     
</body>
</html>