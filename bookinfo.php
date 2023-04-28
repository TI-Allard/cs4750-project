<?php
  require("connect-db.php");
  require("functions.php");
  $review_info_to_edit = null;

  if(isset($_POST['book_to_view'])){
    $thisbook = getBookByISBN($_POST['book_to_view']);
    $reviews = getReviewsForBook($_POST['book_to_view']); 
  }else { //removed if(isset($_POST['isbn']))
    $thisbook = getBookByISBN($_POST['isbn']);
    $reviews = getReviewsForBook($_POST['isbn']); 
  }
  session_start();

  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Update")){
      //$review_info_to_edit = getFriendByName($_POST['friend_to_update']);
      //var_dump($friend_info_to_update);

    //create review
    }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Post Review")){
      if(isset($_SESSION["userN"])) {
        createreview($_POST['isbn'], $_SESSION["userN"], $_POST['title'], $_POST['body']);
        $reviews = getReviewsForBook($_POST['isbn']);
      }
    
    //delete review - not working 
    }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Delete")){
      deleteReview($_POST['review_to_delete']);
      $reviews = getReviewsForBook($_POST['isbn']);
  
  }
  }
  //update review
	
  //updateReview($review_id, $title, $body)
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
            <td>
              <?php if($item['username'] == $_SESSION["userN"]): ?>
                <form action="bookinfo.php" method="post">
                  <input type="submit" class="btn btn-secondary" name="actionBtn" value="Edit"/>
                  <input type="hidden" name="review_to_edit" value="<?php echo $item['review_id']; ?>"/>
                  <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
                </form>
                <form action="bookinfo.php" method="post">
                  <input type="submit" class="btn btn-danger" name="actionBtn" value="Delete"/>
                  <input type="hidden" name="review_to_delete" value="<?php echo $item['review_id']; ?>"/>
                  <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
                </form>
              <?php else: ?>
                <?php echo $item['username']; ?>
              <?php endif; ?>
            </td>
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
     Content:
    <input type="text" class="form-control" name="body" required/>
        <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
      </div>
  <div class="row mb-3 mx-3">
    <input type="submit" class="btn btn-primary" name="actionBtn" value="Post Review" title="Post Review" />        
  </div>
  </form>    

  </body>
</html>
