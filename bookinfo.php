<?php
  require("connect-db.php");
  require("functions.php");
  $thisbook = getBookByTitle($_POST['book_to_view']);
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
    <h1> <?php echo $_POST['book_to_view'];?> </h1>
    <p>
      This book is called <?php echo $thisbook['title']?> by <?php echo $thisbook['author']?>.
      <br>
      Published Date: <?php echo $thisbook['date_published']?>
    </p>

  </body>
</html>
