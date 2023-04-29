<?php
  require("connect-db.php");
  require("functions.php");
  session_start();

  if(isset($_POST['user_to_view'])){
    $booksread = getBooksRead($_POST['user_to_view']);
    $admin = getRole($_POST['user_to_view']); 
    $current_user = $_POST['user_to_view'];
    $friends = getFriends($_POST['user_to_view']);
  }elseif(isset($_SESSION["userN"])){ 
    $booksread = getBooksRead($_SESSION["userN"]);
    $admin = getRole($_SESSION["userN"]);
    $current_user = $_SESSION["userN"];
    $friends = getFriends($_SESSION["userN"]);
    $reserves = getReservedBooks($_POST['userN']); 
  }

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Check Out")){
     if(isset($_SESSION["userN"])) {
       $booktocheckout = getBookByISBN($_POST['isbn']);
       $availability = $booktocheckout['total_copies'] - $booktocheckout['copies_checked_out'];
       if ($booktocheckout['copies_checked_out'] < $booktocheckout['total_copies']){
          checkoutBook($_POST['isbn']); 
          
       }
      else{
          echo "That book is not available! Sorry!"; 
      }
       
     }
   }
 }



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="your name">
    <meta name="description" content="include some description about your page">  
    <title>Book Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  </head>
  <body>
    <!-- don't put anything in this space -- leave the require("navbar.php") as the only thing in php code
      if you want to change the navbar, you can do so in header.php -->
    <?php require("navbar.php") ?>
<br>
<?php
        if((isset($_POST['user_to_view'])) OR (isset($_SESSION["userN"]))) {
          echo "<h2>     Profile of " . $current_user . ".</h2>";
          if($admin[0] == TRUE) {
            echo "<p>     Role: Admin</p>";
          }
        }
      ?>

<!-- book table -->
<h4>Books Read</h4>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Title</th>
    <th>View</th>
  </tr>
  </thead>
<?php foreach ($booksread as $item): ?>
  <tr>
     <td><?php echo $item['title']; ?></td>
     <td>
       <form action="bookinfo.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="View"/>
         <input type="hidden" name="book_to_view" value="<?php echo $item['isbn']; ?>"/>
       </form>
     </td>            
  </tr>
<?php endforeach; ?>
</table>
</div>  
<!-- end of book table -->

<!-- friend table -->
<?php 
$is_friend = FALSE;
if($current_user == $_SESSION["userN"]){
  $is_friend = TRUE;
}else{
  foreach ($friends as $item){
    if($item['username1'] == $_SESSION["userN"] OR $item['username2'] == $_SESSION["userN"]){
      $is_friend = TRUE;
    }
  }
}
?>

<?php if($is_friend == TRUE): ?>
  <h4>Friends</h4>
  <div class="row justify-content-center">  
  <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
    <thead>
    <tr style="background-color:#B0B0B0">
      <th>User</th>
      <th>Profile Information</th>
    </tr>
    </thead>
  <?php foreach ($friends as $item): ?>
    <tr>
      <td><?php if($current_user != $item['username1']){
        $friend = $item['username1']; 
      }
      elseif($current_user == $item['username1']){
        $friend = $item['username2']; 
      }
      echo $friend;
      ?></td>
      <td>
        <form action="profile.php" method="post">
          <input type="submit" class="btn btn-secondary" name="actionBtn" value="View"/>
          <input type="hidden" name="user_to_view" value="<?php echo $friend; ?>"/>
        </form>
      </td>            
    </tr>
  <?php endforeach; ?>
<?php endif; ?>
</table>
</div>  
<!-- end of friend table -->


<!-- start of reserved books table -->
<h4>Reserved Books</h4>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Title</th>
    <th>Author</th>
  </tr>
  </thead>
<?php foreach ($reserves as $item): ?>
  <tr>
     <td><?php echo $item['title']; ?></td>
     <td><?php echo $item['author']; ?></td>
     <td>
       <form action="bookinfo.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="View"/>
         <input type="hidden" name="book_to_view" value="<?php echo $item['isbn']; ?>"/>
       </form>
       <form action="profile.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="Return"/>
         <input type="hidden" name="returnedBook" value="<?php echo $item['isbn']; ?>"/>
       </form>
     </td>            
  </tr>
<?php endforeach; ?>
</table>
</div>  

  </body>
</html>
