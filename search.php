<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to ForumMania - CodingForums</title>
    <style>
      #maincontainer{
        height : 100vh;
      }
      .media{
        margin-left: 20px;
        margin-top: 20px;
        width: 80vw;
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
    <div class="container my-4" id="maincontainer">
        <div class="search_title p-3">
        <h1>Search results for <em>"<?php echo $_GET['search'] ?>"</em></h1>
        </div>
        <?php
        $noresults = true;
        $query = $_GET['search'];
        $sql = "SELECT * FROM `threads` WHERE MATCH(`thread_title`, `thread_desc`) AGAINST('$query')";
        // SELECT * FROM `threads` WHERE MATCH(`thread_title`, `thread_desc`) AGAINST("pyaudio");
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
          $thread_title = $row['thread_title'];
          $thread_desc = $row['thread_desc'];
          $thread_id = $row['thread_id'];
          $url = "threads.php?threadid=".$thread_id; 
          $noresults = false;
          echo '<div class="results p-3">
                  <h3><a href="'.$url.'" class="text-dark">'.$thread_title.'</a></h3>
                  <p>'.$thread_desc.'</p>
              </div>';
            }
          if($noresults){
            echo '<div class="media p-4 border rounded-3">
                <p class="display-5 p-4"> No Results found </p>
                <p class="lead mx-2"> Suggestions: 
                  <ul>
                    <li>Make sure that all words are spelled correctly.</li>
                    <li>Try different keywords.</li>
                    <li>Try more general keywords. </li>
                  </ul>
                </p>
            </div>';
          }
        ?>
    </div>
    
    <?php include'partials/_footer.php'?>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>