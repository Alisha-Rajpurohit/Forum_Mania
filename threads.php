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
    #ques{
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
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE `thread_id` = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['thread_id'];
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $user = $row['thread_user_id'];
        $sql3 = "SELECT `user_email` FROM `users` WHERE `srno.` = $user";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
    }

    $showAlert = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment = $_POST['comment'];
        // Protecting our website from XSS attack 
        $comment = str_replace("<", "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $srno = $_POST['srno'];
        $sql = "INSERT INTO `comments`(`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment','$id','$srno',current_timestamp());";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> Your comment has been added!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                  </div>';
                }
        echo '<div class="container my-4">
        <div class="p-5 mb-4 bg-body-tertiary border rounded-3">
            <div class="jumbotron">
                <h1 class="display-5 mb-5">'.$title.'</h1>
                <p class="lead" style="font-size:23px">'.$desc.'</p>
                <hr class="my-4">
                <p class="fw-light">
                    It is a peer to peer forum. No Spam/ Advertising/ Self promote in the forums is not allowed.Always
                    respect the views of other participants even if they don\'t agree with you. Be constructive. It\'s
                    okay to disagree with other forum participants, in fact we encourage debate, just keep the dialogue
                    positive. Always keep things civil.
                </p>
                <p><b>Posted by: '. $row3['user_email'] .'</b></p>
            </div>
        </div>';
        
    
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']=="true"){
        echo '<div class="container">
          <h1 class="py-2">Post a Comment</h1> 
          <form action="'. $_SERVER["REQUEST_URI"] .'" method="post">
            <div class="mb-3">
            <label for="desc" class="form-label">Type your comment</label>
            <textarea class="form-control" id="desc" name="comment" rows="3"></textarea>
            <input type="hidden" name="srno" value="'.$_SESSION['srno'].'">
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
          </form>
          </div>';
    }
    else{
        echo '<div class="container">
          <h1 class="py-2">Post a Comment</h1> 
          <p class="lead">You are not logged in. Please log in to post a comment. </p>
          </div>';
    }
    echo '<div class="container mb-5" id="ques">
          <h1 class="my-5">Discussions</h1>';
    

    
    $id = $_GET['threadid'];
    $sql2 = "SELECT * FROM `comments` WHERE `thread_id`= $id";
    $result2 = mysqli_query($conn, $sql2);
    $noResult = true;
    while($row = mysqli_fetch_assoc($result2)){
        $noResult = false;
        $id = $row['comment_id'];
        $content = $row['comment_content'];
        $comment_time = $row['comment_time'];
        $user = $row['comment_by'];
        $sql3 = "SELECT `user_email` FROM `users` WHERE `srno.` = $user";
        $result3 = mysqli_query($conn, $sql3);
        $row3 = mysqli_fetch_assoc($result3);
        echo '<div class="media my-3">
            <img src="partials/images/userdefault.avif" alt="..." class="mr-3 rounded-5" width="50px">
            <div class="media-body mx-4" style="display: inline-block">'.$content.'
            <p class="my-0 fw-bold">Commented by: '.$row3['user_email'].' at '.$comment_time.' </p>
            </div>
        </div>';
        
    }
    if ($noResult) {
        // echo var_dump($noResult);
       echo '<div class="media p-4 border rounded-3">
                <p class="display-6 p-4"> No Comments found </p>
                <p class="p-4"> Be the first to comment. </p>
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