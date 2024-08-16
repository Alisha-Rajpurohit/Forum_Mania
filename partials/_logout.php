<?php
session_start();
echo 'Please wait, You are being logged out.';

session_destroy();
header("Location: /Forums/");
?>