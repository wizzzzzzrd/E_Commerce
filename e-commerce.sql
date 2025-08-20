-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2025 a las 19:37:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `e-commerce`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backup_marker`
--

CREATE TABLE `backup_marker` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `envio` mediumtext NOT NULL,
  `tienda` mediumtext NOT NULL,
  `uber` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `num_card` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status_venta` varchar(50) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `delivery_method` enum('envio','recoger','uber') NOT NULL DEFAULT 'envio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders_archive`
--

CREATE TABLE `orders_archive` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `num_card` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `status_venta` varchar(50) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `delivery_method` enum('envio','recoger','uber') NOT NULL DEFAULT 'envio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orders_archive`
--

INSERT INTO `orders_archive` (`id`, `order_id`, `name`, `email`, `phone`, `num_card`, `total`, `order_date`, `status_venta`, `metodo_pago`, `delivery_method`) VALUES
(48, '6N197265C8939745E', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 171.44, '2024-07-30 18:40:12', 'pagado', 'paypal', 'envio'),
(49, '', 'Joseph Aaron Alarcon Camarillo', 'josephcamarillo112@gmail.com', '5583947980', '454545454545', 171.44, '2024-07-30 20:40:21', 'pagado', '', 'envio'),
(50, '46949713N8346225E', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 172.07, '2024-07-30 21:44:43', 'pagado', 'paypal', 'envio'),
(51, '0KJ44967US5877001', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 172.07, '2024-07-30 21:50:20', 'pagado', 'paypal', 'envio'),
(52, '9VL331538J313502A', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 269.70, '2024-07-30 22:41:34', 'pagado', 'paypal', 'envio'),
(53, '', 'Joseph Aaron Alarcon Camarillo', 'josephcamarillo112@gmail.com', '5583947980', '343434343434', 269.70, '2024-07-31 00:41:44', 'no pagado', '', 'envio'),
(54, '6XB09676R66174009', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 33.90, '2025-07-24 00:55:33', 'pagado', 'paypal', 'envio'),
(55, '', 'JOSEPH', 'wizzzzzzrd@gmail.com', '56 4150 5137', NULL, 39.90, '2025-07-24 02:57:45', 'pagado', 'transferencia', 'envio'),
(56, '', 'JOSEPH', 'wizzzzzzrd@gmail.com', NULL, NULL, 39.90, '2025-07-24 03:07:29', 'no pagado', 'transferencia', 'envio'),
(59, '', 'sd', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 39.90, '2025-07-24 05:49:37', 'no pagado', 'transferencia', 'envio'),
(60, '', 'sd', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 39.90, '2025-07-24 05:49:37', 'no pagado', 'transferencia', 'envio'),
(61, '', 'sdasd', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 39.90, '2025-07-24 05:53:00', 'no pagado', 'transferencia', 'envio'),
(62, '', 'sdasd', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 39.90, '2025-07-24 05:58:17', 'no pagado', 'transferencia', 'recoger'),
(63, '9F519633NY001303K', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 79.80, '2025-07-24 04:45:46', 'pagado', 'paypal', 'recoger'),
(64, '', 'sdasd', 'boar675.13@gmail.com', '56 4150 5137', NULL, 79.80, '2025-07-24 06:52:26', 'no pagado', 'transferencia', 'envio'),
(65, '9AS048724F055361K', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 79.80, '2025-07-24 04:54:20', 'pagado', 'paypal', 'envio'),
(66, '', '', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 79.80, '2025-07-24 06:55:08', 'no pagado', 'transferencia', 'uber'),
(67, '', '', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 169.70, '2025-07-24 07:00:02', 'no pagado', 'transferencia', 'recoger'),
(68, '1DD48052SB090850L', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 169.70, '2025-07-24 05:18:20', 'pagado', 'paypal', 'envio'),
(69, '', '', 'wizzzzzzrd@gmail.com', '56 4150 5137', NULL, 169.70, '2025-07-24 07:19:14', 'no pagado', 'transferencia', 'recoger'),
(70, '9J398484B19770302', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 179.80, '2025-07-24 17:20:12', 'pagado', 'paypal', 'envio'),
(71, '', '', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 89.90, '2025-07-24 19:21:01', 'no pagado', 'transferencia', 'uber'),
(72, '', '', 'wizzzzzzrd@gmail.com', '4803872510', NULL, 449.50, '2025-07-24 19:38:49', 'no pagado', 'transferencia', 'recoger'),
(73, '', 'Joseph Alarcon', 'wizzzzzzrd@gmail.com', '4555', NULL, 64.80, '2025-07-24 22:06:13', 'no pagado', 'transferencia', 'envio'),
(74, '', 'Joseph Alarcon', 'admin@admin.com', '56 4150 5137', NULL, 64.80, '2025-07-24 22:08:24', 'no pagado', 'transferencia', 'envio'),
(75, '', '', 'wizzzzzzrd@gmail.com', '56 4150 5137', NULL, 64.80, '2025-07-24 22:09:26', 'no pagado', 'transferencia', 'recoger'),
(76, '1HT742381X080242X', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 64.80, '2025-07-24 20:10:50', 'pagado', 'paypal', 'uber'),
(77, '', 'Joseph Alarcon', 'wizzzzzzrd@gmail.com', '56 4150 5137', NULL, 64.80, '2025-07-24 22:11:27', 'no pagado', 'transferencia', 'envio'),
(78, '', 'Joseph Alarcon', 'wizzzzzzrd@gmail.com', '4803872510', '0435', 64.80, '2025-07-25 18:40:53', 'pagado', 'transferencia', 'envio'),
(79, '7T211984C0430682T', 'John Doe', 'sb-95hqj31592580@personal.example.com', NULL, NULL, 64.80, '2025-07-25 16:43:34', 'pagado', 'paypal', 'uber'),
(80, '', '', 'admin@admin.com', '4803872510', '0435', 64.80, '2025-07-25 18:44:46', 'pagado', 'transferencia', 'uber'),
(81, '', 'Joseph Alarcon', 'wizzzzzzrd@gmail.com', '4803872510', '0435', 64.80, '2025-07-25 18:45:25', 'pagado', 'transferencia', 'envio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details_archive`
--

CREATE TABLE `order_details_archive` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `order_details_archive`
--

INSERT INTO `order_details_archive` (`detail_id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `total`) VALUES
(81, 48, 22, 'Reloj', 2, 34.00, 69.78),
(82, 48, 29, 'sgs', 1, 33.00, 33.70),
(83, 48, 32, 'casa', 2, 33.00, 67.96),
(84, 49, 22, 'Reloj', 2, 34.89, 69.78),
(85, 49, 29, 'sgs', 1, 33.70, 33.70),
(86, 49, 32, 'casa', 2, 33.98, 67.96),
(87, 50, 29, 'sgs', 2, 33.00, 67.40),
(88, 50, 22, 'Reloj', 3, 34.00, 104.67),
(89, 51, 29, 'sgs', 2, 33.00, 67.40),
(90, 51, 22, 'Reloj', 3, 34.00, 104.67),
(91, 52, 33, 'Shade Llumene', 1, 89.00, 89.90),
(92, 52, 34, 'Creme Care', 1, 89.00, 89.90),
(93, 52, 45, 'Aqua Alegoria', 1, 89.00, 89.90),
(94, 53, 33, 'Shade Llumene', 1, 89.90, 89.90),
(95, 53, 34, 'Creme Care', 1, 89.90, 89.90),
(96, 53, 45, 'Aqua Alegoria', 1, 89.90, 89.90),
(97, 54, 43, 'Foot towel', 1, 33.00, 33.90),
(98, 55, 35, 'Roll Face', 1, 39.00, 39.90),
(99, 56, 35, 'Roll Face', 1, 39.00, 39.90),
(101, 60, 35, '', 1, 39.90, 0.00),
(102, 61, 35, '', 1, 39.90, 0.00),
(103, 62, 35, '', 1, 39.90, 0.00),
(104, 63, 35, 'Roll Face', 2, 39.00, 79.80),
(105, 64, 35, '', 2, 39.90, 0.00),
(106, 65, 35, 'Roll Face', 2, 39.90, 79.80),
(107, 66, 35, '', 2, 39.90, 0.00),
(108, 67, 35, 'Roll Face', 2, 39.90, 79.80),
(109, 67, 33, 'Shade Llumene', 1, 89.90, 89.90),
(110, 68, 35, 'Roll Face', 2, 39.90, 79.80),
(111, 68, 33, 'Shade Llumene', 1, 89.90, 89.90),
(112, 69, 35, 'Roll Face', 2, 39.90, 79.80),
(113, 69, 33, 'Shade Llumene', 1, 89.90, 89.90),
(114, 70, 45, 'Aqua Alegoria', 1, 89.90, 89.90),
(115, 70, 33, 'Shade Llumene', 1, 89.90, 89.90),
(116, 71, 45, 'Aqua Alegoria', 1, 89.90, 89.90),
(117, 72, 45, 'Aqua Alegoria', 5, 89.90, 449.50),
(118, 73, 36, 'Shaving Cream', 1, 24.90, 24.90),
(119, 73, 35, 'Roll Face', 1, 39.90, 39.90),
(120, 74, 36, 'Shaving Cream', 1, 24.90, 24.90),
(121, 74, 35, 'Roll Face', 1, 39.90, 39.90),
(122, 75, 36, 'Shaving Cream', 1, 24.90, 24.90),
(123, 75, 35, 'Roll Face', 1, 39.90, 39.90),
(124, 76, 36, 'Shaving Cream', 1, 24.90, 24.90),
(125, 76, 35, 'Roll Face', 1, 39.90, 39.90),
(126, 77, 36, 'Shaving Cream', 1, 24.90, 24.90),
(127, 77, 35, 'Roll Face', 1, 39.90, 39.90),
(128, 78, 36, 'Shaving Cream', 1, 24.90, 24.90),
(129, 78, 35, 'Roll Face', 1, 39.90, 39.90),
(130, 79, 36, 'Shaving Cream', 1, 24.90, 24.90),
(131, 79, 35, 'Roll Face', 1, 39.90, 39.90),
(132, 80, 36, 'Shaving Cream', 1, 24.90, 24.90),
(133, 80, 35, 'Roll Face', 1, 39.90, 39.90),
(134, 81, 36, 'Shaving Cream', 1, 24.90, 24.90),
(135, 81, 35, 'Roll Face', 1, 39.90, 39.90);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `paypal_transaction_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payments_archive`
--

CREATE TABLE `payments_archive` (
  `payment_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `paypal_transaction_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_stock` int(20) NOT NULL DEFAULT 1,
  `actions_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_archive`
--

CREATE TABLE `products_archive` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_stock` int(20) NOT NULL DEFAULT 1,
  `actions_enabled` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_details`
--

CREATE TABLE `shipping_details` (
  `order_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `shipping_details_archive`
--

CREATE TABLE `shipping_details_archive` (
  `order_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders_archive`
--
ALTER TABLE `orders_archive`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `order_details_archive`
--
ALTER TABLE `order_details_archive`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `payments_archive`
--
ALTER TABLE `payments_archive`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `products_archive`
--
ALTER TABLE `products_archive`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `shipping_details_archive`
--
ALTER TABLE `shipping_details_archive`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orders_archive`
--
ALTER TABLE `orders_archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `order_details_archive`
--
ALTER TABLE `order_details_archive`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `payments_archive`
--
ALTER TABLE `payments_archive`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products_archive`
--
ALTER TABLE `products_archive`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Filtros para la tabla `shipping_details`
--
ALTER TABLE `shipping_details`
  ADD CONSTRAINT `shipping_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
