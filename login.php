<?php

include "views/fixed/head.php";
include "views/fixed/nav.php";

// pokretanje sesije
@session_start();

// proveravamo da li je user vec logovan, ako jeste prebacujemo ga na index.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit;
}

require_once("config.php");
require_once("dbcontroller.php");
$db_handle = new DBController();

// definisanje varijabli i njihova inicijalizacija na ""
$username = $password = "";
$username_err = $password_err = "";
 
// pokretanje forme, nakon klika
if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // proveravamo da li je username empty, ako jeste upisujemo null, ako nije upisujemo vrednost, u slucaju da je prazan u greske
    //dodajemo poruku dam ora da unese username
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
    if (empty($username)) {
        $username_err = "Please enter username.";
    }
    
    // proveravamo da li je pasworrd prazan, ako jeste upisujemo null, ako nije upisujemo vrednost, u slucaju da prazan u greske
    //dodajemo poruku da mora da unese parssword
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;
    if (empty($password)) {
        $password_err = "Please enter your password.";     
    }
    
    // provera krecencijala, ako nema nijedne greske
    if (empty($username_err) && empty($password_err)) {
        // pripremamo sql select upit
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        //vraca false ako se desila neka greska, ovim pripremamo query za izvrsavanje
        if($stmt = mysqli_prepare($link, $sql)){
            // Vezivanje varijabli kao parametre, 's' predstavlja string
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            //Sada setujemo parametre 
            $param_username = $username;
            
            // Pokusaj izvrsavanje pripremljenog statement-a
            if(mysqli_stmt_execute($stmt)){
                // skladistenje rezultate
                mysqli_stmt_store_result($stmt);
                
                // ako username postoji, proveravamo password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // i bindujemo ovo sto nam je vratio query na nase parametre
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            //ako je sifra korektna, onda pokrecemo novu sesiju
                            @session_start();
                            
                            // Skladistimo podatke u sesiju
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;
                            
                            // Redirektujemo na index.php
                            header("location: index.php");
                        } else{
                            // Ovde setujemo error u slucaju da paswword nije bio dobar
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    //Ovde prikazujemo gresku da username ne postoji
                    $username_err = "No account found with that username.";
                }//Defaultna greska
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // zatvaramo statement
            mysqli_stmt_close($stmt);
        }
    }
    //zatvaramo konekciju ka bazi
    mysqli_close($link);
}

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    
    
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="wrapper">
        <h2 class='loginTxt'>Login</h2>
        <p class='loginP'>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label><br>
                <input type="text" name="username" class="form-control ubac" value="<?php echo $username; ?>">
                <br><span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label><br>
                <input type="password" name="password" class="form-control ubac">
                <br><span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="buttonLogin" value="Login">
            </div>
            
        </form>
    </div>
    <?php include "views/fixed/footer.php"; ?>  
</body>
</html>