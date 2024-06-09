<?php
$mysql = new mysqli('localhost', 'root', '', 'pizza_bd');

if (isset($_POST['edit_product'])) {
    $id = intval($_POST['product_id']);
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
                header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
                exit();
            }
        } else {
            setcookie('error', "Файл не является картинкой", time() + 3, "/");
            header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
            exit();
        }
    }

    if (strlen($name) > 100) {
        setcookie('error', "Слишком длинное имя", time() + 3, "/");
        header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
        exit();
    }

    if (strlen($type) > 100) {
        setcookie('error', "Слишком длинный тип товара", time() + 3, "/");
        header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
        exit();
    }

    if (strlen($description) > 350) {
        setcookie('error', "Слишком длинное описание товара", time() + 3, "/");
        header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
        exit();
    }

    if ($price > 9999999999) {
        setcookie('error', "Слишком большая цена", time() + 3, "/");
        header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
        exit();
    }

    if (empty($img_path)) {
        $query = "UPDATE `goods` SET `name` = '$name', `type` = '$type', `description` = '$description', `price` = '$price' WHERE `id` = '$id'";
    } else {
        $query = "UPDATE `goods` SET `name` = '$name', `type` = '$type', `description` = '$description', `price` = '$price', `img_path` = '$img_path' WHERE `id` = '$id'";
    }

    if ($mysql->query($query) === TRUE) {
        // Update product ingredients
        $mysql->query("DELETE FROM `product_ingredients` WHERE `product_id` = '$id'");
        if (isset($_POST['product_ingredients'])) {
            foreach ($_POST['product_ingredients'] as $ingredient_id) {
                $ingredient_id = intval($ingredient_id);
                $mysql->query("INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES ('$id', '$ingredient_id')");
            }
        }
        header('Location: ../../pageView.php?id=user.php');
    } else {
        setcookie('error', "Ошибка обновления товара: " . $mysql->error, time() + 3, "/");
        header('Location: ../../pageView.php?id=editproduct.php&product_id=' . $id);
    }

    $mysql->close();
} else {
    setcookie('error', "Не указан ID товара", time() + 3, "/");
    header('Location: ../../pageView.php?id=editproduct.php');
}
?>