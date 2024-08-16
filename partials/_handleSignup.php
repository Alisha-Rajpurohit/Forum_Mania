<?php
include'_dbconnect.php';
$showSuccess = false;
$showError = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_email = $_POST['signupEmail'];
    $password = $_POST['signupPassword'];
    $cpassword = $_POST['signupcPassword'];
    $existSql = "SELECT * FROM `users` WHERE `user_email` = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numExistRow = mysqli_num_rows($result);
    if($numExistRow > 0){
        // echo 'fail';
        $showError = 'Email Already exists';
    }
    else{
        if($password == $cpassword){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
                if($result){
                    // echo 'success';
                    $showSuccess = true;
                    header("Location: /Forums/index.php?signupsuccess=true");
                    exit();
                }
        }
        else{
                // echo 'fail';
                $showError = "Password doesn't matched";
                header("Location: /Forums/index.php?signupsuccess=false&error=$showError");
            }
        }
        header("Location: /Forums/index.php?signupsuccess=false&error=$showError");
}
?>