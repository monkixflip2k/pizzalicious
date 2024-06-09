<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

if (isset($_POST['add_product'])) {
    $name = filter_var(trim($_POST['product_name']), FILTER_SANITIZE_STRING);
    $type = filter_var(trim($_POST['product_type']), FILTER_SANITIZE_STRING);
    $description = filter_var(trim($_POST['product_description']), FILTER_SANITIZE_STRING);
    $price = floatval($_POST['product_price']);
    $img_path = "";

    if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["product_img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES["product_img"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file)) {
                $img_path = "/shop/templates/img/" . htmlspecialchars(basename($_FILES["product_img"]["name"]));
            } else {
                setcookie('error', "Ошибка загрузки файла", time() + 3, "/");
                header('Location: ../../pageView.php?id=addproduct.php');
                exit();
            }
        } else {
            setcookie('error', "Файл не является картинкой", time() + 3, "/");
            header('Location: ../../pageView.php?id=addproduct.php');
            exit();
        }
    }

    if (strlen($name) > 100) {
        setcookie('error', "Слишком длинное имя", time() + 3, "/");
        header('Location: ../../pageView.php?id=addproduct.php');
        exit();
    }

    if (strlen($type) > 100) {
        setcookie('error', "Слишком длинный тип товара", time() + 3, "/");
        header('Location: ../../pageView.php?id=addproduct.php');
        exit();
    }

    if (strlen($description) > 350) {
        setcookie('error', "Слишком длинное описание товара", time() + 3, "/");
        header('Location: ../../pageView.php?id=addproduct.php');
        exit();
    }

    if ($price > 9999999999) {
        setcookie('error', "Слишком большая цена", time() + 3, "/");
        header('Location: ../../pageView.php?id=addproduct.php');
        exit();
    }

    // Формирование SQL-запроса с использованием подготовленных выражений
    $stmt = $mysql->prepare("INSERT INTO `goods` (`name`, `type`, `description`, `price`, `img_path`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssd', $name, $type, $description, $price, $img_path);

    if ($stmt->execute()) {
        // Get the ID of the newly added product
        $new_product_id = $stmt->insert_id;

        // Insert selected ingredients into product_ingredients table
        if (isset($_POST['product_ingredients']) && is_array($_POST['product_ingredients'])) {
            $stmt = $mysql->prepare("INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES (?, ?)");
            foreach ($_POST['product_ingredients'] as $ingredient_id) {
                $ingredient_id = intval($ingredient_id);
                $stmt->bind_param('ii', $new_product_id, $ingredient_id);
                $stmt->execute();
            }
        }
        header('Location: ../../pageView.php?id=user.php');
    } else {
        setcookie('error', "Ошибка добавления товара: " . $mysql->error, time() + 3, "/");
        header('Location: ../../pageView.php?id=addproduct.php');
    }

    $stmt->close();
    $mysql->close();
} else {
    setcookie('error', "Ошибка: Не указано добавление товара", time() + 3, "/");
    header('Location: ../../pageView.php?id=addproduct.php');
}