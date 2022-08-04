<?php
include 'connect.php';
if (isset($_POST['submit']))
{
    $username = trim(strip_tags(stripslashes(($_POST['username']))));
    $password = sha1(md5($_POST['password']));
    $User = new User($username, $password);
}





