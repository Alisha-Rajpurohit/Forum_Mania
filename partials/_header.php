<?php
  session_start();

echo '<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/Forums">ForumMania</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/Forums">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Top Categories
          </a>
          <ul class="dropdown-menu">
          <li>';

          $sql = "SELECT `category_name`, `category_id` FROM `categories` LIMIT 3";
          $result = mysqli_query($conn, $sql);
          
          $num = mysqli_num_rows($result);
        while($row = mysqli_fetch_assoc($result)){

        echo '<a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a>';
        }
      echo '</li>
            </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/Forums/contact.php">Contact</a>
            </li>
          </ul>';
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){  
      echo'<form class="d-flex mx-2" role="search">
            <input class="form-control me-2" data-bs-theme="light" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
            <p class="text-light mx-2"> Welcome_'.$_SESSION['user_email'].' </p>
            <a class="btn btn-outline-success mx-2" href="partials/_logout.php" role="button">Logout</a>
          </form>';
      }
      else{
      echo '<form class="d-flex mx-2" role="search" method="get" action="search.php">
            <input class="form-control me-2" data-bs-theme="light" name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-success" type="submit">Search</button>
          </form>
          <a class="btn btn-outline-success mx-2" href="partials/_loginModal" data-bs-toggle="modal" data-bs-target="#loginModal" role="button">Login</a>
          <a class="btn btn-outline-success mr-2" href="partials/_signupModal" data-bs-toggle="modal" data-bs-target="#signupModal" role="button">Signup</a>';
      }
    echo '</div>
      </div>
    </nav>';

  include 'partials/_loginModal.php';
  include 'partials/_signupModal.php';
  if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> Your account is now created and you can login
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
  // else{
  //   echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  //           <strong>Error!</strong>' .$showError. '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  //           </div>';
  // }

  if(isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success!</strong> You are succesfully logged in.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
  }
?>