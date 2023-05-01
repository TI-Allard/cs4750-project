<?php

if(isset($_POST["submit"])) {
    $userN = $_POST["userN"];
    $pswd = $_POST["pswd"];

    require("../connect-db.php");
    require("functions.inc.php");

    if(emptyInputLogin($userN, $pswd) != false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    
    $hashed_pswd = crypt($pswd, "$1\$sOKLEE3t$");
    var_dump($hashed_pswd);
    //loginUser($userN, $hashed_pswd);
    loginUser($userN, $pswd);
}
else {
    header("location: ../login.php");
    exit();
}

?>