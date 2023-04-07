<?php
//echo "help";
if(isset($_POST["submit"])) {
    $uname = $_POST["username"];
    $pswd = $_POST["pswd"];
    $pswdRepeat = $_POST["pswdrepeat"];
    //echo "help1";
    require("../connect-db.php");
    require("functions.inc.php");
    //echo "help2";
    if(emptyInputSignup($uname, $pswd, $pswdRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    //echo "help3";
    if(invalidUsername($uname) !== false) {
        header("location: ../signup.php?error=invalidUsername");
        exit();
    }
    //echo "help4";
    if(pswdMatch($pswd, $pswdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    //echo "help5";
    if(usernameExists($uname) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    //echo "help6";

    createUser($uname, $pswd);
    //echo "help7";
}
else {
    header("location: ../signup.php");
}

?>