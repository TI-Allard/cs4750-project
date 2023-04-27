<?php
require("connect-db.php");
require("functions.php");
session_start();
// $friends = selectAllFriends();
// $authenticated = null;
// $loggedin = false;
// $loginAttempted = false;
// $featuredbooks = selectFeaturedBooks();
// if($_SERVER['REQUEST_METHOD'] == 'POST'){
// 	if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Login")){
// 		$authenticated = authenticateUser($_POST['username'], $_POST['pswd']);
//     $loginAttempted = true;
// 		//var_dump($friend_info_to_update);
// 	}
// 	// else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Add friend")){
// 	// 	addFriend($_POST['name'], $_POST['major'], $_POST['year']);
// 	// 	$friends = selectAllFriends();
// 	// }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Delete")){
// 	// 	deleteFriend($_POST['friend_to_delete']);
// 	// 	$friends = selectAllFriends();
// 	// }
// 	// if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Confirm update")){
// 	// 	updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
// 	// 	$friends = selectAllFriends();
// 	// }
// }

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Login Page</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

       
</head>

<body>
    <!-- don't put anything in this space -- leave the require("navbar.php") as the only thing in php code
      if you want to change the navbar, you can do so in header.php -->
      <?php require("navbar.php") ?>
<br>
  <!-- <h1>Welcome to Our Library!</h1>

  <p><?php if ($authenticated == "1") { //used to be != null
    echo "Hi ";
    echo $_POST['username'];
    echo ", welcome to our library!";
    //echo $authenticated;
    }
    else if($loginAttempted){
        echo "I'm sorry, ";
        echo $_POST['username'];
        echo " the username or password you entered was incorrect.";
    } 
    //var_dump($authenticated);
    ?>
  <?php if($authenticated == "1"): ?>
    <?php setUNAME($_POST['username']) ?>
  <?php else: ?>
    <form name="mainForm" action="login.php" method="post">   
    <div class="row mb-3 mx-3">
      Username:
      <input type="text" class="form-control" name="username" required />
    </div>  
    <div class="row mb-3 mx-3">
      Password:
      <input type="text" class="form-control" name="pswd" required />
    </div>
    <div class="row mb-3 mx-3">
      <input type="submit" class="btn btn-primary" name="actionBtn" value="Login" title="click to log in" />        
    </div>
    </form>    
  <?php endif; ?> -->
   
  <section>
    <h1>Log In</h2>
    <form action="./includes/login.inc.php" method="post">
    <div class="row mb-3 mx-3">
        <input type="text" name="userN" placeholder="Username...">
    </div>
    <div class="row mb-3 mx-3">
        <input type="password" name="pswd" placeholder="Password...">
    </div>
    <div class="row mb-3 mx-3">
        <button type="submit" name="submit">Log In</button>
    </div>
    </form>
    <?php
	if(isset($_GET["error"])){
		if($_GET["error"] == "emptyinput") {
			echo "<p>Please ensure you fill in all fields.</p>";
		}
		else if($_GET["error"] == "wronglogin"){
			echo "<p>Incorrect login information.</p>";
		}
	}

?>  
</section>
     
</body>
</html>