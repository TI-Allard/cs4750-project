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
    loginUser($userN, $pswd);
}
else {
    header("location: ../login.php");
    exit();
}

?>