<?php
  require("connect-db.php");
  require("functions.php");
  if(isset($_POST['book_to_view'])){
    $thisbook = getBookByISBN($_POST['book_to_view']);
    $reviews = getReviewsForBook($_POST['book_to_view']); 
  }else { //removed if(isset($_POST['isbn']))
    $thisbook = getBookByISBN($_POST['isbn']);
    $reviews = getReviewsForBook($_POST['isbn']); 
  }
  session_start();

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
     if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Post Review")){
      if(isset($_SESSION["userN"])) {
        createreview($_POST['isbn'], $_SESSION["userN"], $_POST['title'], $_POST['body']);
        $reviews = getReviewsForBook($_POST['isbn']);
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
    <h1> <?php echo $thisbook['title'];?> </h1>
    <p>
      Title: <?php echo $thisbook['title']?>
      <br>
      Author: <?php echo $thisbook['author']?>.
      <br>
      Published Date: <?php echo $thisbook['date_published']?>
      <br>
      ISBN: <?php echo $thisbook['isbn']?>
      <br>
      Copies Available: <?php echo $thisbook['total_copies'] - $thisbook['copies_checked_out']?>
      <br>
    </p>
    <div class="row justify-content-center">  
      <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
        <thead>
          <tr style="background-color:#B0B0B0">
            <th>Author</th>
            <th>Title</th>
            <th>Review Content</th>
          </tr>
        </thead>
        <?php foreach ($reviews as $item): ?>
          <tr>
            <td><?php echo $item['username']; ?></td>
            <td><?php echo $item['title']; ?></td>  
            <td><?php echo $item['body']; ?></td>           
          </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <!-- create review form -->
    <form name="mainForm" action="bookinfo.php" method="post">   
  <div class="row mb-3 mx-3">
    Title:
    <input type="text" class="form-control" name="title" required />
  </div>  
  <div class="row mb-3 mx-3">
     Conent:
    <input type="text" class="form-control" name="body" required/>
        <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
      </div>
  <div class="row mb-3 mx-3">
    <input type="submit" class="btn btn-primary" name="actionBtn" value="Post Review" title="Post Review" />        
  </div>
  </form>    

  </body>
</html>
