<?php

@session_start();

require_once "config.php";
require_once "dbcontroller.php";

include "views/parts/administration_functions.php"; 
include "views/fixed/head.php";
include "views/fixed/nav.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
  header("location: index.php");
  exit;
}
?>

<span>
    <?php
        foreach ($errors as $error) {
            echo $error . "<br/>";
        }
    ?>
</span>
<br/>

<?php
include "views/parts/user_administration.php"; 
include "views/parts/product_administration.php"; 
include "views/fixed/footer.php"; 

?>
