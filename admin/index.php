<?php
    include 'init.php';
    include $tpl . 'header.php';
    include 'includes/languages/englesh.php';

    // Check if the Request Coming From POST Request
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // Check If The User Is Exist In Database
        $stmt = $con->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
        $stmt->execute(array($username, $hashedPass));
        $count = $stmt->rowCount();
        
        if($count > 0) {
            echo "Wellcom " . $username;
        }
    }

?>

    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h4 class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
        <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
        <input class="btn btn-primary btn-block" type="submit" value="Login" />
    </form>
    
    <?php ?>

<?php include $tpl . 'footer.php'; ?>

<!-- 12 -->
