<?php
    $mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

    $username = filter_var(trim($_POST['auth_username']));
    $pass = filter_var(trim($_POST['auth_pass']));

    $hashed_pass = hash('sha256', $pass);

    $result = $mysql->query("SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$hashed_pass'");
    $user = $result->fetch_assoc();

    if($user == NULL){
        setcookie('error', "Неверный логин или пароль", time() + 3, "/");
        header('Location: ../../pageView.php?id=auth.php');
    }
    else{
        setcookie('user', $user['username'], 0, "/");
        setcookie('user_type', $user['type'], 0, "/");
        header('Location: ../../index.php');
    }

    
    $mysql -> close();
?>