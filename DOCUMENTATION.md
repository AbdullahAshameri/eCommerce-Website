#Class $noNavbar
- Tf no $noNavbar well Incloud Navbare On All PAges Expect The One With $noNavbar Virable
- if(!isset($noNavbar)) { include $tpl . 'navbar.php'; }

    ** Home Redirect Function [ This Function Accept Paramaters ]
    ** $errorMsg = Echo The Error Message
    ** $seconds = Seconds Before Redirecting


    -$check = checkItem('userid', 'users', $userid);
    ** this function asck thos  checkItem($select, $from, $value)
    ** We Use It rather than =>$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
