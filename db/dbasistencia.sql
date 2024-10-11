-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 16-02-2024 a las 19:10:51
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbasistencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendance_tbl`
--

CREATE TABLE `attendance_tbl` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `class_date` date NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1 = Present, 2 = Late, 3 = Absent, 4 = Holiday',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `attendance_tbl`
--

INSERT INTO `attendance_tbl` (`id`, `student_id`, `class_date`, `status`, `created_at`, `updated_at`) VALUES
(112, 9, '2024-02-07', 1, '2024-02-14 13:19:49', NULL),
(113, 8, '2024-02-07', 1, '2024-02-14 13:19:49', NULL),
(114, 11, '2024-02-07', 2, '2024-02-14 13:19:49', NULL),
(115, 10, '2024-02-07', 2, '2024-02-14 13:19:49', '2024-02-14 13:23:56'),
(116, 9, '2024-02-08', 1, '2024-02-14 13:24:38', NULL),
(117, 8, '2024-02-08', 1, '2024-02-14 13:24:38', NULL),
(118, 11, '2024-02-08', 1, '2024-02-14 13:24:38', NULL),
(119, 10, '2024-02-08', 1, '2024-02-14 13:24:38', NULL),
(120, 9, '2024-02-14', 1, '2024-02-14 14:14:26', NULL),
(121, 8, '2024-02-14', 2, '2024-02-14 14:14:26', NULL),
(122, 11, '2024-02-14', 3, '2024-02-14 14:14:26', NULL),
(123, 10, '2024-02-14', 4, '2024-02-14 14:14:26', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `class_tbl`
--

CREATE TABLE `class_tbl` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `class_tbl`
--

INSERT INTO `class_tbl` (`id`, `name`, `created_at`, `updated_at`) VALUES
(5, 'Biologia', '2024-02-14 13:01:02', NULL),
(6, 'Inglés', '2024-02-14 13:02:25', NULL),
(8, 'Filosofia', '2024-02-14 13:02:48', NULL),
(9, 'Química', '2024-02-14 13:11:09', NULL),
(11, 'Lenguaje', '2024-02-14 14:09:54', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students_tbl`
--

CREATE TABLE `students_tbl` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `students_tbl`
--

INSERT INTO `students_tbl` (`id`, `class_id`, `name`, `created_at`, `updated_at`) VALUES
(8, 5, 'Javier Caja', '2024-02-14 13:13:29', NULL),
(9, 5, 'Fredy Tito', '2024-02-14 13:13:43', NULL),
(10, 5, 'Raul Brass', '2024-02-14 13:13:57', NULL),
(11, 5, 'Maria Ordoñez', '2024-02-14 13:14:18', NULL),
(13, 9, 'Jorge Lopez', '2024-02-14 13:15:18', NULL),
(14, 9, 'Juana Perez', '2024-02-14 14:11:35', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id_fk` (`student_id`);

--
-- Indices de la tabla `class_tbl`
--
ALTER TABLE `class_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `students_tbl`
--
ALTER TABLE `students_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id_fk` (`class_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `class_tbl`
--
ALTER TABLE `class_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `students_tbl`
--
ALTER TABLE `students_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `attendance_tbl`
--
ALTER TABLE `attendance_tbl`
  ADD CONSTRAINT `student_id_fk` FOREIGN KEY (`student_id`) REFERENCES `students_tbl` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `students_tbl`
--
ALTER TABLE `students_tbl`
  ADD CONSTRAINT `class_id_fk` FOREIGN KEY (`class_id`) REFERENCES `class_tbl` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
