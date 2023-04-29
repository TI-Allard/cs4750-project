<?php
  require("connect-db.php");
  require("functions.php");
//   $thisbook = getBookByISBN($_POST['book_to_view']);
//   $reviews = getReviewsForBook($_POST['book_to_view']);
//ANOTHER TEST 
  $contestlibevents = getContestEvents(); //selectAllLibEvents(); 
  $readinglibevents = getReadingEvents(); 
  $readings = null;//selectAllReadings(); 
  $contests = null;  //selectAllContests(); 
  session_start(); 
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
<h3> Contests </h3>
<!-- book table -->
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
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

<h3> Reading Events </h3>

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
     <td><?php echo date("F jS, Y g:i", strtotime($item['event_datetime'])); ?></td>
  </tr>
<?php endforeach; ?>
</table>
</div>  
<!-- end of book table -->

  </body>
</html>
