<?php
    $username = filter_var(trim($_POST['reg_username']));
    if(strlen($username) > 100){
        setcookie('error', "Имя не может быть больше 100 символов", time() + 3, "/");
        header('Location: ../../pageView.php?id=registration.php');
    }
    elseif(strlen($username) < 5){
        setcookie('error', "Имя не может быть меньше 5 символов", time() + 3, "/");
        header('Location: ../../pageView.php?id=registration.php');
    }
    $mysql = new mysqli('localhost', 'root', '', 'pizza_bd');
    $result = $mysql->query("SELECT * FROM `users` WHERE `username` = '$username'")->fetch_assoc();
    if($result != NULL){
        setcookie('error', "Пользователь с таким именем уже существует", time() + 3, "/");
        $mysql->close();
        header('Location: ../../pageView.php?id=registration.php');
    }
    $pass = filter_var(trim($_POST['reg_pass']));
    if(strlen($pass) > 100){
        setcookie('error', "Пароль не может быть больше 100 символов", time() + 3, "/");
        $mysql->close();
        header('Location: ../../pageView.php?id=registration.php');
    }
    elseif(strlen($pass) < 5){
        setcookie('error', "Пароль не может быть меньше 5 символов", time() + 3, "/");
        $mysql->close();
        header('Location: ../../pageView.php?id=registration.php');
    }

    $hashed_pass = hash('sha256', $pass);

    $mysql->query("INSERT INTO `users` (`username`, `password`)
                    VALUES ('$username', '$hashed_pass')");
    $mysql->close();

    setcookie('user', $username, 0, "/");
    setcookie('user_type', 'user', 0, "/");
    header('Location: ../../index.php');
?>