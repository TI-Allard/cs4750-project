<?php
  require("connect-db.php");
  require("functions.php");
  $books = selectAllBooks();
  session_start();
  if(isset($_POST['isbn'])){
    deleteBook($_POST['isbn']);
  }
  if(isset($_SESSION["userN"])){
    $admin_logged_in = getRole($_SESSION["userN"]);
  }
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
    
  <title>Library</title>
   
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

       
</head>

<body>
    <!-- don't put anything in this space -- leave the require("navbar.php") as the only thing in php code
      if you want to change the navbar, you can do so in header.php -->
      <?php require("navbar.php") ?>
<br>
<!-- book table -->
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Title</th>
    <th>Book Information</th>
    <?php if($admin_logged_in == TRUE): ?>
      <th>Remove Book?</th>
    <?php endif; ?>
  </tr>
  </thead>
<?php foreach ($books as $item): ?>
  <tr>
     <td><?php echo $item['title']; ?></td>
     <td>
       <form action="bookinfo.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="View"/>
         <input type="hidden" name="book_to_view" value="<?php echo $item['isbn']; ?>"/>
       </form>
     </td>     
     <?php if($admin_logged_in == TRUE): ?>
      <td>
        <form action="home.php" method="post">
          <input type="submit" class="btn btn-danger" name="actionBtn" value="Delete"/>
          <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
        </form>
      </td>
    <?php endif; ?>
  </tr>
<?php endforeach; ?>
</table>
</div>  
<!-- end of book table -->

</body>
</html>