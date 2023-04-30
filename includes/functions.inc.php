<?php
require("../connect-db.php");
function emptyInputSignup($userN, $pswd, $pswdRepeat) {
    //$result
    //echo var_dump(($userN),($pswd));
    if (empty($userN) || empty($pswd) || empty($pswdRepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUsername($userN) {
    //$result
    if (!preg_match("/^[a-zA-Z0-9]*$/", $userN)){
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

function pswdLength($pswd) {
    //$result
    if(strlen($pswd) < 8) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function usernameExists($userN) {
    //$result
    global $db;
    $query = "SELECT * FROM Profile WHERE username = :username;";
	$statement = $db->prepare($query);
    $statement->bindValue(':username', $userN);
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

function createUser($userN, $pswd) {
    //$result
    global $db;
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    date_default_timezone_set('America/New_York');
    $date = date('Y-m-d h:i:s', time()); 
    $query = "insert INTO Profile (username, pswd, date_of_membership, admin) VALUES (:username, :pswd, :dte, :admin)";
	$statement = $db->prepare($query);
    //echo "help8";
    //echo $userN;
    //echo $pswd;
    //$hashedPswd = password_hash($pswd, PASSWORD_DEFAULT);
    //echo "help9";
    $statement->bindValue(':username', $userN);
    $statement->bindValue(':pswd', $pswd);
    $statement->bindValue(':dte', $date);
    $statement->bindValue(':admin', 0);
    $statement->execute();
    $statement->closeCursor();
    //echo "help10";
    header("location: ../signup.php?error=none");
    echo "in createUser";
    exit();
}


function emptyInputLogin($userN, $pswd) {
    //$result
    //echo var_dump(($userN),($pswd));
    if (empty($userN) || empty($pswd)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($userN, $pswd) {
    $userExists = usernameExists($userN);
    if($userExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $existingPswd = $userExists["pswd"];
    
    if($existingPswd !== $pswd){
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($existingPswd === $pswd) {
        session_start();
        $_SESSION["userN"] = $userExists["username"];
        header("location: ../home.php");
        exit();
    }
}

?>