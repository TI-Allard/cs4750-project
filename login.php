<?php
require("connect-db.php");
// $friends = selectAllFriends();
// $friend_info_to_update = null;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	// if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Update")){
	// 	$friend_info_to_update = getFriendByName($_POST['friend_to_update']);
	// 	//var_dump($friend_info_to_update);
	// }
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
}

?>

<!-- 1. create HTML5 doctype -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
    
  <title>Friendbook</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

       
</head>

<body>
<div class="container">
  <h1>Login</h1>

  <form name="mainForm" action="home.php" method="post">   
  <div class="row mb-3 mx-3">
    Username:
    <input type="text" class="form-control" name="username" required 
		value="<?php if ($friend_info_to_update!=null) echo $friend_info_to_update['name'];?>"/>
  </div>  
  <div class="row mb-3 mx-3">
    Password:
    <input type="text" class="form-control" name="major" required
        value="<?php if ($friend_info_to_update!=null) echo $friend_info_to_update['major'];?>"/>
  </div>
  <div class="row mb-3 mx-3">
    <input type="submit" class="btn btn-primary" name="actionBtn" value="Add friend" title="click to insert friend" />        
  </div>
  <div class="row mb-3 mx-3">
    <input type="submit" class="btn btn-dark" name="actionBtn" value="Confirm update" title="click to update friend" />
  </div>
  </form>    

<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Name</th>        
    <th>Major</th>        
    <th>Year</th>
    <th>Update?</th>
    <th>Delete?</th>
  </tr>
  </thead>
<?php foreach ($friends as $item): ?>
  <tr>
     <td><?php echo $item['name']; ?></td>
     <td><?php echo $item['major']; ?></td>        
     <td><?php echo $item['year']; ?></td>
     <td>
       <form action="simpleform.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="Update"/>
         <input type="hidden" name="friend_to_update" value="<?php echo $item['name']; ?>"/>
       </form>
     </td>
     <td>
       <form action="simpleform.php" method="post">
         <input type="submit" class="btn btn-danger" name="actionBtn" value="Delete"/>
         <input type="hidden" name="friend_to_delete" value="<?php echo $item['name']; ?>"/>
       </form>
     </td>               
  </tr>
<?php endforeach; ?>
</table>
</div>   
  
</div>    
</body>
</html>