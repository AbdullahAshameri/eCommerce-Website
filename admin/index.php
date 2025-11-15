<?php
    session_start();
    $noNavbar = '';
    if(isset($_SESSION['Username'])){
        header('Location: dashboard.php'); // Redirect to Dashboard Page
    }
    include 'init.php';

    // Check if the Request Coming From POST Request
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $username = $_POST['user'];
        $password = $_POST['pass'];
        $hashedPass = sha1($password);

        // Check If The User Is Exist In Database
        $stmt = $con->prepare("SELECT Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1");
        $stmt->execute(array($username, $hashedPass));
        $count = $stmt->rowCount();
        
        // If Count > 0 This Meane The Database Contain Record About This Username
        if($count > 0) {
            $_SESSION['Username'] = $username; // Request Session Name
            header('location: dashboard.php'); // Redirect to Dashboard Page
            exit();
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
