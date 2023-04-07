<?php
  require("connect-db.php");
  require("functions.php");
//   $thisbook = getBookByISBN($_POST['book_to_view']);
//   $reviews = getReviewsForBook($_POST['book_to_view']);
  $contestlibevents = getContestEvents(); //selectAllLibEvents(); 
  $readinglibevents = getReadingEvents(); 
  $readings = null;//selectAllReadings(); 
  $contests = null;  //selectAllContests(); 
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
  <a class="navbar-brand" href="#">Our Library</a>
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
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
    </ul>
  </div>
</nav>
<br>
<!-- book table -->
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Library Events</th>
    <th>Competition</th>
    <th>Prize</th>
    <th>Date Opens</th>
    <th>Date Closes</th>
  </tr>
  </thead>
<?php foreach ($contestlibevents as $item): ?>
  <tr>
    <?php $contests = getContest($item['event_id']); ?>
  </tr> 
  <tr>
     <td><?php echo $item['content']; ?></td>
     <td><?php echo $contests['prize']; ?></td>
     <td><?php echo date("F jS, Y", strtotime($item['event_datetime'])); ?></td>
     <td><?php echo date("F jS, Y", strtotime($contests['date_closed'])); ?></td>
  </tr>
<?php endforeach; ?>
</table>
</div>  
<!-- end of book table -->



<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th>Reader</th>
    <th>Date and Time</th>
  </tr>
  </thead>
<?php foreach ($readinglibevents as $item): ?>
  <tr>
    <?php $readings = getReading($item['event_id']); ?>
  </tr> 
  <tr>
     <td><?php echo $item['reader']; ?></td>
     <td><?php echo date("F jS, Y", strtotime($item['event_datetime'])); ?></td>
     <!-- <td>
       <form action="bookinfo.php" method="post">
         <input type="submit" class="btn btn-secondary" name="actionBtn" value="View"/>
         <input type="hidden" name="book_to_view" value="<?php echo $item['isbn']; ?>"/>
       </form>
     </td>             -->
  </tr>
<?php endforeach; ?>
</table>
</div>  
<!-- end of book table -->

  </body>
</html>
