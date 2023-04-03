<?php
require("connect-db.php");
require("functions.php");
$books = selectAllBooks();
// $authenticated = null;
// if($_SERVER['REQUEST_METHOD'] == 'POST'){
// 	if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Login")){
// 		$authenticated = authenticateUser($_POST['username'], $_POST['password']);
// 		var_dump($$authenticated);
// 	}
	// else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Add friend")){
	// 	addFriend($_POST['name'], $_POST['major'], $_POST['year']);
	// 	$friends = selectAllFriends();
	// }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Delete")){
	// 	deleteFriend($_POST['friend_to_delete']);
	// 	$friends = selectAllFriends();
	// }
	// if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Confirm update")){
	// 	updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
	// 	$friends = selectAllFriends();
	// }
//}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  </p>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Login Page</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

       
</head>

<body>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Title</th>
  </tr>
  </thead>
<?php foreach ($books as $item): ?>
  <tr>
     <td><?php echo $item['title']; ?></td>
     <td>
       <form action="bookinfo.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="View"/>
         <input type="hidden" name="book_to_view" value="<?php echo $item['title']; ?>"/>
       </form>
     </td>            
  </tr>
<?php endforeach; ?>
</table>
</div>       
</body>
</html>