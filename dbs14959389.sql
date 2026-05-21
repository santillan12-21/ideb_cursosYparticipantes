-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Servidor: db5018996603.hosting-data.io
-- Tiempo de generación: 19-05-2026 a las 19:55:58
-- Versión del servidor: 8.0.36
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbs14959389`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course_action_logs`
--

CREATE TABLE `course_action_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `curso_id` bigint UNSIGNED DEFAULT NULL,
  `nombre_curso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `accion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `detalles` text COLLATE utf8mb4_unicode_ci,
  `fecha_accion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `course_action_logs`
--

INSERT INTO `course_action_logs` (`id`, `curso_id`, `nombre_curso`, `user_id`, `accion`, `detalles`, `fecha_accion`, `created_at`, `updated_at`) VALUES
(10, 39, 'Cursos_V7', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-02 20:15:05', '2025-06-02 20:15:05', '2025-06-02 20:15:05'),
(11, 39, 'Cursos_V7', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-02 20:30:08', '2025-06-02 20:30:08', '2025-06-02 20:30:08'),
(12, 39, 'Cursos_V7', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-02 21:09:08', '2025-06-02 21:09:08', '2025-06-02 21:09:08'),
(13, 45, 'Subcurso_Curso_v5_2', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-03 18:15:23', '2025-06-03 18:15:23', '2025-06-03 18:15:23'),
(14, 46, 'Subcurso_Curso_v5_3', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-03 18:29:43', '2025-06-03 18:29:43', '2025-06-03 18:29:43'),
(15, 48, 'Subcurso_Curso_v5_5', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-03 20:40:48', '2025-06-03 20:40:48', '2025-06-03 20:40:48'),
(16, 49, 'Subcurso_Curso_v5_6', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-03 20:42:05', '2025-06-03 20:42:05', '2025-06-03 20:42:05'),
(17, 36, 'Curso de Prueba v2_Subcurso_2', 4, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-06-03 20:42:37', '2025-06-03 20:42:37', '2025-06-03 20:42:37'),
(18, 50, 'Subcurso_Curso de Prueba v3_2', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-03 20:43:06', '2025-06-03 20:43:06', '2025-06-03 20:43:06'),
(19, 51, 'Subcurso_Cursos_V2_3', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-03 20:43:30', '2025-06-03 20:43:30', '2025-06-03 20:43:30'),
(20, 52, 'Subcurso_Curso_v5_7', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-03 21:09:32', '2025-06-03 21:09:32', '2025-06-03 21:09:32'),
(21, 46, 'Subcurso_Curso_v5_3', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-03 21:09:53', '2025-06-03 21:09:53', '2025-06-03 21:09:53'),
(22, 55, 'asdasd', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-04 17:40:02', '2025-06-04 17:40:02', '2025-06-04 17:40:02'),
(23, 56, 'Subcurso_Curso_v5_7', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-04 17:41:00', '2025-06-04 17:41:00', '2025-06-04 17:41:00'),
(24, 56, 'Subcurso_Curso_v5_7', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-04 18:30:40', '2025-06-04 18:30:40', '2025-06-04 18:30:40'),
(25, 55, 'asdasd', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-04 18:31:55', '2025-06-04 18:31:55', '2025-06-04 18:31:55'),
(26, 62, 'Subcurso_Cursos_V2_4', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-04 20:38:13', '2025-06-04 20:38:13', '2025-06-04 20:38:13'),
(27, 63, 'Subcurso_Cursos_V2_5', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-04 20:40:19', '2025-06-04 20:40:19', '2025-06-04 20:40:19'),
(28, 64, 'Subcurso_Curso_v5_8', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-04 20:47:41', '2025-06-04 20:47:41', '2025-06-04 20:47:41'),
(29, 65, 'Subcurso_Cursos_V2_6', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-04 20:59:32', '2025-06-04 20:59:32', '2025-06-04 20:59:32'),
(30, 66, 'Subcurso_Cursos_V2_7', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-04 21:03:13', '2025-06-04 21:03:13', '2025-06-04 21:03:13'),
(31, 67, 'Subcurso_Curso_v5_9', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 02:17:37', '2025-06-05 02:17:37', '2025-06-05 02:17:37'),
(32, 69, 'Subcurso_Curso_v5_11', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 03:18:36', '2025-06-05 03:18:36', '2025-06-05 03:18:36'),
(33, 70, 'Subcurso_Curso de Prueba v3_3', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 19:25:40', '2025-06-05 19:25:40', '2025-06-05 19:25:40'),
(34, 71, 'Subcurso_Curso de Prueba v3_4', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 19:30:14', '2025-06-05 19:30:14', '2025-06-05 19:30:14'),
(35, 72, 'Subcurso_Curso de Prueba v3_5', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 19:51:58', '2025-06-05 19:51:58', '2025-06-05 19:51:58'),
(36, 73, 'Subcurso_Curso de Prueba v3_6', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 20:03:38', '2025-06-05 20:03:38', '2025-06-05 20:03:38'),
(37, 74, 'Subcurso_Curso de Prueba v3_7', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 20:07:45', '2025-06-05 20:07:45', '2025-06-05 20:07:45'),
(38, 75, 'Subcurso_Curso de Prueba v3_8', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 20:46:01', '2025-06-05 20:46:01', '2025-06-05 20:46:01'),
(39, 76, 'Subcurso_Curso de Prueba v3_9', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-05 20:48:36', '2025-06-05 20:48:36', '2025-06-05 20:48:36'),
(40, 80, 'Subcurso_Curso de Prueba v3_12', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-05 21:39:56', '2025-06-05 21:39:56', '2025-06-05 21:39:56'),
(41, 81, 'Subcurso_Curso de Prueba v2_4', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 02:30:57', '2025-06-06 02:30:57', '2025-06-06 02:30:57'),
(42, 83, 'Subcurso_Curso de Prueba v3_13', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 04:06:46', '2025-06-06 04:06:46', '2025-06-06 04:06:46'),
(43, 85, 'Curso de prueba D', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 04:17:40', '2025-06-06 04:17:40', '2025-06-06 04:17:40'),
(44, 85, 'Curso de prueba D', 4, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-06-06 04:18:25', '2025-06-06 04:18:25', '2025-06-06 04:18:25'),
(45, 86, 'CursosV4', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 04:25:27', '2025-06-06 04:25:27', '2025-06-06 04:25:27'),
(46, 87, 'Subcurso_Curso de prueba D_1', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 04:30:22', '2025-06-06 04:30:22', '2025-06-06 04:30:22'),
(47, 88, 'Subcurso_CursosV4_1', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 04:49:19', '2025-06-06 04:49:19', '2025-06-06 04:49:19'),
(48, 1, 'Cursos', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 05:31:33', '2025-06-06 05:31:33', '2025-06-06 05:31:33'),
(49, 2, 'Subcurso_Cursos_1', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 05:33:12', '2025-06-06 05:33:12', '2025-06-06 05:33:12'),
(50, 4, 'Cursos_V7', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-06 16:07:35', '2025-06-06 16:07:35', '2025-06-06 16:07:35'),
(51, 5, 'Cursos_99', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 16:14:53', '2025-06-06 16:14:53', '2025-06-06 16:14:53'),
(52, 6, 'Subcurso_Cursos_99_1', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 16:18:07', '2025-06-06 16:18:07', '2025-06-06 16:18:07'),
(53, 7, 'Subcurso_Cursos_99_2', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 16:45:40', '2025-06-06 16:45:40', '2025-06-06 16:45:40'),
(54, 8, 'Subcurso_Cursos_99_3', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-06 16:47:14', '2025-06-06 16:47:14', '2025-06-06 16:47:14'),
(55, 8, 'Subcurso_Cursos_99_3', 4, 'Editado', 'El paso 2 del curso fue actualizado.', '2025-06-06 16:47:33', '2025-06-06 16:47:33', '2025-06-06 16:47:33'),
(56, 8, 'Subcurso_Cursos_99_3', 4, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-06-06 16:47:50', '2025-06-06 16:47:50', '2025-06-06 16:47:50'),
(57, 9, 'Cursos_10', 4, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-06 16:55:57', '2025-06-06 16:55:57', '2025-06-06 16:55:57'),
(58, 10, 'Cursos_V2', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 17:04:18', '2025-06-06 17:04:18', '2025-06-06 17:04:18'),
(59, 11, 'Subcurso_Cursos_V2_1', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 17:22:21', '2025-06-06 17:22:21', '2025-06-06 17:22:21'),
(60, 11, 'Subcurso_Cursos_V2_1', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-06 17:25:24', '2025-06-06 17:25:24', '2025-06-06 17:25:24'),
(61, 11, 'Subcurso_Cursos_V2_1', 5, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-06 17:31:17', '2025-06-06 17:31:17', '2025-06-06 17:31:17'),
(62, 12, 'Subcurso_Cursos_V2_2', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 18:06:36', '2025-06-06 18:06:36', '2025-06-06 18:06:36'),
(63, 13, 'Subcurso_Cursos_2', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-06 18:10:22', '2025-06-06 18:10:22', '2025-06-06 18:10:22'),
(64, 14, 'Subcurso_Cursos_3', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-06 18:44:54', '2025-06-06 18:44:54', '2025-06-06 18:44:54'),
(65, 17, 'Crusos del grupo D', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 18:54:50', '2025-06-10 18:54:50', '2025-06-10 18:54:50'),
(66, 17, 'Crusos del grupo D', 6, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-06-10 18:56:15', '2025-06-10 18:56:15', '2025-06-10 18:56:15'),
(67, 4, 'Cursos_V7', 6, 'Editado', 'El paso 7 del curso fue actualizado.', '2025-06-10 19:09:20', '2025-06-10 19:09:20', '2025-06-10 19:09:20'),
(68, 19, 'Subcurso_Cursos_6', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 19:31:43', '2025-06-10 19:31:43', '2025-06-10 19:31:43'),
(69, 17, 'Crusos del grupo D', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-10 19:57:29', '2025-06-10 19:57:29', '2025-06-10 19:57:29'),
(70, 20, 'Subcurso_Crusos del grupo D_2', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 20:14:13', '2025-06-10 20:14:13', '2025-06-10 20:14:13'),
(71, 21, 'Subcurso_Crusos del grupo D_3', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 20:16:00', '2025-06-10 20:16:00', '2025-06-10 20:16:00'),
(72, 23, 'Programación en laravel', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 20:45:06', '2025-06-10 20:45:06', '2025-06-10 20:45:06'),
(73, 24, 'Programacion_JavaS', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 21:06:59', '2025-06-10 21:06:59', '2025-06-10 21:06:59'),
(74, 25, 'Subcurso_Programación en laravel_1', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-10 21:12:46', '2025-06-10 21:12:46', '2025-06-10 21:12:46'),
(75, 27, 'Subcurso_Programacion_JavaS_1', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-11 20:07:25', '2025-06-11 20:07:25', '2025-06-11 20:07:25'),
(76, 28, 'Subcurso_Programacion_JavaS_2', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-11 21:37:29', '2025-06-11 21:37:29', '2025-06-11 21:37:29'),
(77, 9, 'Cursos_10', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-13 16:22:29', '2025-06-13 16:22:29', '2025-06-13 16:22:29'),
(78, 9, 'Cursos_10', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-13 16:22:45', '2025-06-13 16:22:45', '2025-06-13 16:22:45'),
(79, 31, 'Subcurso_Programacion_JavaS_3', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-13 16:27:52', '2025-06-13 16:27:52', '2025-06-13 16:27:52'),
(80, 32, 'Subcurso_Programacion_JavaS_4', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-13 16:32:36', '2025-06-13 16:32:36', '2025-06-13 16:32:36'),
(81, 14, 'Subcurso_Cursos_3', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 17:15:06', '2025-06-13 17:15:06', '2025-06-13 17:15:06'),
(82, 14, 'Subcurso_Cursos_3', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 17:15:26', '2025-06-13 17:15:26', '2025-06-13 17:15:26'),
(83, 14, 'Subcurso_Cursos_3', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 17:16:05', '2025-06-13 17:16:05', '2025-06-13 17:16:05'),
(84, 14, 'Subcurso_Cursos_3', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 17:21:16', '2025-06-13 17:21:16', '2025-06-13 17:21:16'),
(85, 14, 'Subcurso_Cursos_3', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 17:31:48', '2025-06-13 17:31:48', '2025-06-13 17:31:48'),
(86, 34, 'Subcurso_Programacion_JavaS_6', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-13 17:51:05', '2025-06-13 17:51:05', '2025-06-13 17:51:05'),
(87, 14, 'Subcurso_Cursos_3', 4, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 20:06:43', '2025-06-13 20:06:43', '2025-06-13 20:06:43'),
(88, 14, 'Subcurso_Cursos_3', 4, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-13 20:07:59', '2025-06-13 20:07:59', '2025-06-13 20:07:59'),
(89, 35, 'Curso_de_Prueba_v2', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-16 16:26:29', '2025-06-16 16:26:29', '2025-06-16 16:26:29'),
(90, 35, 'Curso_de_Prueba_v2', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-16 16:27:27', '2025-06-16 16:27:27', '2025-06-16 16:27:27'),
(91, 37, 'Cursos_Python', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-16 19:55:16', '2025-06-16 19:55:16', '2025-06-16 19:55:16'),
(92, 38, 'Cursos_PHP4', 4, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-16 20:20:47', '2025-06-16 20:20:47', '2025-06-16 20:20:47'),
(93, 36, 'Cursos_Laravel', 4, 'Eliminado', 'Curso desactivado por el usuario.', '2025-06-18 20:43:10', '2025-06-18 20:43:10', '2025-06-18 20:43:10'),
(94, 39, 'CursosV3', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-24 15:35:42', '2025-06-24 15:35:42', '2025-06-24 15:35:42'),
(95, 40, 'Subcurso_CursosV3_1', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-24 15:38:11', '2025-06-24 15:38:11', '2025-06-24 15:38:11'),
(96, 41, 'Curso_de_Prueba_v66', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-24 21:06:57', '2025-06-24 21:06:57', '2025-06-24 21:06:57'),
(97, 42, 'Curso_de_Prueba_v77', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 21:18:14', '2025-06-24 21:18:14', '2025-06-24 21:18:14'),
(98, 43, 'Curso_de_Prueba_v88', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 21:26:11', '2025-06-24 21:26:11', '2025-06-24 21:26:11'),
(99, 44, 'Curso_de_Prueba_v69', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 21:31:44', '2025-06-24 21:31:44', '2025-06-24 21:31:44'),
(100, 45, 'Cursos4', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 21:37:18', '2025-06-24 21:37:18', '2025-06-24 21:37:18'),
(101, 46, 'Cursos656', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 21:42:58', '2025-06-24 21:42:58', '2025-06-24 21:42:58'),
(102, 47, 'Cursos641951', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 21:46:10', '2025-06-24 21:46:10', '2025-06-24 21:46:10'),
(103, 49, 'Curso_de_Prueba_v8', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-24 23:04:28', '2025-06-24 23:04:28', '2025-06-24 23:04:28'),
(104, 57, 'Cursossddfsdfsdf', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-25 00:03:22', '2025-06-25 00:03:22', '2025-06-25 00:03:22'),
(105, 58, 'Cursostr3434434', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-25 00:17:28', '2025-06-25 00:17:28', '2025-06-25 00:17:28'),
(106, 48, 'Cursos59196', 6, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-06-25 00:19:57', '2025-06-25 00:19:57', '2025-06-25 00:19:57'),
(107, 59, 'Subcurso_Cursostr3434434_1', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-06-25 01:26:30', '2025-06-25 01:26:30', '2025-06-25 01:26:30'),
(108, 60, 'Programacion De Php', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-25 01:43:36', '2025-06-25 01:43:36', '2025-06-25 01:43:36'),
(109, 61, 'Subcurso_Programacion De Php_1', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-25 02:28:00', '2025-06-25 02:28:00', '2025-06-25 02:28:00'),
(110, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:00:37', '2025-06-25 03:00:37', '2025-06-25 03:00:37'),
(111, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:01:18', '2025-06-25 03:01:18', '2025-06-25 03:01:18'),
(112, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:05:08', '2025-06-25 03:05:08', '2025-06-25 03:05:08'),
(113, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:06:31', '2025-06-25 03:06:31', '2025-06-25 03:06:31'),
(114, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:12:40', '2025-06-25 03:12:40', '2025-06-25 03:12:40'),
(115, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:16:15', '2025-06-25 03:16:15', '2025-06-25 03:16:15'),
(116, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:17:00', '2025-06-25 03:17:00', '2025-06-25 03:17:00'),
(117, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:17:23', '2025-06-25 03:17:23', '2025-06-25 03:17:23'),
(118, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:20:44', '2025-06-25 03:20:44', '2025-06-25 03:20:44'),
(119, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:22:59', '2025-06-25 03:22:59', '2025-06-25 03:22:59'),
(120, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:23:20', '2025-06-25 03:23:20', '2025-06-25 03:23:20'),
(121, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:23:35', '2025-06-25 03:23:35', '2025-06-25 03:23:35'),
(122, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:26:33', '2025-06-25 03:26:33', '2025-06-25 03:26:33'),
(123, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 03:28:58', '2025-06-25 03:28:58', '2025-06-25 03:28:58'),
(124, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:40:20', '2025-06-25 03:40:20', '2025-06-25 03:40:20'),
(125, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:46:52', '2025-06-25 03:46:52', '2025-06-25 03:46:52'),
(126, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:54:29', '2025-06-25 03:54:29', '2025-06-25 03:54:29'),
(127, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:55:29', '2025-06-25 03:55:29', '2025-06-25 03:55:29'),
(128, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:57:19', '2025-06-25 03:57:19', '2025-06-25 03:57:19'),
(129, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:59:14', '2025-06-25 03:59:14', '2025-06-25 03:59:14'),
(130, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 03:59:41', '2025-06-25 03:59:41', '2025-06-25 03:59:41'),
(131, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 04:00:55', '2025-06-25 04:00:55', '2025-06-25 04:00:55'),
(132, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 04:03:39', '2025-06-25 04:03:39', '2025-06-25 04:03:39'),
(133, 60, 'Programacion De Php', 6, 'Editado', 'El paso 4 del curso fue actualizado.', '2025-06-25 04:04:33', '2025-06-25 04:04:33', '2025-06-25 04:04:33'),
(134, 60, 'Programacion De Php', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-06-25 04:28:31', '2025-06-25 04:28:31', '2025-06-25 04:28:31'),
(135, 60, 'Programacion De Php', 6, 'Editado', 'El paso 6 del curso fue actualizado.', '2025-06-25 17:38:44', '2025-06-25 17:38:44', '2025-06-25 17:38:44'),
(136, 60, 'Programacion De Php', 6, 'Editado', 'El paso 6 del curso fue actualizado.', '2025-06-25 17:42:29', '2025-06-25 17:42:29', '2025-06-25 17:42:29'),
(137, 60, 'Programacion De Php', 6, 'Editado', 'El paso 6 del curso fue actualizado.', '2025-06-25 17:49:18', '2025-06-25 17:49:18', '2025-06-25 17:49:18'),
(138, 60, 'Programacion De Php', 6, 'Editado', 'El paso 7 del curso fue actualizado.', '2025-06-25 18:13:17', '2025-06-25 18:13:17', '2025-06-25 18:13:17'),
(139, 60, 'Programacion De Php', 6, 'Editado', 'El paso 7 del curso fue actualizado.', '2025-06-25 18:13:59', '2025-06-25 18:13:59', '2025-06-25 18:13:59'),
(140, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 18:16:49', '2025-06-25 18:16:49', '2025-06-25 18:16:49'),
(141, 60, 'Programacion De Php', 6, 'Editado', 'El paso 3 del curso fue actualizado.', '2025-06-25 18:17:27', '2025-06-25 18:17:27', '2025-06-25 18:17:27'),
(142, 62, 'CursosV3', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-06-25 20:54:33', '2025-06-25 20:54:33', '2025-06-25 20:54:33'),
(143, 63, 'Curso_JavaS', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-07-01 21:31:32', '2025-07-01 21:31:32', '2025-07-01 21:31:32'),
(144, 64, 'Cursos_663', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-07-01 21:37:24', '2025-07-01 21:37:24', '2025-07-01 21:37:24'),
(145, 66, 'Cursos652', 6, 'Finalizado', 'Paso 7 completado. Curso guardado por el usuario.', '2025-07-02 20:40:30', '2025-07-02 20:40:30', '2025-07-02 20:40:30'),
(146, 67, 'Cursos56', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-07-02 21:21:32', '2025-07-02 21:21:32', '2025-07-02 21:21:32'),
(147, 68, 'Cursos54', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-07-02 21:22:57', '2025-07-02 21:22:57', '2025-07-02 21:22:57'),
(148, 69, 'Cursos69', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-07-02 21:38:00', '2025-07-02 21:38:00', '2025-07-02 21:38:00'),
(149, 70, 'Subcurso_Curso_JavaS_1', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-07-08 06:36:40', '2025-07-08 06:36:40', '2025-07-08 06:36:40'),
(150, 63, 'Curso_JavaS', 6, 'Editado', 'El paso 5 del curso fue actualizado.', '2025-07-08 06:55:47', '2025-07-08 06:55:47', '2025-07-08 06:55:47'),
(151, 71, 'Subcurso_Curso_JavaS_2', 6, 'Actualizado (Finalización Forzada)', 'Curso actualizado mediante finalización forzada.', '2025-07-09 21:22:38', '2025-07-09 21:22:38', '2025-07-09 21:22:38'),
(152, 63, 'Curso_JavaS', 6, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-11-19 15:06:03', '2025-11-19 15:06:03', '2025-11-19 15:06:03'),
(153, 66, 'Cursos652', 6, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-11-19 15:15:10', '2025-11-19 15:15:10', '2025-11-19 15:15:10'),
(154, 63, 'Curso_JavaS', 6, 'Editado', 'El paso 1 del curso fue actualizado.', '2025-11-19 15:59:08', '2025-11-19 15:59:08', '2025-11-19 15:59:08'),
(155, 76, 'Subcurso_Curso_JavaS_6', 6, 'Eliminado', 'Curso desactivado por el usuario.', '2026-05-13 16:38:13', '2026-05-13 16:38:13', '2026-05-13 16:38:13'),
(156, 62, 'CursosV3', 5, 'Eliminado', 'Curso desactivado por el usuario.', '2026-05-13 17:15:09', '2026-05-13 17:15:09', '2026-05-13 17:15:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `Nomenclatura` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NombredelCurso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DescripciondeCurso` text COLLATE utf8mb4_unicode_ci,
  `CostodelCurso` decimal(8,2) DEFAULT NULL,
  `InstructorResponsable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechadeInicio` date DEFAULT NULL,
  `FechadeTermino` date DEFAULT NULL,
  `Virtual` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Presencial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Mixto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Temario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Itinerario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Planeación` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Digital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Impreso_Presentable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Presentación` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Evaluación_diagnostica` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EvaluacionFinal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DC3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `FechadeRegistro_STPS` date DEFAULT NULL,
  `Formato_DC5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Certificadodecomprobacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `UDEMY` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enlace_udemy` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'https://www.udemy.com/',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `Duracioncurso` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `SinFecha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveSinFecha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveFacebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveLinkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveInstagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveTemario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveItinerario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DrivePlaneación` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveDigital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DrivedeCertificadodecomprobacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DriveCartapoder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `EvaluaciondeSatisfacción` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Formato_DC5_Tienefirma` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Cartapoder_tienefirma` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `parent_id`, `Nomenclatura`, `NombredelCurso`, `DescripciondeCurso`, `CostodelCurso`, `InstructorResponsable`, `FechadeInicio`, `FechadeTermino`, `Virtual`, `Presencial`, `Mixto`, `Facebook`, `Linkedin`, `Instagram`, `Temario`, `Itinerario`, `Planeación`, `Digital`, `Impreso_Presentable`, `Presentación`, `Evaluación_diagnostica`, `EvaluacionFinal`, `DC3`, `FechadeRegistro_STPS`, `Formato_DC5`, `Certificadodecomprobacion`, `UDEMY`, `enlace_udemy`, `status`, `Duracioncurso`, `created_at`, `updated_at`, `SinFecha`, `DriveSinFecha`, `DriveFacebook`, `DriveLinkedin`, `DriveInstagram`, `DriveTemario`, `DriveItinerario`, `DrivePlaneación`, `DriveDigital`, `DrivedeCertificadodecomprobacion`, `DriveCartapoder`, `EvaluaciondeSatisfacción`, `Formato_DC5_Tienefirma`, `Cartapoder_tienefirma`) VALUES
(60, NULL, 'CP-P00', 'Programacion De Php', 'Curso de prueba de programacion en php', '9000.00', 'Antonio', '2025-06-24', '2025-07-01', 'Si', 'Si', 'Si', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', 'Tiene DC3', '2025-06-24', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'Ya obtenida', 'Prellenado', 'https://www.udemy.com/', 1, '9 horas', '2025-06-25 01:40:08', '2025-06-25 17:38:44', '100%', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', '100%', 'Si', 'Si'),
(62, NULL, 'CP-A00', 'CursosV3', 'VUR', '9000.00', 'Antonio', '2025-06-25', '2025-07-09', 'Si', 'Si', 'Si', '100%', '100%', '100%', NULL, NULL, NULL, '100%', '100%', '100%', '100%', '100%', 'Se entrega DC3', '2025-06-25', NULL, 'Ya obtenida', 'Prellenado', 'https://www.udemy.com/', 1, '7 horas', '2025-06-25 20:47:38', '2026-05-13 17:15:21', '100%', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '100%', 'Si', 'Si'),
(63, NULL, 'CJ-J01', 'Curso_JavaS', 'Curso de Java Script', '9000.00', 'Abigail', '2025-07-09', '2025-07-16', 'Si', 'Si', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, '100%', NULL, NULL, NULL, NULL, 'Se entrega DC3', NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, '9 horas', '2025-07-01 21:05:12', '2025-11-19 15:59:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', NULL, NULL, NULL, NULL, NULL),
(64, NULL, 'CP-A00', 'Cursos_663', 'kghgj', '9000.00', 'Antonio', '2025-07-01', '2025-07-08', 'Si', 'Si', 'Si', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', '100%', 'No se entrega DC3', '2025-07-01', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'Ya obtenida', 'Prellenado', 'https://www.udemy.com/', 1, '9 horas', '2025-07-01 21:34:40', '2025-07-01 21:37:24', '100%', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', '100%', 'Si', 'Si'),
(66, NULL, 'CP-A02', 'Cursos652', 'Curso de Hacking Ético', '9000.00', 'Antonio', '2025-07-02', '2025-07-09', 'Si', 'Si', 'Si', '100%', '100%', '100%', '100%', '100%', '100%', '100%', 'Pendiente', '100%', '100%', '100%', 'Se entrega DC3', '2025-07-02', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'Ya obtenida', 'Prellenado', 'https://www.udemy.com/', 1, '9 horas', '2025-07-02 20:35:17', '2025-11-19 15:15:10', '100%', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', NULL, 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', 'https://drive.google.com/drive/folders/1EXiHdhv5G3IrDjVAR_RZjbkGG8oH3Ecw?usp=drive_link', '100%', 'Si', 'Si'),
(67, NULL, 'CP-A00', 'Cursos56', 'aasdasd', '9000.00', 'Antonio', '2025-07-02', '2025-07-09', 'Si', 'Si', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, '9 horas', '2025-07-02 21:21:10', '2025-07-02 21:21:32', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, NULL, 'CP-A00', 'Cursos54', 'asdas', '9000.00', 'Antonio', '2025-07-09', '2025-07-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, '7 horas', '2025-07-02 21:22:40', '2025-07-02 21:22:57', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, NULL, 'CP-A00', 'Cursos69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-07-02 21:37:56', '2025-07-02 21:38:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 63, '25-J01.01', 'Subcurso_Curso_JavaS_1', 'Curso de javas cript', '9000.00', 'Antonio', '2025-07-17', '2025-07-24', 'Si', 'Si', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, '9 horas', '2025-07-08 06:30:50', '2025-07-08 06:36:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 63, '25-J01.02', 'Subcurso_Curso_JavaS_2', 'Curso de javas cript', '9000.00', NULL, NULL, NULL, 'Si', 'Si', 'Si', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-07-09 21:21:25', '2025-07-09 21:22:38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 63, NULL, 'Subcurso_Curso_JavaS_3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-07-09 21:22:41', '2025-07-09 21:22:41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 63, NULL, 'Subcurso_Curso_JavaS_4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-07-09 21:45:19', '2025-07-09 21:45:19', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 63, NULL, 'Subcurso_Curso_JavaS_5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-07-09 21:46:13', '2025-07-09 21:46:13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 62, NULL, 'Subcurso_CursosV3_1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-07-09 21:46:58', '2025-07-09 21:46:58', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 63, NULL, 'Subcurso_Curso_JavaS_6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-11-19 15:04:42', '2026-05-13 16:38:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 62, NULL, 'Subcurso_CursosV3_2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-11-19 15:14:31', '2025-11-19 15:14:31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 63, NULL, 'Subcurso_Curso_JavaS_7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2025-11-19 15:58:28', '2025-11-19 15:58:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 63, NULL, 'Subcurso_Curso_JavaS_8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'https://www.udemy.com/', 1, NULL, '2026-05-13 16:47:47', '2026-05-13 16:47:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `id` bigint UNSIGNED NOT NULL,
  `participante_id` bigint UNSIGNED NOT NULL,
  `curso_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `participante_id`, `curso_id`, `created_at`, `updated_at`) VALUES
(33, 30, 62, NULL, NULL),
(34, 31, 75, NULL, NULL),
(35, 32, 70, NULL, NULL),
(36, 33, 60, NULL, NULL),
(37, 34, 63, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_14_162910_add_puesto_to_users_table', 1),
(5, '2025_01_21_172856_add_fields_to_users_table', 1),
(6, '2025_02_21_175822_create_settings_table', 1),
(7, '2025_03_03_202754_create_cursos_table', 1),
(8, '2025_03_03_203007_create_participantes_table', 1),
(9, '2025_03_03_203142_create_inscripciones_table', 1),
(10, '2025_03_03_203420_create_participant_action_logs_table', 1),
(11, '2025_03_03_203508_create_password_resets_table', 1),
(12, '2025_03_03_203644_create_password_reset_tokens_table', 2),
(13, '2025_03_03_204036_create_rutas_locales_table', 2),
(14, '2025_03_03_204324_create_course_action_logs_table', 2),
(15, '2025_03_03_204422_create_participant_action_logs_table', 3),
(16, '2025_05_27_144938_add_parent_id_to_cursos_table', 4),
(17, '2025_06_30_184939_create_personal_access_tokens_table', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participantes`
--

CREATE TABLE `participantes` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `N` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NombredelPostulante` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Correo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Edad` int DEFAULT NULL,
  `Direccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Escolaridad` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Curp` char(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `RazónSocial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Empresa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `RFCEmpresa` varchar(13) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Puesto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Pago` decimal(10,2) DEFAULT NULL,
  `EstadoDePago` enum('Pendiente','Anticipo','Pagado','Cancelado') COLLATE utf8mb4_unicode_ci DEFAULT 'Pendiente',
  `FechadelCurso` date DEFAULT NULL,
  `estatus` enum('activo','inactivo','0') COLLATE utf8mb4_unicode_ci DEFAULT 'activo',
  `Ocupacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `participantes`
--

INSERT INTO `participantes` (`id`, `created_at`, `updated_at`, `N`, `NombredelPostulante`, `Correo`, `Telefono`, `Edad`, `Direccion`, `Escolaridad`, `Curp`, `RazónSocial`, `Empresa`, `RFCEmpresa`, `Puesto`, `Pago`, `EstadoDePago`, `FechadelCurso`, `estatus`, `Ocupacion`) VALUES
(30, '2025-11-13 18:29:03', '2026-05-13 16:59:30', 'IC-250001', 'Bryan Ezequiel Espinoza Alva', 'bryanespinoza@gmail.com', '3315487956', 25, 'Puerto', 'Nivel Superior', 'ELO903LD8IDKE0D8DK', 'Prueba de Software', 'IDEB Soporte y Servicios', 'A64RJFK39DK3', 'Desarrollador de Softaware', '200.00', 'Anticipo', '2025-06-25', 'activo', '06.2 Autotransporte'),
(31, '2025-11-18 16:14:11', '2025-11-18 16:14:11', 'IC-250002', 'Melissa Guadalupe Espinoza Alva', 'participanteprueba2@ideb.com', '3385965698', 21, 'Guaymas 67E', 'Superior', 'MEA935UJKW9204KE83', 'Operación 1', 'IDEB Soporte y Servicios', 'A64RJFK39DK3', 'Capital Humano', '987.00', 'Pagado', NULL, 'activo', '08 Gestión y soporte administrativo'),
(32, '2025-11-18 16:54:00', '2025-11-18 16:54:00', 'IC-250003', 'Fabiola Esmeralda Flores Alva', 'fabiolaprueba@ideb.com', '3365987458', 27, 'Allende 56', 'Licenciatura', 'FEEF980WIEKD0LWD99', 'Prueba de error 404', 'IDEB Soporte y Servicios', 'A64RJFK39DK3', 'Desarrollador de Softaware', NULL, 'Pendiente', '2025-07-17', 'activo', 'Programador'),
(33, '2025-11-19 14:19:42', '2025-11-19 14:19:42', 'IC-250004', 'Everardo López Alva', 'Victor@ideb.com', '3345789625', 45, 'Independencia 1345', 'Media Superior', 'ELA007SJEU89OKWUD7', 'Prueba de Software 1.1', 'IDEB Soporte y Servicios', 'A64RJFK39DK3', 'Capital Humano', '1000.00', 'Pagado', '2025-06-24', 'activo', 'Capital Humano'),
(34, '2025-11-19 14:33:45', '2025-11-19 14:33:45', 'IC-250005', 'Cecilia Flores Rivera', 'CeciPrueba@ideb.com', '3356897458', 44, 'Allende 456', 'Preparatoria', 'CFR770ERT65UFJ49RK', 'Prueba de error 404', 'IDEB Soporte y Servicios', 'A64RJFK39DK3', 'Capital Humano', NULL, 'Pendiente', '2025-07-09', 'activo', '01.1 Agricultura y silvicultura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participant_action_logs`
--

CREATE TABLE `participant_action_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `participant_id` bigint UNSIGNED DEFAULT NULL,
  `nombre_postulante` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `detalles` text COLLATE utf8mb4_unicode_ci,
  `fecha_accion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `participant_action_logs`
--

INSERT INTO `participant_action_logs` (`id`, `participant_id`, `nombre_postulante`, `correo`, `accion`, `user_id`, `detalles`, `fecha_accion`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jose Antonio Garcia Carbajal', '2123100581@soy.utj.edu.mx', 'Editado', 6, 'Datos del participante actualizados.', '2025-06-11 18:17:22', '2025-06-11 18:17:22', '2025-06-11 18:17:22'),
(2, 2, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Editado', 6, 'Datos del participante actualizados.', '2025-06-13 17:55:11', '2025-06-13 17:55:11', '2025-06-13 17:55:11'),
(3, 5, 'Stephany Abigail Ceciliano Caballero', 'angameljr@gmail.com', 'Eliminado', 6, 'Participante desactivado.', '2025-06-13 19:17:10', '2025-06-13 19:17:10', '2025-06-13 19:17:10'),
(4, 5, 'Stephany Abigail Ceciliano Caballero', 'angameljr@gmail.com', 'Activado', 4, 'Participante activado nuevamente.', '2025-06-13 19:58:32', '2025-06-13 19:58:32', '2025-06-13 19:58:32'),
(5, 4, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Eliminado', 4, 'Participante desactivado.', '2025-06-13 19:59:57', '2025-06-13 19:59:57', '2025-06-13 19:59:57'),
(6, 2, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Eliminado', 4, 'Participante desactivado.', '2025-06-13 20:00:30', '2025-06-13 20:00:30', '2025-06-13 20:00:30'),
(7, 1, 'Jose Antonio Garcia Carbajal', '2123100581@soy.utj.edu.mx', 'Eliminado', 4, 'Participante desactivado.', '2025-06-13 20:05:10', '2025-06-13 20:05:10', '2025-06-13 20:05:10'),
(8, 2, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Activado', 4, 'Participante activado nuevamente.', '2025-06-13 20:05:31', '2025-06-13 20:05:31', '2025-06-13 20:05:31'),
(9, 1, 'Jose Antonio Garcia Carbajal', '2123100581@soy.utj.edu.mx', 'Activado', 4, 'Participante activado nuevamente.', '2025-06-13 20:05:34', '2025-06-13 20:05:34', '2025-06-13 20:05:34'),
(10, 1, 'Jose Antonio Garcia Carbajal', '2123100581@soy.utj.edu.mx', 'Eliminado', 4, 'Participante desactivado.', '2025-06-16 18:27:47', '2025-06-16 18:27:47', '2025-06-16 18:27:47'),
(11, 2, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Eliminado', 4, 'Participante desactivado.', '2025-06-16 18:27:51', '2025-06-16 18:27:51', '2025-06-16 18:27:51'),
(12, 15, 'Stephany Abigail Ceciliano Caballero', 'angameljr@gmail.com', 'Editado', 4, 'Datos del participante actualizados.', '2025-06-16 21:03:05', '2025-06-16 21:03:05', '2025-06-16 21:03:05'),
(13, 4, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Activado', 6, 'Participante activado nuevamente.', '2025-06-24 15:42:12', '2025-06-24 15:42:12', '2025-06-24 15:42:12'),
(14, 2, 'Jose Antonio Garcia Carbajal', 'angameljr@gmail.com', 'Activado', 6, 'Participante activado nuevamente.', '2025-06-24 15:42:33', '2025-06-24 15:42:33', '2025-06-24 15:42:33'),
(15, 1, 'Jose Antonio Garcia Carbajal', '2123100581@soy.utj.edu.mx', 'Activado', 6, 'Participante activado nuevamente.', '2025-06-24 15:42:39', '2025-06-24 15:42:39', '2025-06-24 15:42:39'),
(16, 19, 'Stephany Abigail Ceciliano Caballero', 'angameljr@gmail.com', 'Editado', 6, 'Datos del participante actualizados.', '2025-07-02 21:27:26', '2025-07-02 21:27:26', '2025-07-02 21:27:26'),
(17, 16, 'Stephany Abigail Ceciliano Caballero', 'angameljr@gmail.com', 'Editado', 6, 'Datos del participante actualizados.', '2025-07-02 21:27:34', '2025-07-02 21:27:34', '2025-07-02 21:27:34'),
(18, 16, 'Stephany Abigail Ceciliano Caballero', 'angameljr@gmail.com', 'Editado', 6, 'Datos del participante actualizados.', '2025-07-02 21:27:40', '2025-07-02 21:27:40', '2025-07-02 21:27:40'),
(19, 30, 'Bryan Ezequiel Espinoza Alva', 'bryanespinoza@gmail.com', 'Editado', 6, 'Datos del participante actualizados.', '2026-05-13 16:59:19', '2026-05-13 16:59:19', '2026-05-13 16:59:19'),
(20, 30, 'Bryan Ezequiel Espinoza Alva', 'bryanespinoza@gmail.com', 'Editado', 6, 'Datos del participante actualizados.', '2026-05-13 16:59:30', '2026-05-13 16:59:30', '2026-05-13 16:59:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas_locales`
--

CREATE TABLE `rutas_locales` (
  `id` bigint UNSIGNED NOT NULL,
  `id_cursos` bigint UNSIGNED DEFAULT NULL,
  `nombre_carpeta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruta_nombre_carpeta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rutacompleta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rutaformatosflyer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaSinFecha` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaFacebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaLinkedIn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaInstagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaTemario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaItinerario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaPlaneacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaMaterialdeapoyo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutacursoenlinea` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutapresentacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaevaluaciones` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaEvaluacionDiagnostica` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaEvaluacionSatisfaccion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaEvaluacionFinal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaDC5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutacarpetaDC5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaCertificadoComprobacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutacartapoder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rutaUdemy` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rutas_locales`
--

INSERT INTO `rutas_locales` (`id`, `id_cursos`, `nombre_carpeta`, `ruta_nombre_carpeta`, `rutacompleta`, `rutaformatosflyer`, `rutaSinFecha`, `rutaFacebook`, `rutaLinkedIn`, `rutaInstagram`, `rutaTemario`, `rutaItinerario`, `rutaPlaneacion`, `rutaMaterialdeapoyo`, `rutacursoenlinea`, `rutapresentacion`, `rutaevaluaciones`, `rutaEvaluacionDiagnostica`, `rutaEvaluacionSatisfaccion`, `rutaEvaluacionFinal`, `rutaDC5`, `rutacarpetaDC5`, `rutaCertificadoComprobacion`, `rutacartapoder`, `rutaUdemy`, `created_at`, `updated_at`) VALUES
(63, 60, 'Programacion De Php', 'C:\\Users\\angam\\OneDrive\\Escritorio\\Cursos', 'C:\\Users\\angam\\OneDrive\\Escritorio\\Cursos\\Programacion De Php', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/7- Flyers del Curso', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/7- Flyers del Curso/SinFecha/1750875409_Fortnite Screenshot 2025.06.08 - 15.48.27.03.Victoria.png', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/7- Flyers del Curso/Facebook/1750875447_Fortnite Screenshot 2025.06.17 - 23.45.30.09.Victoria.png', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/7- Flyers del Curso/LinkedIn/1750875447_Fortnite Screenshot 2025.06.17 - 23.45.30.09.Victoria.png', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/7- Flyers del Curso/Instagram/1750875447_Fortnite Screenshot 2024.12.31 - 17.43.19.76.Victoria.png', '1-Temario/1750824055_Fortnite Screenshot 2025.06.17 - 23.45.30.09.Victoria.png', '6-Itinerario/1750824273_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '3-Planeación/1750824273_Fortnite Screenshot 2025.05.11 - 00.09.06.59.Victoria.png', '2- Material de Apoyo (Digital)/1750825711_digital_Fortnite Screenshot 2025.06.17 - 23.45.30.09.Victoria.png', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php\\8- Curso en Linea', '4- Presentacion/1750873758_presentacion_Fortnite Screenshot 2025.06.17 - 23.45.30.09.Victoria.png', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/5- Evaluaciones', '5- Evaluaciones/EvaluacionDiagnostica/1750873758_evaluacion_diagnostica_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '5- Evaluaciones/EvaluacionSatisfaccion/1750873758_evaluacion_satisfaccion_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '5- Evaluaciones/EvaluacionFinal/1750873758_evaluacion_final_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/0- DC5', '0- DC5/FormatoDC5/1750875239_formatodc5_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '0- DC5/CertificadoComprobacion/1750875239_certificadocomprobacion_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '0- DC5/CartaPoder/1750875239_cartapoder_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '0- DC5/UDEMY/1750875239_udemy_Fortnite Screenshot 2025.06.17 - 22.51.09.64.Victoria.png', '2025-06-25 01:40:04', '2025-06-25 18:17:27'),
(64, 61, 'Subcurso_Programacion De Php_1', 'C:\\Users\\angam\\OneDrive\\Escritorio\\Cursos\\Programacion De Php', 'C:\\Users\\angam\\OneDrive\\Escritorio\\Cursos\\Programacion De Php\\Subcurso_Programacion De Php_1', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/7- Flyers del Curso', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/7- Flyers del Curso/SinFecha', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/7- Flyers del Curso/Facebook', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/7- Flyers del Curso/Instagram', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/1-Temario', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/6-Itinerario', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/3-Planeación', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1\\2- Material de Apoyo (Digital)', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1\\8- Curso en Linea', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/4- Presentacion', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/5- Evaluaciones', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/5- Evaluaciones/EvaluacionDiagnostica', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/5- Evaluaciones/EvaluacionSatisfaccion', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/Subcurso_Programacion De Php_1/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/0- DC5', NULL, 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/0- DC5/CertificadoComprobacion', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/0- DC5/CartaPoder', 'C:/Users/angam/OneDrive/Escritorio/Cursos/Programacion De Php/0- DC5/UDEMY', '2025-06-25 01:45:35', '2025-06-25 02:27:37'),
(65, 62, 'CursosV3', 'C:\\Users\\angam\\Cursos', 'C:\\Users\\angam\\Cursos\\CursosV3', 'C:/Users/angam/Cursos/CursosV3/7- Flyers del Curso', 'C:/Users/angam/Cursos/CursosV3/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Cursos/CursosV3/7- Flyers del Curso/Facebook', 'C:/Users/angam/Cursos/CursosV3/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Cursos/CursosV3/7- Flyers del Curso/Instagram', 'C:/Users/angam/Cursos/CursosV3/1-Temario', 'C:/Users/angam/Cursos/CursosV3/6-Itinerario', 'C:/Users/angam/Cursos/CursosV3/3-Planeación', 'C:/Users/angam/Cursos/CursosV3\\2- Material de Apoyo (Digital)', 'C:/Users/angam/Cursos/CursosV3\\8- Curso en Linea', 'C:/Users/angam/Cursos/CursosV3/4- Presentacion', 'C:/Users/angam/Cursos/CursosV3/5- Evaluaciones', 'C:/Users/angam/Cursos/CursosV3/5- Evaluaciones/EvaluacionDiagnostica', 'C:/Users/angam/Cursos/CursosV3/5- Evaluaciones/EvaluacionSatisfaccion', 'C:/Users/angam/Cursos/CursosV3/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Cursos/CursosV3/0- DC5', NULL, 'C:/Users/angam/Cursos/CursosV3/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Cursos/CursosV3/0- DC5/CartaPoder', 'C:/Users/angam/Cursos/CursosV3/0- DC5/UDEMY', '2025-06-25 20:47:34', '2025-06-25 20:54:26'),
(66, 63, 'Curso_JavaS', 'C:\\Users\\angam', 'C:\\Users\\angam\\Curso_JavaS', 'C:/Users/angam/Curso_JavaS/7- Flyers del Curso', 'C:/Users/angam/Curso_JavaS/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Curso_JavaS/7- Flyers del Curso/Facebook', 'C:/Users/angam/Curso_JavaS/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Curso_JavaS/7- Flyers del Curso/Instagram', 'C:/Users/angam/Curso_JavaS/1-Temario', 'C:/Users/angam/Curso_JavaS/6-Itinerario', 'C:/Users/angam/Curso_JavaS/3-Planeación', 'C:/Users/angam/Curso_JavaS\\2- Material de Apoyo (Digital)', 'C:/Users/angam/Curso_JavaS\\8- Curso en Linea', 'C:/Users/angam/Curso_JavaS/4- Presentacion', 'C:/Users/angam/Curso_JavaS/5- Evaluaciones', 'C:/Users/angam/Curso_JavaS/5- Evaluaciones/EvaluacionDiagnostica', 'C:/Users/angam/Curso_JavaS/5- Evaluaciones/EvaluacionSatisfaccion', 'C:/Users/angam/Curso_JavaS/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-07-01 21:05:10', '2025-07-01 21:26:01'),
(67, 64, 'Cursos_663', 'C:\\Users\\angam', 'C:\\Users\\angam\\Cursos_663', 'C:/Users/angam/Cursos_663/7- Flyers del Curso', 'C:/Users/angam/Cursos_663/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Cursos_663/7- Flyers del Curso/Facebook', 'C:/Users/angam/Cursos_663/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Cursos_663/7- Flyers del Curso/Instagram', 'C:/Users/angam/Cursos_663/1-Temario', 'C:/Users/angam/Cursos_663/6-Itinerario', 'C:/Users/angam/Cursos_663/3-Planeación', 'C:/Users/angam/Cursos_663\\2- Material de Apoyo (Digital)', 'C:/Users/angam/Cursos_663\\8- Curso en Linea', 'C:/Users/angam/Cursos_663/4- Presentacion', 'C:/Users/angam/Cursos_663/5- Evaluaciones', 'C:/Users/angam/Cursos_663/5- Evaluaciones/EvaluacionDiagnostica', 'C:/Users/angam/Cursos_663/5- Evaluaciones/EvaluacionSatisfaccion', 'C:/Users/angam/Cursos_663/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Cursos_663/0- DC5', NULL, 'C:/Users/angam/Cursos_663/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Cursos_663/0- DC5/CartaPoder', 'C:/Users/angam/Cursos_663/0- DC5/UDEMY', '2025-07-01 21:34:28', '2025-07-01 21:37:14'),
(68, 65, 'Cursos_V2', 'C:\\Users\\angam', 'C:\\Users\\angam\\Cursos_V2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 20:34:09', '2025-07-02 20:34:11'),
(69, 66, 'Cursos652', 'C:\\Users\\angam', 'C:\\Users\\angam\\Cursos652', 'C:/Users/angam/Cursos652/7- Flyers del Curso', 'C:/Users/angam/Cursos652/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Cursos652/7- Flyers del Curso/Facebook', 'C:/Users/angam/Cursos652/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Cursos652/7- Flyers del Curso/Instagram', 'C:/Users/angam/Cursos652/1-Temario', 'C:/Users/angam/Cursos652/6-Itinerario', 'C:/Users/angam/Cursos652/3-Planeación', 'C:/Users/angam/Cursos652\\2- Material de Apoyo (Digital)', 'C:/Users/angam/Cursos652\\8- Curso en Linea', 'C:/Users/angam/Cursos652/4- Presentacion', 'C:/Users/angam/Cursos652/5- Evaluaciones', 'C:/Users/angam/Cursos652/5- Evaluaciones/EvaluacionDiagnostica', 'C:/Users/angam/Cursos652/5- Evaluaciones/EvaluacionSatisfaccion', 'C:/Users/angam/Cursos652/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Cursos652/0- DC5', NULL, 'C:/Users/angam/Cursos652/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Cursos652/0- DC5/CartaPoder', 'C:/Users/angam/Cursos652/0- DC5/UDEMY', '2025-07-02 20:35:14', '2025-07-02 20:40:22'),
(70, 67, 'Cursos56', 'C:\\Users\\angam', 'C:\\Users\\angam\\Cursos56', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 21:21:08', '2025-07-02 21:21:10'),
(71, 68, 'Cursos54', 'C:\\Users\\angam', 'C:\\Users\\angam\\Cursos54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 21:22:38', '2025-07-02 21:22:40'),
(72, 69, 'Cursos69', 'C:\\Users\\angam', 'C:\\Users\\angam\\Cursos69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 21:37:54', '2025-07-02 21:37:56'),
(73, 70, 'Subcurso_Curso_JavaS_1', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_1/7- Flyers del Curso', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_1/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_1/7- Flyers del Curso/Facebook', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_1/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_1/7- Flyers del Curso/Instagram', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\1-Temario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\3-Planeación', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\5- Evaluaciones\\EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\5- Evaluaciones\\EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_1\\5- Evaluaciones\\EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-07-08 06:30:50', '2025-07-08 06:31:35'),
(74, 71, 'Subcurso_Curso_JavaS_2', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_2/7- Flyers del Curso', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_2/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_2/7- Flyers del Curso/Facebook', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_2/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_2/7- Flyers del Curso/Instagram', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\1-Temario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\3-Planeación', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\5- Evaluaciones\\EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\5- Evaluaciones\\EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_2\\5- Evaluaciones\\EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-07-09 21:21:25', '2025-07-09 21:21:35'),
(75, 72, 'Subcurso_Curso_JavaS_3', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\1-Temario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\3-Planeación', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\5- Evaluaciones\\EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\5- Evaluaciones\\EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_3\\5- Evaluaciones\\EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-07-09 21:22:40', '2025-07-09 21:22:41'),
(76, 73, 'Subcurso_Curso_JavaS_4', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_4/7- Flyers del Curso', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_4/7- Flyers del Curso/SinFecha', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_4/7- Flyers del Curso/Facebook', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_4/7- Flyers del Curso/LinkedIn', 'C:/Users/angam/Curso_JavaS/Subcurso_Curso_JavaS_4/7- Flyers del Curso/Instagram', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\1-Temario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\3-Planeación', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\5- Evaluaciones\\EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\5- Evaluaciones\\EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_4\\5- Evaluaciones\\EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-07-09 21:45:19', '2025-07-09 21:45:26'),
(77, 74, 'Subcurso_Curso_JavaS_5', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\1-Temario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\3-Planeación', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\5- Evaluaciones\\EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\5- Evaluaciones\\EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS\\Subcurso_Curso_JavaS_5\\5- Evaluaciones\\EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-07-09 21:46:12', '2025-07-09 21:46:13'),
(78, 75, 'Subcurso_CursosV3_1', 'C:\\Users\\angam\\Cursos\\CursosV3', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\1-Temario', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\6-Itinerario', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\3-Planeación', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\8- Curso en Linea', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\4- Presentacion', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\5- Evaluaciones', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\5- Evaluaciones\\EvaluacionDiagnostica', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\5- Evaluaciones\\EvaluacionSatisfaccion', 'C:\\Users\\angam\\Cursos\\CursosV3\\Subcurso_CursosV3_1\\5- Evaluaciones\\EvaluacionFinal', 'C:/Users/angam/Cursos/CursosV3/0- DC5', NULL, 'C:/Users/angam/Cursos/CursosV3/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Cursos/CursosV3/0- DC5/CartaPoder', 'C:/Users/angam/Cursos/CursosV3/0- DC5/UDEMY', '2025-07-09 21:46:58', '2025-07-09 21:46:58'),
(79, 76, 'Subcurso_Curso_JavaS_6', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/1-Temario', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/3-Planeación', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/5- Evaluaciones/EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/5- Evaluaciones/EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_6/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-11-19 15:04:42', '2025-11-19 15:04:42'),
(80, 77, 'Subcurso_CursosV3_2', 'C:\\Users\\angam\\Cursos\\CursosV3', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/1-Temario', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/6-Itinerario', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/3-Planeación', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/8- Curso en Linea', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/4- Presentacion', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/5- Evaluaciones', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/5- Evaluaciones/EvaluacionDiagnostica', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/5- Evaluaciones/EvaluacionSatisfaccion', 'C:\\Users\\angam\\Cursos\\CursosV3/Subcurso_CursosV3_2/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Cursos/CursosV3/0- DC5', NULL, 'C:/Users/angam/Cursos/CursosV3/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Cursos/CursosV3/0- DC5/CartaPoder', 'C:/Users/angam/Cursos/CursosV3/0- DC5/UDEMY', '2025-11-19 15:14:31', '2025-11-19 15:14:31'),
(81, 78, 'Subcurso_Curso_JavaS_7', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/1-Temario', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/3-Planeación', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/5- Evaluaciones/EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/5- Evaluaciones/EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_7/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2025-11-19 15:58:28', '2025-11-19 15:58:28'),
(82, 79, 'Subcurso_Curso_JavaS_8', 'C:\\Users\\angam\\Curso_JavaS', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8', NULL, NULL, NULL, NULL, NULL, 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/1-Temario', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/6-Itinerario', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/3-Planeación', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/2- Material de Apoyo (Digital)', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/8- Curso en Linea', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/4- Presentacion', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/5- Evaluaciones', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/5- Evaluaciones/EvaluacionDiagnostica', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/5- Evaluaciones/EvaluacionSatisfaccion', 'C:\\Users\\angam\\Curso_JavaS/Subcurso_Curso_JavaS_8/5- Evaluaciones/EvaluacionFinal', 'C:/Users/angam/Curso_JavaS/0- DC5', NULL, 'C:/Users/angam/Curso_JavaS/0- DC5/CertificadoComprobacion', 'C:/Users/angam/Curso_JavaS/0- DC5/CartaPoder', 'C:/Users/angam/Curso_JavaS/0- DC5/UDEMY', '2026-05-13 16:47:47', '2026-05-13 16:47:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0ALcDi5PoXEAX6AYalIgGk8vmQY7TFr57iXvwQjb', 6, '2806:2f0:50a0:f898:2506:2776:e5b8:4448', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN2VpSERac1g4MFlnSWZ6bnMwbWNjTmh6S2JLa3dDU1FvQ2E5dGM2eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHBzOi8vZXJwY3Vyc29zLmlkZWJtZXhpY28uY29tL29idGVuZXItdG9kYXMtbGFzLXJ1dGFzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1778866279);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `settings`
--

INSERT INTO `settings` (`id`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'logos/CBKRI4i12BBAAcaz6ZEL0m97aVmriGQfMUWI4eJB.png', '2026-05-13 16:39:50', '2026-05-13 16:41:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edad` int DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puesto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plain_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `apellido`, `edad`, `telefono`, `email`, `puesto`, `email_verified_at`, `password`, `plain_password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'Prueba', 20, '3333333334', 'AdminPrueba@gmail.com', 'Mantenimiento', NULL, '$2y$12$Xbe8rq2ZVje1Izk3.vQSDe5A05ShmPRf7.2javUGGRbNR0WgJ/p1e', 'Prueba123', NULL, '2025-05-26 17:04:08', '2025-11-18 16:05:06'),
(3, 'Admin', 'Operacion', 20, '3333333333', 'AdminOperacion@gmail.com', 'Operacion', NULL, '$2y$12$kmkLzz8dVSCN.du/r1X46.kD0ikd8efnFpspiqYkecdZs1qck8M52', 'Operacion123', NULL, '2025-05-26 17:20:01', '2025-05-26 17:20:01'),
(4, 'Admin3', 'Mantenimiento', 20, '3333333333', 'AdminProgramador@gmail.com', 'Programador', NULL, '$2y$12$y2GGpbi1T533QUSOsOFPE.bqE6o/uGtB49Sd.fNAIjY5Gwpk8/Ofm', 'Programador', NULL, '2025-05-26 17:23:53', '2026-05-13 17:11:31'),
(5, 'Programador', 'Dos', 20, '3333333333', 'AdminProgramador2@gmail.com', 'Programador', NULL, '$2y$12$Em2NfJyTBLcRTb/54HcLZuZlHFP3bvNmXDEdrURG2royxSBow8taK', 'Programador2', NULL, '2025-05-30 17:45:26', '2025-05-30 17:45:26'),
(6, 'Jose Antonio', 'García Carbajal', 33, '3326261778', 'AdminAdministrador@gmail.com', 'Administrador', NULL, '$2y$12$Xdf2s4tLBc2wRPuI3gTk4.SNpu0Z6g0Q/38f4HPXgKGbGEk7E5Ifa', 'Administrador', NULL, '2025-06-06 17:34:48', '2026-05-13 15:41:33'),
(7, 'Ivan', 'Pintor', 35, '3316897626', 'ivanpintor.ideb@gmail.com', 'Programador', NULL, '$2y$12$BQEk1S60fQlfU55w3zuMBOQQyaTFLvxDkQbV1dA/Vqepddi9ZSSaa', 'ivanpintor.ideb@gmail.com	', NULL, '2025-11-14 17:33:50', '2025-11-14 17:33:50');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `course_action_logs`
--
ALTER TABLE `course_action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cursos_parent_id_foreign` (`parent_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inscripciones_participante_id_foreign` (`participante_id`),
  ADD KEY `inscripciones_curso_id_foreign` (`curso_id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `participant_action_logs`
--
ALTER TABLE `participant_action_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD KEY `password_reset_tokens_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `rutas_locales`
--
ALTER TABLE `rutas_locales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `course_action_logs`
--
ALTER TABLE `course_action_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `participant_action_logs`
--
ALTER TABLE `participant_action_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rutas_locales`
--
ALTER TABLE `rutas_locales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inscripciones_participante_id_foreign` FOREIGN KEY (`participante_id`) REFERENCES `participantes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
