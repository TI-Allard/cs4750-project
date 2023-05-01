<?php
//echo "help";
if(isset($_POST["submit"])) {
    $userN = $_POST["userN"];
    $pswd = $_POST["pswd"];
    $pswdRepeat = $_POST["pswdrepeat"];
    //echo "help1";
    require("../connect-db.php");
    require("functions.inc.php");
    //echo "help2";
    if(emptyInputSignup($userN, $pswd, $pswdRepeat) !== false) {
        header("location: ../signup.php?error=emptyinput");
        //echo var_dump(($userN),($pswd));
        exit();
    }
    //echo "help3";
    if(invalidUsername($userN) !== false) {
        header("location: ../signup.php?error=invalidUsername");
        exit();
    }
    //echo "help4";
    if(pswdMatch($pswd, $pswdRepeat) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }
    //echo "help5";
    if(usernameExists($userN) !== false) {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }

    if(pswdLength($pswd) !== false) {
        header("location: ../signup.php?error=passwordtooshort");
        exit();
    }
    //echo "help6";

    $hashed_pswd = crypt($pswd, "$1\$sOKLEE3t$");
    createUser($userN, $hashed_pswd);
    //createUser($userN, $pswd);
    //echo "help7";
}
else {
    header("location: ../signup.php");
}

?>