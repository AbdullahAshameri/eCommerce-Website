#Class $noNavbar
- Tf no $noNavbar well Incloud Navbare On All PAges Expect The One With $noNavbar Virable
- if(!isset($noNavbar)) { include $tpl . 'navbar.php'; }

    ** Home Redirect Function [ This Function Accept Paramaters ]
    ** $errorMsg = Echo The Error Message
    ** $seconds = Seconds Before Redirecting

    
    -$check = checkItem('userid', 'users', $userid);
    ** this function asck thos  checkItem($select, $from, $value)
    ** We Use It rather than =>$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");


/**
 * Count Number Of Items Function
 *
 * Counts how many rows contain a value in the specified column of a given table.
 *
 * @param string $item   The column name to count.
 * @param string $table  The table name to select from.
 *
 * @return int           Number of rows found.
 *
 * @example
 *   $count = countItems('id', 'users');
 *   echo $count; // Output: number of user rows
 */
function countItems($item, $table) {
    global $con;

    $stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();

    return $stmt2->fetchColumn();
}
