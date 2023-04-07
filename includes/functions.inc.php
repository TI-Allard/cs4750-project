<?php
require("../connect-db.php");
function emptyInputSignup($uname, $pswd, $pswdRepeat) {
    //$result
    if (empty($uname) || empty($pswd) || empty($pswdRepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUsername($uname) {
    //$result
    if (!preg_match("/^[a-zA-Z0-9]*$/", $uname)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pswdMatch($pswd, $pswdRepeat) {
    //$result
    if($pswd !== $pswdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function usernameExists($uname) {
    //$result
    global $db;
    $query = "SELECT * FROM Profile WHERE username = :username;";
	$statement = $db->prepare($query);
    $statement->bindValue(':username', $uname);
    $statement->execute();
    if ($results = $statement->fetch()) {
        $statement->closeCursor();
        return $results;
    }
    else {
        $result = false;
        $statement->closeCursor();
        return $result;
    }
}

function createUser($uname, $pswd) {
    //$result
    date_default_timezone_set('America/New_York');
    $date = date('Y-m-d h:i:s', time()); 
    global $db;
    $query = "INSERT INTO Profile (username, pswd, date_of_membership) VALUES (:username, :pswd, :dte)";
	$statement = $db->prepare($query);
    echo "help8";
    echo $uname;
    echo $pswd;
    //$hashedPswd = password_hash($pswd, PASSWORD_DEFAULT);
    echo "help9";
    $statement->bindValue(':username', $uname);
    $statement->bindValue(':pswd', $pswd);
    $statement->bindValue(':dte', $date);
    $statement->execute();
    $statement->closeCursor();
    echo "help10";
    header("location: ../signup.php?error=none");
    exit();
}

?>