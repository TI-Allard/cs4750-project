<!-- https://www.youtube.com/watch?v=gCo6JqGMi30 -->

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
  <!-- nav bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Our Library</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Browse Books</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="lib-event.php">Library Events</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li> -->
      <?php
        if(isset($_SESSION["userN"])) {
          echo "<li class='nav-item active'><a class='nav-link' href='profile.php'>Profile</a></li>";
          echo "<li class='nav-item active'><a class='nav-link' href='logout.php'>Log out</a></li>";
        }
        else {
          echo "<li class='nav-item active'><a class='nav-link' href='login.php'>Log In</a></li>";
          echo "<li class='nav-item active'><a class='nav-link' href='signup.php'>Sign Up</a></li>";
        }
      ?>
      
    </ul>
  </div>
</nav>
<br>

<section>
    <h1>Sign Up</h2>
    <form action="./includes/signup.inc.php" method="post">
    <div class="row mb-3 mx-3">
        <input type="text" name="userN" placeholder="Username...">
    </div>
    <div class="row mb-3 mx-3">
        <input type="password" name="pswd" placeholder="Password...">
    </div>
    <div class="row mb-3 mx-3">
        <input type="password" name="pswdrepeat" placeholder="Repeat Password...">
    </div>
    <div class="row mb-3 mx-3">
        <button type="submit" name="submit">Sign Up</button>
    </div>
    </form>
	<?php
	if(isset($_GET["error"])){
		if($_GET["error"] == "emptyinput") {
			echo "<p>Please ensure you fill in all fields.</p>";
		}
		else if($_GET["error"] == "invalidUsername"){
			echo "<p>Please only include letters and numbers in your username, no special characters permitted.</p>";
		}
		else if($_GET["error"] == "passwordsdontmatch"){
			echo "<p>Your passwords did not match. Ensure you enter the same password into both password fields.</p>";
		}
		else if($_GET["error"] == "usernametaken"){
			echo "<p>Username already taken. Choose a different username.</p>";
		}
		else if($_GET["error"] == "none") {
			echo "<p>You have successfully signed up.</p>";
		}
	}

?>   
</section>
   
  

</body>
</html>