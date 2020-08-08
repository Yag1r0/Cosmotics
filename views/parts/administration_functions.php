<?php

$db_handle = new DBController();

$errors = [];
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";

if (isset($_REQUEST['insertUser'])) {
    // Validate username
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
    if (empty($username)) {
        $errors[] = "Please enter a username.";
    } else {
        $user = $db_handle->runQuery("SELECT * FROM users WHERE username = '{$username}';");
        if (!empty($user)) {
            $errors[] = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    }
    
    // Validate password
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;
    if (empty($password)) {
        $errors[] = "Please enter a password.";     
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must have atleast 6 characters.";
    }
    
    // Check input errors before inserting in database
    if(empty($errors)) {
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $res = $db_handle->insert("INSERT INTO users (username, password, role) VALUES ('{$username}', '{$param_password}', 'admin');");
        if (empty($res)) {
            echo "Something went wrong. Please try again later.";
        } else {
            header('Location: admin.php');
        }
    }
} elseif (isset($_GET['deleteUser'])) {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $res = mysqli_query($link, "DELETE FROM users WHERE id = {$id};");
        if (empty($res)) {
            echo "Something went wrong. Please try again later.";
        } else {
            header('Location: admin.php');
        }
    }
}

if (isset($_REQUEST['insertProduct'])) {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : null;
    if (empty($name)) {
        $errors[] = "Please enter a name.";
    }

    $code = isset($_POST["code"]) ? trim($_POST["code"]) : null;
    if (empty($code)) {
        $errors[] = "Please enter a code.";
    }

    $price = isset($_POST["price"]) ? floatval($_POST["price"]) : null;
    if (empty($price)) {
        $errors[] = "Please enter a price.";
    }

    if (empty($_FILES['image']['tmp_name'])) {
        $errors[] = "Please enter a image.";
    }

    if (empty($errors)) {
        $file_name = 'img/products/mascara/' . time() . '_' . $_FILES['image']['name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../' . $file_name)) {
            $res = $db_handle->insert("INSERT INTO tblproduct (name, code, image, price) VALUES ("
                . "'{$name}', '{$code}', '{$file_name}', $price);");
            if (empty($res)) {
                echo "Something went wrong. Please try again later.";
            } else {
                header('Location: admin.php');
            }
        }
    }

} elseif (isset($_GET['deleteProduct'])) {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $res = mysqli_query($link, "DELETE FROM tblproduct WHERE id = {$id};");
        if (empty($res)) {
            echo "Something went wrong. Please try again later.";
        } else {
            header('Location: admin.php');
        }
    }
}

?>
