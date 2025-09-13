-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 13 2025 г., 11:55
-- Версия сервера: 8.0.30
-- Версия PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shopLaravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE `addresses` (
  `idAddress` bigint UNSIGNED NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `houseNumber` int DEFAULT NULL,
  `apartmentNumber` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `brends`
--

CREATE TABLE `brends` (
  `idBrend` bigint UNSIGNED NOT NULL,
  `brend` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brends`
--

INSERT INTO `brends` (`idBrend`, `brend`, `created_at`, `updated_at`) VALUES
(1, 'Rolex', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(2, 'Cartier', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(3, 'Citizen', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(4, 'Orient', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(5, 'Festina', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(6, 'Ingersoll', '2025-08-22 16:11:00', '2025-08-22 16:11:00');

-- --------------------------------------------------------

--
-- Структура таблицы `buyers`
--

CREATE TABLE `buyers` (
  `idBuyer` bigint UNSIGNED NOT NULL,
  `googleId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pib` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idAddress` bigint UNSIGNED DEFAULT NULL,
  `idNovaPost` bigint UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `buyers`
--

INSERT INTO `buyers` (`idBuyer`, `googleId`, `pib`, `number`, `email`, `idAddress`, `idNovaPost`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '104932855901383120133', 'Назаренко Назар Назарович', '+380666666666', 'gfdrfrfdfg@gmail.com', NULL, 1, NULL, '$2y$12$Rm5Dd1FlwWTlfa7buktH1.wobzCv/Wi7Df0ZINSkSLTusfUfSp7h6', NULL, '2025-08-22 16:11:00', '2025-09-13 05:51:18');

-- --------------------------------------------------------

--
-- Структура таблицы `buyers_password_reset_tokens`
--

CREATE TABLE `buyers_password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
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

--
-- Дамп данных таблицы `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, 'a9233c7b-6d80-4c8e-ad32-9b1c9109a601', 'database', 'default', '{\"uuid\":\"a9233c7b-6d80-4c8e-ad32-9b1c9109a601\",\"displayName\":\"App\\\\Notifications\\\\BuyerVerifyEmailNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":3:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Buyer\\\";s:2:\\\"id\\\";a:1:{i:0;i:3;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:46:\\\"App\\\\Notifications\\\\BuyerVerifyEmailNotification\\\":1:{s:2:\\\"id\\\";s:36:\\\"0a7e3399-5858-43d0-99e5-e11ca72a2840\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}}\"}}', 'Symfony\\Component\\Mailer\\Exception\\UnexpectedResponseException: Expected response code \"354\" but got code \"550\", with message \"550 5.7.0 Too many emails per second. Please upgrade your plan https://mailtrap.io/billing/plans/testing\". in D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php:342\nStack trace:\n#0 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(198): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->assertResponseCode()\n#1 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(134): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->executeCommand()\n#2 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(220): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand()\n#3 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend()\n#4 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send()\n#5 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(585): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send()\n#6 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(332): Illuminate\\Mail\\Mailer->sendSymfonyMessage()\n#7 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(67): Illuminate\\Mail\\Mailer->send()\n#8 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(148): Illuminate\\Notifications\\Channels\\MailChannel->send()\n#9 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(106): Illuminate\\Notifications\\NotificationSender->sendToNotifiable()\n#10 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->Illuminate\\Notifications\\{closure}()\n#11 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(101): Illuminate\\Notifications\\NotificationSender->withLocale()\n#12 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow()\n#13 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(119): Illuminate\\Notifications\\ChannelManager->sendNow()\n#14 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle()\n#15 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#16 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure()\n#17 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#18 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#19 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(126): Illuminate\\Container\\Container->call()\n#20 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(170): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#21 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(127): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#22 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(130): Illuminate\\Pipeline\\Pipeline->then()\n#23 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(126): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#24 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(170): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#25 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(127): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#26 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(121): Illuminate\\Pipeline\\Pipeline->then()\n#27 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(69): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#28 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#29 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(442): Illuminate\\Queue\\Jobs\\Job->fire()\n#30 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(392): Illuminate\\Queue\\Worker->process()\n#31 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(178): Illuminate\\Queue\\Worker->runJob()\n#32 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(149): Illuminate\\Queue\\Worker->daemon()\n#33 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(132): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#34 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#35 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#36 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(95): Illuminate\\Container\\Util::unwrapIfClosure()\n#37 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#38 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(754): Illuminate\\Container\\BoundMethod::call()\n#39 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(213): Illuminate\\Container\\Container->call()\n#40 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\console\\Command\\Command.php(279): Illuminate\\Console\\Command->execute()\n#41 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(182): Symfony\\Component\\Console\\Command\\Command->run()\n#42 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\console\\Application.php(1094): Illuminate\\Console\\Command->run()\n#43 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\console\\Application.php(342): Symfony\\Component\\Console\\Application->doRunCommand()\n#44 D:\\OSPanel\\domains\\shopLaravel\\vendor\\symfony\\console\\Application.php(193): Symfony\\Component\\Console\\Application->doRun()\n#45 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run()\n#46 D:\\OSPanel\\domains\\shopLaravel\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#47 D:\\OSPanel\\domains\\shopLaravel\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#48 {main}', '2025-09-12 16:21:22');

-- --------------------------------------------------------

--
-- Структура таблицы `genders`
--

CREATE TABLE `genders` (
  `idGender` bigint UNSIGNED NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `genders`
--

INSERT INTO `genders` (`idGender`, `gender`, `created_at`, `updated_at`) VALUES
(1, 'Чоловічі', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(2, 'Жіночі', '2025-08-22 16:11:00', '2025-08-22 16:11:00');

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
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
-- Структура таблицы `job_batches`
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
-- Структура таблицы `mechanisms`
--

CREATE TABLE `mechanisms` (
  `idMechanism` bigint UNSIGNED NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `mechanisms`
--

INSERT INTO `mechanisms` (`idMechanism`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Механічні', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(2, 'Кварцові', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(3, 'Smart-годинники', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(4, 'Автопідзавод', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(5, 'Годинник-хронометр', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(7, 'Кінетик', '2025-08-22 16:11:00', '2025-08-22 16:11:00');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_27_094346_create_brends_table', 1),
(5, '2025_02_27_094500_create_mechanisms_table', 1),
(6, '2025_02_27_094522_create_genders_table', 1),
(7, '2025_02_27_094552_create_styles_table', 1),
(8, '2025_03_02_113414_create_watches_table', 1),
(9, '2025_03_02_113449_create_photos_table', 1),
(10, '2025_05_22_105225_create_addresses_table', 1),
(11, '2025_05_22_141946_create_nova_post_addresses_table', 1),
(12, '2025_05_22_163026_create_promo_codes_table', 1),
(13, '2025_05_23_135147_create_buyers_table', 1),
(14, '2025_05_24_105000_create_orders_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `nova_post_addresses`
--

CREATE TABLE `nova_post_addresses` (
  `idNovaPost` bigint UNSIGNED NOT NULL,
  `cityRef` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `nova_post_addresses`
--

INSERT INTO `nova_post_addresses` (`idNovaPost`, `cityRef`, `city`, `warehouse`, `created_at`, `updated_at`) VALUES
(1, '8d5a980d-391c-11dd-90d9-001a92567626', 'Київ', 'Відділення №3 (до 30 кг на одне місце): вул. Слобожанська,13', '2025-09-04 11:48:43', '2025-09-13 05:47:36');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `idOrder` bigint UNSIGNED NOT NULL,
  `numberOrder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idBuyer` bigint UNSIGNED NOT NULL,
  `watches` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idPayment` bigint UNSIGNED DEFAULT NULL,
  `payment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `paymentStatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `koment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `idPromoCode` bigint UNSIGNED DEFAULT NULL,
  `orderStatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`idOrder`, `numberOrder`, `idBuyer`, `watches`, `delivery`, `idPayment`, `payment`, `paymentStatus`, `koment`, `idPromoCode`, `orderStatus`, `created_at`, `updated_at`) VALUES
(1, '68ADB1CD5EC89', 1, '[{\"id\":2,\"kolvo\":1}]', 'pickup', 2700488716, 'liqPay', '2', NULL, NULL, '1', '2025-09-01 14:25:27', '2025-09-11 16:44:51'),
(2, '68B6128D5A8A3', 1, '[{\"id\":2,\"kolvo\":1}]', 'pickup', NULL, 'liqPay', '2', NULL, NULL, '2', '2025-09-01 18:39:25', '2025-09-01 18:39:25'),
(3, '68B8729E5AD8B', 1, '[{\"id\":2,\"kolvo\":\"1\"},{\"id\":3,\"kolvo\":\"4\"},{\"id\":1,\"kolvo\":\"2\"}]', 'pickup', NULL, 'cash', '2', NULL, NULL, '1', '2025-09-03 13:53:50', '2025-09-03 13:53:50'),
(4, '68B9A6D53D736', 1, '[{\"id\":19,\"kolvo\":1},{\"id\":20,\"kolvo\":1},{\"id\":4,\"kolvo\":1}]', 'nova_post', NULL, 'cash', '2', NULL, 1, '1', '2025-09-04 11:48:53', '2025-09-04 11:48:53');

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `photos`
--

CREATE TABLE `photos` (
  `idPhoto` bigint UNSIGNED NOT NULL,
  `idWatch` bigint UNSIGNED NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `photos`
--

INSERT INTO `photos` (`idPhoto`, `idWatch`, `photo`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '/storage/photos/cKnCgByJGieoO30KsYwphbe0GXDhzcJPfxNTHyGX.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(3, 1, '/storage/photos/fjob65yBIB6Llsc96cLKC78D8DsUEbzYgFtpKOUu.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(4, 1, '/storage/photos/bzd7FpIk4XMLORjwZw7u2BTJNuxNizEqNZu70qNy.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(5, 1, '/storage/photos/qWXKnVxuMuwhjRFmNST9XtqzmeNgw97I2BrqKAZC.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(6, 2, '/storage/photos/FmsXAi0vZuxx6ZRYRWwDsD8mfRTDTmKOu2dsRENR.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(7, 2, '/storage/photos/t3cNcjQhYJztiHqfGzS7qhYeV9432we6eDrIWCCM.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(9, 2, '/storage/photos/QCrzsBZMO5BFvNm8SDz1LhDRIjIiOnVjCAWVNOD1.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(10, 2, '/storage/photos/cPkaYCbjzvcaqxPzWV9FGVt8k1lhk8DGMkOq9hQ3.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(11, 3, '/storage/photos/ohGtZNNM1TmlOZ6Xw2KKo7oATEz8zrcjXKouDDqy.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(12, 3, '/storage/photos/ZRq8ASOh7mNUUBbq4yYfqEaXro9QZO1fJ3Po0cTs.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(13, 3, '/storage/photos/XtaR1a9srNK2vupYHaMWLDuVt2QOCzqrErW2F1vZ.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(14, 3, '/storage/photos/Amwk4BDLf1S0v7H4hkebqenMhaBXTZwvyp486tcN.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(15, 3, '/storage/photos/dFDp1LeItTHpNG1iva3qc1uN4u1UXvIlJoRATOJR.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(16, 4, '/storage/photos/2VpQMxnkliElw5teudfor7lXd5QjlRdiwrZLQryA.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(17, 4, '/storage/photos/CAAdcNrsj4lC3czC2NeypQiN4jvhhY1VOT2zeDY6.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(18, 4, '/storage/photos/FVDKLYBRnvDX96e5B4zM5QuXWcbOzWfkOZpmhI2y.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(19, 4, '/storage/photos/ZAdukAbYTWgKpI3qn5Vk9oUWESSpKYKwsEizGJiH.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(20, 4, '/storage/photos/ez4cY6hFO5S8acXGYWZQbTMydTTpX0H9a8vT4V6t.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(58, 19, '/storage/photos/XjVobnIQvx1GC8Phaif0pqHCTv1TtXh5y5kib7JM.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(59, 19, '/storage/photos/i1GWazIUB11D49wpTSYzGfelKAfd5eLpu4BgJreh.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(60, 19, '/storage/photos/eVgnmqJulJroe6wblI9md2rGB9giYngqCVdAMbdC.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(61, 19, '/storage/photos/mKNTt020kqxMk2BbW85uZKLtiNPyODtbcfEviXNc.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(62, 19, '/storage/photos/uFJKEilVum3OkLMBErpn2eV0HHwctGqctYA9X3Nm.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(63, 20, '/storage/photos/n6JNOy0jUkkPWglvExRobcE2AG0GfMKzSAmzI7Yt.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(64, 20, '/storage/photos/rluc75tx3cygmO3JB5HsETEoEVdnBTGvqwRbmuoL.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(65, 20, '/storage/photos/ZXogWf34IlYW6L8MtctL7ODg4Cg5NsntOyvws4Sq.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(66, 20, '/storage/photos/AbHt2xFFhVEvgFRw4yf7fVhGKnu5aV562g40eZB3.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(67, 20, '/storage/photos/Kj3cCJXgLyJMQWKUMr4NLagl1W7rJMYkaO6dzey3.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(68, 21, '/storage/photos/vQC3dXZs3TeFDhTghbZzof7naLmOxPvAttHkro03.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(69, 21, '/storage/photos/JVAazg77Hc0ROE8cHlUJM0UWWhtagTFwQhidHYdy.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(70, 22, '/storage/photos/SV0qn4DDfBAPC5DEk1kPNr3G4ll0RYv2ccGsfesV.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(71, 22, '/storage/photos/6VeF9Y0ymlG3q7hvMVLQ7DcNBMtWWRMpJsGyhMmR.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(72, 22, '/storage/photos/Crmc0re2D1bOWJiXEfEthSwgUjamZBzLitpEpliq.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(73, 22, '/storage/photos/aCthjr0TLyUTixnOh6LONircMnLNY2osrWaN4peS.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(74, 22, '/storage/photos/Q5CNZO0DiNF0F8fBQDFq1h8uITzhrqcf7w5zuzqB.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(75, 23, '/storage/photos/oBSLoi5gmOeLGrqevD0MSKrl14KN9vj5GaFzBaFV.jpg', 1, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(76, 23, '/storage/photos/WV0Bo1QyFJzrhiHXLgh56OR26EmMamXfyLD4YOmS.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(77, 23, '/storage/photos/PvNNTptTaB89gF5pvjuJ0yBreIBKIm7NxNIUkCTR.jpg', 0, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(79, 24, '/storage/photos/izjbpzlvmx1ubHRfa1HDGXItl2GcfLHeYTFxGpDT.jpg', 0, '2025-09-12 18:37:08', '2025-09-12 18:37:08'),
(80, 24, '/storage/photos/WhROSLowBNL8r5KvxX6stcPf8VQ7WVMrXlRSvEwV.png', 0, '2025-09-12 18:37:08', '2025-09-12 18:37:08'),
(81, 24, '/storage/photos/bXwPtr3f6rAEJ3WfMBGazJOJRQlP3N3sF9uolm5d.jpg', 0, '2025-09-12 18:37:08', '2025-09-12 18:37:08'),
(82, 24, '/storage/photos/bPLdhHXR6p8tvgQEZ4u0qwCmeqSwBgBTfapitiQo.jpg', 0, '2025-09-12 18:37:08', '2025-09-12 18:37:08'),
(83, 24, '/storage/photos/RL5NIZpk3oNBcwS4KcKJjhJNiLckzamIcB013Bq7.png', 1, '2025-09-12 18:37:08', '2025-09-12 18:37:38');

-- --------------------------------------------------------

--
-- Структура таблицы `promo_codes`
--

CREATE TABLE `promo_codes` (
  `idPromoCode` bigint UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codeAmount` int NOT NULL,
  `discountValue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateStart` datetime NOT NULL,
  `dateEnd` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `promo_codes`
--

INSERT INTO `promo_codes` (`idPromoCode`, `code`, `codeAmount`, `discountValue`, `dateStart`, `dateEnd`, `created_at`, `updated_at`) VALUES
(1, '0687-0424-2179-1345', 3, '90', '2025-08-22 00:00:00', '2025-09-25 00:00:00', '2025-08-22 16:11:00', '2025-08-22 16:11:00');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
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
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6DWakuiMjlIfmJHzVCwC2SMi5zttz2kBbP02Es25', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo5OntzOjY6Il90b2tlbiI7czo0MDoiMEV6aWV2UlF6T1JESTNtS0VJcExyd2ZobURvazIyVnF3dERnRVNIaiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7fXM6NTM6ImxvZ2luX2J1eWVyc181OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO3M6NjoiYmFza2V0IjthOjE6e2k6MDthOjY6e3M6NzoiaWRXYXRjaCI7aToxO3M6NDoibmFtZSI7czo2ODoiUm9sZXggRGF0ZWp1c3QgMzZtbSBPeXN0ZXIgU3RlZWwgWWVsbG93IEdvbGQgRGlhbW9uZCBCZXplbCBQYWxtIERpYWwiO3M6NToicHJpY2UiO2Q6NzM1MDAwO3M6NToicGhvdG8iO3M6NjA6Ii9zdG9yYWdlL3Bob3Rvcy9jS25DZ0J5SkdpZW9PMzBLc1l3cGhiZTBHWERoemNKUGZ4TlRIeUdYLmpwZyI7czo4OiJtYXhLb2x2byI7aTo1O3M6NToia29sdm8iO2k6MTt9fXM6OToidG90YWxDb3N0IjtkOjczNTAwMDtzOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1NzcxMjU4Mjt9czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9fQ==', 1757713276),
('vWGxxkBj5r0XvwDCTcmWQVmlYXTKWJ22S4w4zezt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YToxMzp7czo2OiJfdG9rZW4iO3M6NDA6IlhhUzVXb0thVTRjblJGU08zREQyaUo5Y0RDRFRybDJBRTR2TWcyRUgiO3M6MzoidXJsIjthOjA6e31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluIjt9czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU3NzQ3OTk2O31zOjY6ImJhc2tldCI7YToyOntpOjA7YTo2OntzOjc6ImlkV2F0Y2giO2k6MjQ7czo0OiJuYW1lIjtzOjQxOiLQk9C+0LTQuNC90L3QuNC6IEZlc3RpbmEgUmFpbmJvdyBGMjA2MDYvMiI7czo1OiJwcmljZSI7ZDoxMDAwMDtzOjU6InBob3RvIjtzOjYwOiIvc3RvcmFnZS9waG90b3MvUkw1TklacGszb05CY3dTNEtjS0pqaEpOaUxja3phbUljQjAxM0JxNy5wbmciO3M6ODoibWF4S29sdm8iO2k6ODtzOjU6ImtvbHZvIjtpOjE7fWk6MTthOjY6e3M6NzoiaWRXYXRjaCI7aToxO3M6NDoibmFtZSI7czo2ODoiUm9sZXggRGF0ZWp1c3QgMzZtbSBPeXN0ZXIgU3RlZWwgWWVsbG93IEdvbGQgRGlhbW9uZCBCZXplbCBQYWxtIERpYWwiO3M6NToicHJpY2UiO2Q6NzM1MDAwO3M6NToicGhvdG8iO3M6NjA6Ii9zdG9yYWdlL3Bob3Rvcy9jS25DZ0J5SkdpZW9PMzBLc1l3cGhiZTBHWERoemNKUGZ4TlRIeUdYLmpwZyI7czo4OiJtYXhLb2x2byI7aTo1O3M6NToia29sdm8iO2k6MTt9fXM6OToidG90YWxDb3N0IjtkOjc0NTAwMDtzOjUzOiJsb2dpbl9idXllcnNfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTA6IndhcmVob3VzZXMiO2E6MTU6e2k6MDtzOjczOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJYxOiDQstGD0LsuINCf0LjRgNC+0LPRltCy0YHRjNC60LjQuSDRiNC70Y/RhSwgMTM1IjtpOjE7czo2MToi0JLRltC00LTRltC70LXQvdC90Y8g4oSWMjog0LLRg9C7LiDQkdC+0LPQsNGC0LjRgNGB0YzQutCwLCAxMSI7aToyO3M6MTAyOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJYzICjQtNC+IDMwINC60LMg0L3QsCDQvtC00L3QtSDQvNGW0YHRhtC1KTog0LLRg9C7LiDQodC70L7QsdC+0LbQsNC90YHRjNC60LAsMTMiO2k6MztzOjc1OiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJY0ICjQtNC+IDIwMCDQutCzKTog0LLRg9C7LiDQktC10YDRhdC+0LLQuNC90L3QsCwgNjkiO2k6NDtzOjEwMDoi0JLRltC00LTRltC70LXQvdC90Y8g4oSWNSAo0LTQviAyMDAg0LrQsyk6INCy0YPQuy4g0KTQtdC00L7RgNC+0LLQsCwgMzIgKNC8LiDQntC70ZbQvNC/0ZbQudGB0YzQutCwKSI7aTo1O3M6Njk6ItCS0ZbQtNC00ZbQu9C10L3QvdGPIOKEljY6INCy0YPQuy4g0JzQuNC60L7Qu9C4INCS0LDRgdC40LvQtdC90LrQsCwgMiI7aTo2O3M6MTEyOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJY3ICjQtNC+IDEwINC60LMpOiDQstGD0LsuINCT0L3QsNGC0LAg0KXQvtGC0LrQtdCy0LjRh9CwLCA4ICjQvC7Qp9C10YDQvdGW0LPRltCy0YHRjNC60LApIjtpOjc7czoxMjA6ItCS0ZbQtNC00ZbQu9C10L3QvdGPIOKEljggKNC00L4gMzAg0LrQsyDQvdCwINC+0LTQvdC1INC80ZbRgdGG0LUpOiDQstGD0LsuINCd0LDQsdC10YDQtdC20L3Qvi3QpdGA0LXRidCw0YLQuNGG0YzQutCwLCAzMyI7aTo4O3M6MTIzOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJY5OiDQv9GA0L7Qsi4g0JIn0Y/Rh9C10YHQu9Cw0LLQsCDQp9C+0YDQvdC+0LLQvtC70LAsIDU00LAgKNGALdC9INCW0YPQu9GP0L3RgdGM0LrQvtCz0L4g0LzQvtGB0YLRgykiO2k6OTtzOjk1OiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJYxMCAo0LTQviAxMTAwINC60LMgKTog0LLRg9C7LiDQktCw0YHQuNC70Y8g0JbRg9C60L7QstGB0YzQutC+0LPQviwgMjLQkCI7aToxMDtzOjYyOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJYxMjog0LLRg9C7LiDQoNC+0LTQuNC90Lgg0JHRg9C90LPQtSwgOCI7aToxMTtzOjYzOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJYxMzog0LLRg9C7LiDQlNC+0YDQvtCz0L7QttC40YbRjNC60LAsIDQiO2k6MTI7czoxMDA6ItCS0ZbQtNC00ZbQu9C10L3QvdGPIOKEljE0ICjQtNC+IDMwINC60LMg0L3QsCDQvtC00L3QtSDQvNGW0YHRhtC1KTog0LLRg9C7LiDQmtC40LHQsNC70YzRh9C40YfQsCwgMTEiO2k6MTM7czo3Mjoi0JLRltC00LTRltC70LXQvdC90Y8g4oSWMTU6INCy0YPQuy4g0JHQtdGA0LrQvtCy0LXRhtGM0LrQsCwgNiAo0JDQqNCQ0J0pIjtpOjE0O3M6OTQ6ItCS0ZbQtNC00ZbQu9C10L3QvdGPIOKEljE2ICjQtNC+IDMwINC60LMg0L3QsCDQvtC00L3QtSDQvNGW0YHRhtC1KTog0LLRg9C7LiDQktC10YDQsdC+0LLQsCwgMjQiO31zOjEwOiJzZWxlY3RDaXR5IjtzOjg6ItCa0LjRl9CyIjtzOjEzOiJzZWxlY3RDaXR5UmVmIjtzOjM2OiI4ZDVhOTgwZC0zOTFjLTExZGQtOTBkOS0wMDFhOTI1Njc2MjYiO3M6MTY6InNlbGVjdFdhcmVob3VzZXMiO3M6MTAyOiLQktGW0LTQtNGW0LvQtdC90L3RjyDihJYzICjQtNC+IDMwINC60LMg0L3QsCDQvtC00L3QtSDQvNGW0YHRhtC1KTog0LLRg9C7LiDQodC70L7QsdC+0LbQsNC90YHRjNC60LAsMTMiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1757753668);

-- --------------------------------------------------------

--
-- Структура таблицы `styles`
--

CREATE TABLE `styles` (
  `idStyle` bigint UNSIGNED NOT NULL,
  `style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `styles`
--

INSERT INTO `styles` (`idStyle`, `style`, `created_at`, `updated_at`) VALUES
(1, 'Класика', '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(2, 'Спорт', '2025-08-22 16:11:00', '2025-08-22 16:11:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `status`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nazar', 1, 'nazarsnitka813@gmail.com', NULL, '$2y$12$Y1Xwi8EjdsMztELrBavc8OJmqU17Jz8c4/8tqmoe2E9e6Kumb/quq', 'yv1CRVQmLqOrYHvfd10OOuJnfjNvYFeRake3icAN3cMLgWzqPx01cbVX7Dy8', '2025-08-22 16:11:00', '2025-09-13 05:54:28'),
(2, 'Bogdan', 0, 'bogdan123@gmail.com', NULL, '$2y$12$2cmuT8F6WwFTbPOYndCZQOrW/e/5aKjeodl/baaQPoeBt13GN07ia', NULL, '2025-08-22 16:11:00', '2025-08-22 16:11:00');

-- --------------------------------------------------------

--
-- Структура таблицы `watches`
--

CREATE TABLE `watches` (
  `idWatch` bigint UNSIGNED NOT NULL,
  `idBrend` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idMech` bigint UNSIGNED NOT NULL,
  `idGen` bigint UNSIGNED NOT NULL,
  `idStyle` bigint UNSIGNED NOT NULL,
  `discription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `kolvo` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `watches`
--

INSERT INTO `watches` (`idWatch`, `idBrend`, `name`, `idMech`, `idGen`, `idStyle`, `discription`, `price`, `kolvo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Rolex Datejust 36mm Oyster Steel Yellow Gold Diamond Bezel Palm Dial', 1, 2, 1, 'Rolex Datejust 36mm Oyster Steel Yellow Gold Diamond Bezel Palm Dial \r\nRef. 126203\r\nRolex Brand\r\nModel Datejust 36\r\nMovement type Automatic winding\r\nCase Material Gold/Steel\r\nBracelet Material Gold/Steel\r\nYear 2022\r\nCondition Used (Very Good)\r\nShipping Scope With original papers and box\r\nGender Women\'s watch\r\nMovement Type Automatic\r\nCalibre/Mechanism 3235\r\nPower Reserve 70 h\r\nNumber of jewels 31\r\nCase Material Gold/Steel\r\nDiameter 36 mm \r\nWater resistance 10 atm\r\nBezel material Yellow gold\r\nGlass Sapphire crystal\r\nChampagne coloured dial\r\nBracelet material Gold/steel\r\nBracelet Colour Gold/Steel\r\nClasp Folding clasp\r\nClasp Material Gold/Steel\r\nDate\r\nGemstone/Brilliant finish, Screw locking head lock', 735000, 5, '2025-08-22 16:11:00', '2025-09-12 18:05:21'),
(2, 2, 'Cartier Tank Must Large Steel Diamonds Quartz', 2, 2, 1, 'Cartier Tank Must Large Steel Diamonds Quartz\r\nRef. W4TA0017\r\nBrand Cartier\r\nModel Tank\r\nMovement type Quartz\r\nCase Material Steel\r\nBracelet material Alligator leather\r\nYear 2022\r\nCondition Used (Very Good)\r\nShipping Scope With original papers and box\r\nGender Women\'s Watch\r\nMovement Type Quartz\r\nCase Material Steel\r\nDiameter 34 x 26 mm \r\nWater resistance 3 atm\r\nBezel Material Steel\r\nGlass Sapphire crystal\r\nDial Silver\r\nRoman numerals\r\nBracelet Material Alligator Leather\r\nBracelet Colour Black\r\nClasp Spike clasp\r\nClasp Material Steel\r\nFinished with gemstones / diamonds', 425123, 0, '2025-08-22 16:11:00', '2025-09-12 07:52:33'),
(3, 1, 'Rolex Datejust 36mm Jubilee MOP Diamond Dial Bezel', 4, 2, 1, 'Rolex Datejust 36 Jubilee MOP Diamond Dial Bezel\r\nRef. 116200\r\nRolex Brand\r\nModel Datejust 36\r\nMovement type Automatic winding\r\nCase Material Steel\r\nBracelet Material Steel\r\nYear 2019\r\nCondition Very Good (Worn, no or barely visible signs of wear)\r\nScope of delivery With original box and documents\r\nGender Women\'s watch\r\nMovement Type Automatic\r\nCalibre/Mechanism 3135\r\nPower Reserve 48 h\r\nNumber of Stones 31\r\nCase Material Steel\r\nDiameter 36 mm\r\nWater resistance 10 atm\r\nBezel Material Steel\r\nGlass Sapphire crystal\r\nDial Mother-of-pearl\r\nNumerals No numerals\r\nBracelet Material Steel\r\nBracelet colour Steel\r\nClasp Folding clasp\r\nClasp Material Steel\r\nDate, Screw locking crown\r\nFeatures bezel and dial additionally set with diamonds by a private jeweller', 1000000, 12, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(4, 2, 'Cartier Roadster Chronograph', 4, 1, 1, 'Cartier Roadster Chronograph\r\nRef. W62019X6\r\nBrand Cartier\r\nModel Roadster\r\nMovement type Automatic winding\r\nCase Material Steel\r\nBracelet Material Steel\r\nCondition New and unworn\r\nShipping Scope With original documents and box\r\nGender Men\'s watch/unisex watch\r\nMovement Type Automatic\r\nCalibre/Mechanism 8510\r\nPower Reserve 42 h\r\nNumber of jewels 37\r\nCase Material Steel\r\nDiameter 43 mm\r\nWater resistance 10 atm\r\nBezel Material Steel\r\nGlass Sapphire crystal\r\nDial Silver\r\nRoman numerals\r\nBracelet Material Steel\r\nBracelet colour Steel\r\nClasp Material Steel\r\nChronograph, Date\r\n\r\nYou might also like', 360000, 8, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(19, 1, 'Rolex Submariner Date', 1, 1, 1, 'Pre-owned men\'s watch Rolex Submariner Date, ref. 16610\r\n\r\nComplete with watch, box and papers, good condition\r\n\r\nCase size 40 mm\r\nCase Material Steel\r\nBezel material aluminum\r\nSelf-winding mechanical movement Rolex 3135 with a power reserve of 48 hours\r\nWater protection 300 meters\r\nBlack dial\r\nSapphire crystal\r\nSteel bracelet\r\nSteel folding clasp\r\nFunctions: hours, minutes, seconds, date\r\nFeatures: screw-down crown, rotating bezel, 2005\r\n\r\nAll photos are taken by us without editing in photo editor\r\nThe photos show exactly the watch for sale\r\nYou can exchange your watch with additional payment in both directions', 470000, 10, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(20, 2, 'Cartier Santos 100 XL Chronograph Steel 18K Yellow Gold 42', 1, 1, 1, 'Cartier Santos 100 XL Chronograph Steel 18K Yellow Gold 42, ref. W20091X7 2740,\r\n\r\nIncludes: watch only, good condition\r\n\r\nCase size 42 mm\r\nCase material steel/yellow gold\r\nBezel material yellow gold\r\nCartier 8630 self-winding mechanical movement with a power reserve of 42 hours\r\nWater resistance 30 meters\r\nWhite dial\r\nSapphire crystal\r\nBrown crocodile strap\r\nSteel/yellow gold folding clasp\r\nFunctions: hours, minutes, seconds, date, chronograph\r\nSpecial features: small second hand\r\n\r\nManufacturer\'s recommended price: $13700\r\n\r\nAll photos are taken by us without editing in photo editor\r\nThe photos show exactly the watch for sale\r\nYou can exchange your watch with additional payment in both directions', 820000, 11, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(21, 6, 'THE BROADWAY DUAL TIME AUTOMATIC WATCH I12908', 1, 1, 1, 'Ingersoll 1892 The Broadway Automatic Mens Watch with Black Skeleton Dial and Black PU Strap - I12908\r\n\r\nSPECIFICATIONS:\r\nCase Diameter: 43mm\r\nCase Depth: 13.8mm\r\nCase Material: Stainless Steel\r\nCase Colour: Black\r\nDial Colour: Black\r\nStrap Width: 26mm\r\nStrap Material: PU\r\nStrap Colour: Black\r\nClasp Type: Pin & Buckle\r\nMovement: Automatic \r\nWater Resistance: 50m\r\nGlass: Scratch Resistant Mineral Glass\r\nFunctions: Hours, minutes, seconds\r\nSpecial Functions: Skeleton Dial, 2 Hand Movement, Luminous Hands, Moonphase.\r\nIncludes: Ingersoll watch, presentation box, instruction manual and lifetime warranty.', 35000, 7, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(22, 3, 'Citizen TSUYOSA Collection NJ0150-81E', 1, 1, 1, 'Модель \"Tsuyosa\" Automatic із серії NJ015 привносить ультрасучасний спортивний стиль на ваше зап\'ястя. Виконаний в універсальному 40-міліметровому корпусі, годинник справляє сильне враження завдяки корпусу з неіржавкої сталі сріблястого кольору і браслету, що органічно поєднується з ним. Під антивідблисковим сапфіровим склом спортивного годинника розміщений чорний циферблат із сонячними променями, віконце дати в положенні \"3 години\" і контрастні деталі сріблястого кольору доповнюють класичну естетику. Вишуканий годинник з автоматичним механізмом і водонепроникністю до 50 м - це повсякденний вибір для роботи, розваг і всього, що знаходиться між ними. Калібр 8210.', 15000, 6, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(23, 4, 'Orient RA-AA0002L19B Kamasu', 4, 1, 1, 'ORIENT RA-AA0002L19B – це стильний механічний годинник з серії Kamasu, який поєднує в собі спортивний дизайн, високу якість та практичні функції. Цей годинник стане чудовим вибором для чоловіків, які ведуть активний спосіб життя та цінують надійність та стиль.\r\n\r\nКорпус та браслет:\r\n\r\nКорпус виготовлений з нержавіючої сталі, що робить його міцним, стійким до корозії та надає йому елегантного чорного кольору.\r\nДіаметр корпусу становить 42 мм, що робить його зручним для чоловіків з будь-яким розміром зап’ястя.\r\nТовщина корпусу 12 мм робить годинник елегантним та практичним.\r\nБраслет також виготовлений з нержавіючої сталі з оснащений класичною застібкою-бляшкою.\r\nЦиферблат:\r\n\r\nЦиферблат синього кольору з білими мітками та стрілками.\r\nМітки та стрілки покриті люмінесцентним складом, що дозволяє легко читати час у темряві.\r\nНа циферблаті розташовані два додаткових циферблата:\r\nМалий циферблат в положенні 3 години показує день тижня.\r\nМалий циферблат в положенні 6 години показує 24-годинний формат часу.\r\nВікно дати розташоване в положенні 3 години.\r\nКорпус покрит сапфіровим склом.\r\nМеханізм:\r\n\r\nГодинник оснащений надійним японським механізмом з автопідзаводом Caliber F6922.\r\nМеханізм має 22 камені, що забезпечує його плавний хід та довговічність.\r\nЗапас ходу механізму становить 40 годин.\r\nФункції:\r\n\r\nГодинник показує час, дату, день тижня та 24-годинний формат часу.\r\nФункція автопідзаводу звільняє від необхідності регулярно заводити годинник.\r\nВодонепроникність 200 м дозволяє використовувати годинник для плавання та пірнання з маскою та трубкою.', 17650, 8, '2025-08-22 16:11:00', '2025-08-22 16:11:00'),
(24, 5, 'Годинник Festina Rainbow F20606/2', 2, 2, 1, 'Цей жіночий годинник FESTINA F20606/2 з колекції RAINBOW - яскрава та модна прикраса для вашого зап\'ястя. Він створений у стилі Fashion з мінеральним склом і круглим корпусом з нержавіючої сталі, пофарбованим у сріблястий колір. Яскравий перламутровий циферблат з арабськими цифрами та індексами додає шарму і витонченості цьому годиннику. Кварцовий механізм і хронограф гарантують точність і функціональність, а водозахист 100 WR забезпечує надійний захист від води. Ви будете чарівні з цим стильним та елегантним годинником Festina RAINBOW. Гарантія на годинник становить 24 місяці.', 10000, 8, '2025-09-12 18:35:51', '2025-09-12 18:35:51');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`idAddress`);

--
-- Индексы таблицы `brends`
--
ALTER TABLE `brends`
  ADD PRIMARY KEY (`idBrend`);

--
-- Индексы таблицы `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`idBuyer`),
  ADD UNIQUE KEY `buyers_email_unique` (`email`),
  ADD UNIQUE KEY `buyers_googleid_unique` (`googleId`),
  ADD UNIQUE KEY `buyers_number_unique` (`number`),
  ADD KEY `buyers_idaddress_foreign` (`idAddress`),
  ADD KEY `buyers_idnovapost_foreign` (`idNovaPost`);

--
-- Индексы таблицы `buyers_password_reset_tokens`
--
ALTER TABLE `buyers_password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`idGender`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `mechanisms`
--
ALTER TABLE `mechanisms`
  ADD PRIMARY KEY (`idMechanism`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `nova_post_addresses`
--
ALTER TABLE `nova_post_addresses`
  ADD PRIMARY KEY (`idNovaPost`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idOrder`),
  ADD UNIQUE KEY `orders_numberorder_unique` (`numberOrder`),
  ADD KEY `orders_idbuyer_foreign` (`idBuyer`),
  ADD KEY `orders_idpromocode_foreign` (`idPromoCode`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`idPhoto`),
  ADD KEY `photos_idwatch_foreign` (`idWatch`);

--
-- Индексы таблицы `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`idPromoCode`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`idStyle`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Индексы таблицы `watches`
--
ALTER TABLE `watches`
  ADD PRIMARY KEY (`idWatch`),
  ADD KEY `watches_idbrend_foreign` (`idBrend`),
  ADD KEY `watches_idmech_foreign` (`idMech`),
  ADD KEY `watches_idgen_foreign` (`idGen`),
  ADD KEY `watches_idstyle_foreign` (`idStyle`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `idAddress` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `brends`
--
ALTER TABLE `brends`
  MODIFY `idBrend` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `buyers`
--
ALTER TABLE `buyers`
  MODIFY `idBuyer` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `genders`
--
ALTER TABLE `genders`
  MODIFY `idGender` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `mechanisms`
--
ALTER TABLE `mechanisms`
  MODIFY `idMechanism` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `nova_post_addresses`
--
ALTER TABLE `nova_post_addresses`
  MODIFY `idNovaPost` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `idOrder` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `photos`
--
ALTER TABLE `photos`
  MODIFY `idPhoto` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT для таблицы `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `idPromoCode` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `styles`
--
ALTER TABLE `styles`
  MODIFY `idStyle` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `watches`
--
ALTER TABLE `watches`
  MODIFY `idWatch` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `buyers`
--
ALTER TABLE `buyers`
  ADD CONSTRAINT `buyers_idaddress_foreign` FOREIGN KEY (`idAddress`) REFERENCES `addresses` (`idAddress`),
  ADD CONSTRAINT `buyers_idnovapost_foreign` FOREIGN KEY (`idNovaPost`) REFERENCES `nova_post_addresses` (`idNovaPost`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_idbuyer_foreign` FOREIGN KEY (`idBuyer`) REFERENCES `buyers` (`idBuyer`),
  ADD CONSTRAINT `orders_idpromocode_foreign` FOREIGN KEY (`idPromoCode`) REFERENCES `promo_codes` (`idPromoCode`);

--
-- Ограничения внешнего ключа таблицы `watches`
--
ALTER TABLE `watches`
  ADD CONSTRAINT `watches_idbrend_foreign` FOREIGN KEY (`idBrend`) REFERENCES `brends` (`idBrend`),
  ADD CONSTRAINT `watches_idgen_foreign` FOREIGN KEY (`idGen`) REFERENCES `genders` (`idGender`),
  ADD CONSTRAINT `watches_idmech_foreign` FOREIGN KEY (`idMech`) REFERENCES `mechanisms` (`idMechanism`),
  ADD CONSTRAINT `watches_idstyle_foreign` FOREIGN KEY (`idStyle`) REFERENCES `styles` (`idStyle`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
