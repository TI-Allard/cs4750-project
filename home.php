<?php
  require("connect-db.php");
  require("functions.php");
  session_start();
  $admin_logged_in = [FALSE];
  if(isset($_POST['addBookBtn'])){
    $genre = NULL;
    $date_published = NULL;
    $book_cover = NULL;
    $copies_checked_out = 0;
    $average_rating = NULL;
    if(isset($_POST['genre'])){
      $genre = isset($_POST['genre']);
    }
    if(isset($_POST['date_published'])){
      $date_published = $_POST['date_published'];
    }
    if(emptyInputBook($_POST['isbn'], $_POST['title'], $_POST['author'], $_POST['total_copies'])) {
      header("location: ../project/home.php?error=emptyInput");
      exit();
    }elseif(invalidDate($date_published)){
      header("location: ../project/home.php?error=invalidDate");
      exit();
    }else{
      addBook($_POST['isbn'], $_POST['title'], $_POST['author'], $genre, $date_published, $book_cover, $_POST['total_copies'], $copies_checked_out, $average_rating);
    }
  }elseif(isset($_POST['isbn'])){
    deleteBook($_POST['isbn']);
  }
  $books = selectAllBooks();
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

<?php 
if(isset($_GET["error"])){
  if($_GET["error"] == "emptyInput") {
    echo "<p>Please ensure you fill in all required fields.</p>";
  }
  else if($_GET["error"] == "invalidDate"){
    echo "<p>Book not added. Please ensure you enter the date published in the specified.</p>";
  }
}
?>

<!-- add book form -->
<?php if($admin_logged_in[0] == TRUE): ?>
  <form name="mainForm" action="home.php" method="post"> 
    <p2>Starred (*) items are required.</p2>  
    <div class="row mb-3 mx-3">
      ISBN:*
      <input type="text" class="form-control" name="isbn" required />
    </div>  
    <div class="row mb-3 mx-3">
      Title:*
      <input type="text" class="form-control" name="title" required />
    </div>  
    <div class="row mb-3 mx-3">
      Author:*
      <input type="text" class="form-control" name="author" required />
    </div>  
    <div class="row mb-3 mx-3">
      Genre:
      <input type="text" class="form-control" name="genre" />
    </div>  
    <div class="row mb-3 mx-3">
      Date Published [m(m)/d(d)/yyyy]:
      <input type="text" class="form-control" name="date_published" />
    </div>  
    <div class="row mb-3 mx-3">
      Total Copies:*
      <input type="text" class="form-control" name="total_copies" required />
    </div>
      <input type="submit" class="btn btn-primary" name="addBookBtn" value="Add Book" title="Add Book" />    
    </div>
  </form>
<?php endif; ?>
<!-- end add book form -->

<!-- book table -->
<div class="row justify-content-center">  
<form action="search.php" method="post" >
    <div class="center mb-3 mx-3">
      <input type="text" placeholder="Search here" name="search_term" />
    
    <input type="submit" value="Search" name="submit"/>
    </div>
</form>


<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Title</th>
    <th>Book Information</th>
    <?php if($admin_logged_in[0] == TRUE): ?>
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
     <?php if($admin_logged_in[0] == TRUE): ?>
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