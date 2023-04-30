<?php
  require("connect-db.php");
  require("functions.php");
  $review_info_to_edit = null;
  $copies_incremented = null; 

  if(isset($_POST['book_to_view'])){
    $thisbook = getBookByISBN($_POST['book_to_view']);
    $reviews = getReviewsForBook($_POST['book_to_view']); 
    //ratings!
    $aor = getAverageOverallRating($_POST['book_to_view']);
    $apr = getAveragePlotRating($_POST['book_to_view']);
    $acr = getAverageCharactersRating($_POST['book_to_view']);
    $awsr = getAverageWritingStyleRating($_POST['book_to_view']);
  }else { 
    $thisbook = getBookByISBN($_POST['isbn']);
    $reviews = getReviewsForBook($_POST['isbn']); 
    //ratings
    $aor = getAverageOverallRating($_POST['isbn']);
    $apr = getAveragePlotRating($_POST['isbn']);
    $acr = getAverageCharactersRating($_POST['isbn']);
    $awsr = getAverageWritingStyleRating($_POST['isbn']);
  }

  $availability = getAvailabilityStatus($thisbook['copies_checked_out'], $thisbook['total_copies']);
  session_start();
  $admin_logged_in = [FALSE];

  
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //get update info
    if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Edit")){
      $review_info_to_edit = getReviewByID($_POST['review_to_edit']);

    //create review
    }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Post Review")){
      if(isset($_SESSION["userN"])) {
        createreview($_POST['isbn'], $_SESSION["userN"], $_POST['title'], $_POST['body']);
        $reviews = getReviewsForBook($_POST['isbn']);
      }
    
    //delete review 
    }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Delete")){
      deleteReview($_POST['review_to_delete']);
      $reviews = getReviewsForBook($_POST['isbn']);
  
    //create rating
    }else if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Rate Book")){
      if(isset($_SESSION["userN"])) {
        addBookRating($_POST['isbn'], $_SESSION["userN"], $_POST['overall_stars'], $_POST['plot'], $_POST['characters'], $_POST['writing_style']);
        $aor = getAverageOverallRating($_POST['isbn']);
        $apr = getAveragePlotRating($_POST['isbn']);
        $acr = getAverageCharactersRating($_POST['isbn']);
        $awsr = getAverageWritingStyleRating($_POST['isbn']);
      }
  
    }

    //confirm update
    if((!empty($_POST['actionBtn'])) && ($_POST['actionBtn'] == "Confirm Edit")){
      updateReview($_POST['reviewID'], $_POST['title'], $_POST['body']);
      $reviews = getReviewsForBook($_POST['isbn']);
    }

  }
  if(isset($_SESSION["userN"])){
    $admin_logged_in = getRole($_SESSION["userN"]);
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
      Copies Available: <?php echo $thisbook['total_copies'] - $thisbook['copies_checked_out']?>, <?php echo $availability[0][0]?>
      <br>
      <?php if($aor[0][0]): ?>
      Average Overall Rating: <?php echo $aor[0][0]?>
      <br>
      Average Plot Rating: <?php echo $apr[0][0]?>
      <br/>
      Average Characters Rating: <?php echo $acr[0][0]?>
      <br>
      Average Writing-Style Rating: <?php echo $awsr[0][0]?>
      <br>
      <?php endif; ?> 
    </p>
    <div> 
      <!-- this is going to be testing if else functionality  -->
      <?php $copies_available = $thisbook['total_copies'] - $thisbook['copies_checked_out']?> 
      <?php if( $thisbook['copies_checked_out'] < $thisbook['total_copies'] ): ?>
          <p> Nothing </p>
          <?php $copies_incremented = $thisbook['copies_checked_out'] + 1 ?>
          <?php echo $copies_incremented ?> 
      <?php else: ?>
          
          <p> Random Thing </p>
      <?php endif; ?>
    </div>
    <?php ?>
    <?php if ($thisbook['total_copies'] - $thisbook['copies_checked_out'] != 0): ?>
      <div>
          <form name="checkout" action= "profile.php" method="post">
            <div class="row mb-3 mx-3">
              <input type="submit" class="btn btn-primary" name="actionBtn" value="Check Out" title="Check Out" />
              <input type="hidden" name="book_to_checkout" value="<?php echo $thisbook['isbn']; ?>"/>
              <input type="hidden" name="user_checking_out" value="<?php echo $_SESSION["userN"]; ?>"/>        
            </div>
          </form>
      </div>
    <?php endif; ?>
    <div>
        <form name="haveRead" action= "profile.php" method="post">
          <div class="row mb-3 mx-3">
            <input type="submit" class="btn btn-primary" name="actionBtn" value="Have Read" title="Have Read" />
            <input type="hidden" name="book_to_have_read" value="<?php echo $thisbook['isbn']; ?>"/>
            <input type="hidden" name="user_of_have_read" value="<?php echo $_SESSION["userN"]; ?>"/>        
          </div>
        </form>
    </div>
    <div class="row justify-content-center">  
      <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
        <thead>
          <tr style="background-color:#B0B0B0">
            <th>Author</th>
            <th>Title</th>
            <th>Review Content</th>
            <?php if($admin_logged_in[0] == TRUE): ?>
              <th>Inappropriate Review?</th>
            <?php endif; ?>
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
            <?php if($admin_logged_in[0] == TRUE): ?>
              <td>
                <form action="bookinfo.php" method="post">
                  <input type="submit" class="btn btn-danger" name="actionBtn" value="Delete"/>
                  <input type="hidden" name="review_to_delete" value="<?php echo $item['review_id']; ?>"/>
                  <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
                </form>
              </td>
            <?php endif; ?>         
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    
  <?php if(isset($_SESSION["userN"]) && getUserBookRating($thisbook['isbn'], $_SESSION["userN"])): ?>
      <p> You rated this book:</p>
      <?php echo getUserBookRating($thisbook['isbn'], $_SESSION["userN"])[3]?> Overall,
      <?php echo getUserBookRating($thisbook['isbn'], $_SESSION["userN"])[4]?> Plot,
      <?php echo getUserBookRating($thisbook['isbn'], $_SESSION["userN"])[5]?> Characters, 
      <?php echo getUserBookRating($thisbook['isbn'], $_SESSION["userN"])[6]?> Writing-Style 
  <?php else: ?>
    <?php if(isset($_SESSION["userN"])): ?>
      <!-- create rating form, getUserBookRating($isbn, $username) -->
    <h3> Rate This Book </h3>
    <p> Rate the book on the following critera on a scale 1-5 with 5 being most positive. </p>
    <form name="mainForm" action="bookinfo.php" method="post">   
    <div class="row mb-3 mx-3">
      Overall Rating:
      <input type="number" name="overall_stars" min="1" max="5" required>
    </div>
    <div class="row mb-3 mx-3">
      Plot Rating:
      <input type="number" name="plot" min="1" max="5" required>
    </div>  
    <div class="row mb-3 mx-3">
      Characters Rating:
      <input type="number" name="characters" min="1" max="5" required>
    </div>
    <div class="row mb-3 mx-3">
      Writing Style Rating:
      <input type="number" name="writing_style" min="1" max="5" required>
    </div> 
    <div class="row mb-3 mx-3">
      <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>   
      <input type="submit" class="btn btn-primary" name="actionBtn" value="Rate Book" title="Rate Book" />       
    </div>
  </form>   
    <?php endif; ?> 
  <?php endif; ?>  

  <?php if(isset($_SESSION["userN"])): ?>
    <!-- create review form -->
    <h3> Review This Book </h3>
    <form name="mainForm" action="bookinfo.php" method="post">   
  <div class="row mb-3 mx-3">
    Title:
    <input type="text" class="form-control" name="title" required 
    value="<?php if ($review_info_to_edit!=null) echo $review_info_to_edit['title'];?>"/>
  </div>  
  <div class="row mb-3 mx-3">
     Content:
    <input type="text" class="form-control" name="body" required
    value="<?php if ($review_info_to_edit!=null) echo $review_info_to_edit['body'];?>"/>
        <input type="hidden" name="isbn" value="<?php echo $thisbook['isbn']; ?>"/>
      </div>
  <div class="row mb-3 mx-3">
    <input type="submit" class="btn btn-primary" name="actionBtn" value="Post Review" title="Post Review" />
    <br>
    <input type="hidden" name="reviewID" value="<?php echo $_POST['review_to_edit']; ?>"/> 
    <input type="submit" class="btn btn-primary" name="actionBtn" value="Confirm Edit" title="Confirm Edit" />        
  </div>
  </form>
  <?php endif; ?>    

  </body>
</html>
