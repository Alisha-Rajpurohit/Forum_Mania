<?php
$login = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  include '_dbconnect.php';
  
  $user_email = $_POST['loginEmail'];
  $password = $_POST['loginPassword'];

    $sql = "select * from `users` where `user_email` = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $row = mysqli_fetch_assoc($result) ;
        if (password_verify($password, $row['user_pass'])) {
            $login = true;
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['srno'] = $row['srno.'];
            // echo 'successfully logged in ';
            header("location: /Forums/index.php?loginsuccess=true");
            exit();
        }
        else {
            $showError = "Invalid Credentials";
            header("location: /Forums/index.php?loginsuccess=false&error=$showError");
        }
        
    }
    else{
        $showError = "Invalid Credentials";
        header("location: /Forums/index.php?loginsuccess=false&error=$showError");
    }
}

?>