<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to ForumMania - CodingForums</title>
    <style>
    .carousel-inner img {
        height: 70vh;
    }

    #ques {
        min-height: 433px;
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php 
    include'partials/_dbconnect.php';
    include'partials/_header.php';
    ?>
    <?php
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE `category_id` = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $cat = $row['category_name'];
        $desc= $row['category_description'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace("<", "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<", "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $srno = $_POST['srno'];
        
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `thread_created`) VALUES ( '$th_title', '$th_desc', '$id', '$srno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your thread has been added! Please wait for community to respond
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                  </div>';
    }
        echo '<div class="container my-4">
        <div class="p-5 mb-4 bg-body-tertiary border rounded-3">
            <div class="jumbotron">
                <h1 class="display-4 mb-5">Welcome to '.$cat.' Forums</h1>
                <p class="lead" style="font-size:23px">'.$desc.'</p>
                <hr class="my-4">
                <p class="fw-light">
                    It is a peer to peer forum. No Spam/ Advertising/ Self promote in the forums is not allowed.Always
                    respect the views of other participants even if they don\'t agree with you. Be constructive. It\'s
                    okay to disagree with other forum participants, in fact we encourage debate, just keep the dialogue
                    positive. Always keep things civil.
                </p>
            </div>
        </div>';

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true"){
    echo '<div class="container">
          <h1 class="py-2">Start a Discussion</h1> 
          <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
            </div>
            <input type="hidden" name="srno" value="'.$_SESSION['srno'].'">
            <div class="mb-3">
            <label for="desc" class="form-label">Elaborate Your Concern</label>
            <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
          </form>
          </div>';
    }
    else{
        echo '<div class="container">
          <h1 class="py-2">Start a Discussion</h1> 
          <p class="lead">You are not logged in. Please log in to Start a Discussion. </p>
          </div>';
    }
    echo '<h1 class="my-5">Browse Questions</h1>
          <div class="list-group" id="ques">';

    $sql2 = "SELECT * FROM `threads` WHERE `thread_cat_id`= $id";
    $result2 = mysqli_query($conn, $sql2);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result2)){
        $noResult = false;
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_time = $row['thread_created'];
        $thread_user_id = $row['thread_user_id'];
        $sql3 = "SELECT `user_email` FROM `users` WHERE `srno.` = $thread_user_id";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        echo '<div class="media">
            <img src="partials/images/userdefault.avif" alt="..." class="mr-3 mb-5 rounded-circle" width="50px">
            <div class="media-body" style="display:inline-block">
              <h5 class="mt-0"><a href="threads.php?threadid='.$id.'" class="text-dark">'.$title.'</a></h5>
              '.$desc.'
              <p class="my-0 fw-bold ">Asked By:' . $row3['user_email'] . ' at '.$thread_time.' </p>
            </div>
        </div>';
        // echo '<a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
        //   <img src="partials/images/userdefault.avif" alt="..." width="32" height="32" class="rounded-circle flex-shrink-0">
        //   <div class="d-flex gap-2 w-100 justify-content-between">
        //     <div>
        //       <h6 class="mb-0"><a href="threads.php?threadid='.$id.'" class="text-dark">'.$title.'</a></h6>
        //               '.$desc.'
        //       <p class="mb-0 opacity-75">Asked By:' . $row3['user_email'] . ' at '.$thread_time.' </p>
        //     </div>
        //     <small class="opacity-50 text-nowrap">now</small>
        //   </div>
        // </a>';
    }
    if ($noResult) {
        // echo var_dump($noResult);
       echo '<div class="media p-4 border rounded-3">
                <p class="display-6 p-4"> No Questions to Show </p>
                <p class="p-4"> Be the first to ask the Question. </p>
            </div>';
    }
    ?>
    </div>
    </div>

    <?php include'partials/_footer.php'?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>