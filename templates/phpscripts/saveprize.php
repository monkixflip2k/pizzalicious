<?php
if (isset($_POST['prize']) && isset($_POST['username'])) {
    $prize = $_POST['prize'];
    $username = urldecode($_POST['username']); // Используйте urldecode() для декодирования данных

    // Выводим имя пользователя для отладки
    echo "Username: " . $username . "<br>";

    $mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

    if ($mysql->connect_error) {
        die("Connection failed: " . $mysql->connect_error);
    }

    // Получаем id пользователя по имени
    $result = $mysql->query("SELECT `id` FROM `users` WHERE `username` = '$username'");
    if (!$result) {
        die("Error: " . $mysql->error);
    }

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Удаление предыдущих призов пользователя
        $delete_result = $mysql->query("DELETE FROM `user_prizes` WHERE `user_id` = '$user_id'");
        if (!$delete_result) {
            die("Error deleting previous prizes: " . $mysql->error);
        }
        echo "Previous prizes deleted successfully<br>";

        // Вставка нового приза
        $expiration = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $stmt = $mysql->prepare("INSERT INTO `user_prizes` (`user_id`, `prize`, `expiration`) VALUES (?, ?, ?)");
        $stmt->bind_param('iss', $user_id, $prize, $expiration);
        $insert_result = $stmt->execute();
        if (!$insert_result) {
            die("Error inserting new prize: " . $stmt->error);
        }
        echo "New prize inserted successfully<br>";

        $stmt->close();
        $mysql->close();

        echo "Prize saved successfully";
    } else {
        echo "User not found";
    }
} else {
    echo "Необходимо указать приз и имя пользователя.";
}
?>