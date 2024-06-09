

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `img_path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `type`, `description`, `price`, `img_path`) VALUES
(9, 'Пепперони', 'Пицца', 'Наслаждайтесь аутентичным вкусом Италии с нашей пиццей Пепперони! Сочные кусочки пикантной пепперони, обжаренные до золотистой хрустящей корочки, томатный соус, который раскрывает свою интенсивную ароматическую палитру, и щедрая порция моцареллы, растопленной во рту — все это сочетается в идеальной гармонии на тонком хрустящем тесте. Ощутите волшебство итальянского вкуса в каждом кусочке!пеперонка', 600, 'img/pizza1.png'),
(10, 'Маргарита', 'Пицца', 'Простота и изысканность в каждом кусочке — наша пицца Маргарита. Сочное сочетание свежего помидора, натурального базилика и нежной моцареллы на хрустящем тонком тесте. Каждый укус напоминает о ласковом солнце Италии и аромате свежести. Отдайте предпочтение классике и насладитесь настоящим вкусом Итальянской пиццы с нами.', 590, 'img/pizza2.png'),
(13, 'Диабло', 'Пицца', 'Погрузитесь в мир огненного вкуса с нашей пиццей Диабло! Острая и пикантная, она завоевывает сердца ценителей пикантных ощущений. Щедрые порции пикантной пепперони, сочные кусочки острого перца Халапеньо и взрывной вкус чеснока в сочетании с нежной моцареллой на хрустящем тесте создают истинный огненный аромат и вкусовую симфонию. Почувствуйте огонь страсти на вашем языке с каждым укусом пиццы Диабло!', 780, 'img/pizza3.png'),
(19, 'Пепперони', 'Пицца', 'Наслаждайтесь аутентичным вкусом Италии с нашей пиццей Пепперони! Сочные кусочки пикантной пепперони, обжаренные до золотистой хрустящей корочки, томатный соус, который раскрывает свою интенсивную ароматическую палитру, и щедрая порция моцареллы, растопленной во рту — все это сочетается в идеальной гармонии на тонком хрустящем тесте. Ощутите волшебство итальянского вкуса в каждом кусочке!', 600, 'img/pizza1.png'),
(120, 'Маргарита', 'Пицца', 'Простота и изысканность в каждом кусочке — наша пицца Маргарита. Сочное сочетание свежего помидора, натурального базилика и нежной моцареллы на хрустящем тонком тесте. Каждый укус напоминает о ласковом солнце Италии и аромате свежести. Отдайте предпочтение классике и насладитесь настоящим вкусом Итальянской пиццы с нами.', 590, 'img/pizza2.png'),
(143, 'Диабло', 'Пицца', 'Погрузитесь в мир огненного вкуса с нашей пиццей Диабло! Острая и пикантная, она завоевывает сердца ценителей пикантных ощущений. Щедрые порции пикантной пепперони, сочные кусочки острого перца Халапеньо и взрывной вкус чеснока в сочетании с нежной моцареллой на хрустящем тесте создают истинный огненный аромат и вкусовую симфонию. Почувствуйте огонь страсти на вашем языке с каждым укусом пиццы Диабло!', 780, 'img/pizza3.png');
-- --------------------------------------------------------

--
-- Структура таблицы `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`, `type`) VALUES
(5, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin'),
(6, 'username', 'd17f25ecfbcc7857f7bebea469308be0b2580943e96d13a3ad98a13675c4bfc2', 'user');


--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа таблицы `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `goods` (`id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);




--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` INT(10) NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `total_price` DECIMAL(10, 2) NOT NULL,
  `status` VARCHAR(50) DEFAULT 'В работе',
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `orders` 
ADD COLUMN `payment_method` VARCHAR(50) NOT NULL,
ADD COLUMN `delivery_method` VARCHAR(50) NOT NULL,
ADD COLUMN `delivery_address` VARCHAR(255),
ADD COLUMN `phone_number` VARCHAR(20) NOT NULL,
ADD COLUMN `delivery_time` DATETIME NOT NULL,
ADD COLUMN `applied_prize` VARCHAR(255) DEFAULT NULL;

-- --------------------------------------------------------

CREATE TABLE `user_prizes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `prize` VARCHAR(50) NOT NULL,
    `expiration` DATETIME NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` INT(10) NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`),
  FOREIGN KEY (`product_id`) REFERENCES `goods`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `ingredients` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `product_ingredients` (
  `product_id` INT(10) NOT NULL,
  `ingredient_id` INT(10) NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `goods`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `ingredients` (`name`) VALUES 
('Тесто'),
('Колбаса'),
('Сыр'),
('Огурцы'),
('Грибы'),
('Мясо');


-- Добавление ингредиентов к пицце "Пепперони" (id=9)
INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES
(9, 1), -- Тесто
(9, 2), -- Колбаса
(9, 3); -- Сыр

-- Добавление ингредиентов к пицце "Маргарита" (id=10)
INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES
(10, 1), -- Тесто
(10, 4), -- Огурцы
(10, 5); -- Грибы

-- Добавление ингредиентов к пицце "Диабло" (id=13)
INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES
(13, 1), -- Тесто
(13, 2), -- Колбаса
(13, 3), -- Сыр
(13, 6); -- Мясо

-- Добавление ингредиентов к пицце "Пепперони" (id=19)
INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES
(19, 1), -- Тесто
(19, 2), -- Колбаса
(19, 3); -- Сыр

-- Добавление ингредиентов к пицце "Маргарита" (id=120)
INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES
(120, 1), -- Тесто
(120, 4), -- Огурцы
(120, 5); -- Грибы

-- Добавление ингредиентов к пицце "Диабло" (id=143)
INSERT INTO `product_ingredients` (`product_id`, `ingredient_id`) VALUES
(143, 1), -- Тесто
(143, 2), -- Колбаса
(143, 3), -- Сыр
(143, 6); -- Мясо
COMMIT;

