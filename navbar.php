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
          echo "<li class='nav-item active'><a class='nav-link' href='userslist.php'>Users</a></li>";
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