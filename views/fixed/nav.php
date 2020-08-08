<?php @session_start(); ?>
<nav id='nav' class='navbar'>
    <div class="logo">
        <a class='logo-anchor' href='index.php' >
            <img class='logobasic' src='img/logo4.png'>
            
        </a>
    </div>
   
    <a href='products.php'>Products</a>
    <?php if (!isset($_SESSION['loggedin'])) { ?> 
        <a href='login.php'>Login</a> 
        <a href='register.php'>Register</a>
    <?php } ?>
    <a href='contact.php'>Contact</a>
    <a href='cart.php'><i class="fas fa-shopping-bag"></i> <?php echo isset($_SESSION['cart_quantity']) ? $_SESSION['cart_quantity'] : 0; ?></a>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
        <a href='admin.php'>Admin</a>
    <?php } ?>
    <?php if (isset($_SESSION['loggedin'])) { ?>
        <a href='logout.php'>Logout</a>
    <?php } ?>
</nav>