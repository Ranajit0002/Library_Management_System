-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2026 at 03:08 AM
-- Server version: 8.0.46-0ubuntu0.24.04.3
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Library_Management_System`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `email`, `phone`, `biography`, `photo`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Libbie Wolf', 'leo90@example.org', '757.283.9347', 'Sint ea temporibus quo ea qui vel sint. Aut et et et veritatis deleniti.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(2, 'Mabelle Muller', 'devante56@example.com', '+1 (279) 595-7230', 'Modi sit saepe exercitationem et laborum nisi. Facere libero quisquam veritatis voluptas aspernatur dignissimos similique. Et debitis odit hic blanditiis id placeat et.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(3, 'Dr. Dallas Kulas DDS', 'tdubuque@example.com', '(520) 774-2909', 'Sed dolore aut qui at. Delectus harum qui nesciunt necessitatibus repudiandae aut rerum.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(4, 'Kyleigh Will', 'vena.morissette@example.net', '+1-283-580-8643', 'Omnis dolorem nulla mollitia earum est est. In illo eos blanditiis eveniet consequuntur molestias labore. Et ut nostrum et tenetur ut voluptate impedit.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(5, 'Tyshawn Waelchi', 'qkuphal@example.org', '+1 (915) 969-7368', 'Facilis voluptatem quo quas. Odio velit voluptatem aut hic velit impedit reprehenderit. Magnam perferendis in quibusdam asperiores quia exercitationem.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(6, 'Ivory Blick III', 'qnienow@example.com', '(908) 876-1782', 'Porro qui recusandae magni et voluptates pariatur molestiae eius. Et inventore velit voluptatem quibusdam facere similique tenetur provident.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(7, 'Ophelia Emard', 'florida.crona@example.net', '+1.551.533.4415', 'Itaque ut sed asperiores minima omnis et. Eligendi vel at inventore sequi ut quas vero accusantium.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(8, 'Zaria Wiegand', 'corkery.lou@example.org', '513-569-3678', 'Adipisci saepe doloribus cumque in aut. Natus error autem dolorem eum voluptatum.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(9, 'Cecilia Kirlin', 'isidro14@example.org', '954-357-5990', 'Totam nobis quia sit nobis rerum. Maiores sequi consequatur et quos.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(10, 'Sandra Huels', 'raegan45@example.org', '949.490.7308', 'Rerum provident ex dolorem pariatur cumque. Et nisi adipisci cupiditate quae illo libero. Minima corrupti non voluptas reprehenderit accusamus omnis non doloremque.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(11, 'Turner Cassin', 'lcole@example.com', '1-347-589-2900', 'Deserunt unde rerum consequatur iste minus modi. Possimus iure error officia molestiae amet non deserunt.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(12, 'Lizzie Ebert', 'chelsie.roob@example.org', '254.682.2936', 'Incidunt consequatur sunt ut saepe. Necessitatibus et hic non asperiores facere.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(13, 'Prof. Bernard Pouros Sr.', 'hbogan@example.org', '281.962.0223', 'Velit est et officiis perferendis necessitatibus ut. Aut provident reprehenderit voluptatem itaque.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(14, 'Prof. Wilber Koepp DDS', 'whessel@example.net', '413.680.5030', 'Sed quia quos sit consequatur. Velit beatae qui voluptatem quos unde totam.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(15, 'Foster Hand', 'schaefer.isom@example.org', '(603) 500-4893', 'Maiores sapiente odio cumque voluptas nisi cum et. Commodi necessitatibus autem eligendi ut in harum.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(16, 'Jaclyn Kertzmann', 'fupton@example.net', '508-691-3633', 'Tempore voluptatibus cum aliquid itaque tempora saepe. Non porro tempore optio veniam facere pariatur. Aliquid cupiditate debitis et qui.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(17, 'Junior Crist PhD', 'kwindler@example.com', '1-404-310-6272', 'Doloremque beatae ea illo quod quia. Nulla sed dolorem tempora. Dolore voluptatem adipisci maiores consequatur qui nam.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(18, 'Xander Legros', 'vincent.jaskolski@example.net', '858.538.5566', 'Maiores provident debitis nostrum sunt. Aut neque eos ad et in voluptatem.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(19, 'Antwon Bartoletti', 'wilbert73@example.com', '812.502.6376', 'Fugiat reiciendis molestiae alias officiis. Dolorum aliquid quaerat ipsa eligendi reiciendis excepturi sunt. Nulla vel et qui sequi velit ut autem.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(20, 'Karli Parisian', 'tmcdermott@example.com', '+1 (910) 229-2037', 'Fugit omnis non repellendus rerum. Est repudiandae culpa harum.', NULL, 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `publisher_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'English',
  `price` decimal(8,2) NOT NULL,
  `quantity` int NOT NULL,
  `available_quantity` int NOT NULL,
  `publish_year` year DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('available','out_of_stock') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `category_id`, `author_id`, `publisher_id`, `title`, `isbn`, `edition`, `language`, `price`, `quantity`, `available_quantity`, `publish_year`, `description`, `cover_image`, `status`, `created_at`, `updated_at`, `file_path`) VALUES
(1, 4, 12, 5, 'Velit voluptatum adipisci rerum.', '9788568383547', '2th Edition', 'English', 57.99, 18, 18, '2018', 'Aliquam molestiae perferendis velit aliquam recusandae molestiae. Omnis culpa quisquam et debitis omnis iste aperiam. Beatae et nihil aut qui optio praesentium et. Sunt occaecati architecto error officiis reprehenderit.', 'https://picsum.photos/seed/book1/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(2, 6, 17, 4, 'Blanditiis aperiam dolorum.', '9788143989636', '1th Edition', 'English', 43.99, 9, 8, '2024', 'Blanditiis ad libero inventore nulla. Unde quisquam sapiente omnis unde voluptas. Perspiciatis odit reprehenderit fugiat reiciendis nihil. Qui vero labore fugiat illum illum incidunt eos. Ut tempore debitis ex dolorum sunt in.', 'https://picsum.photos/seed/book2/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(3, 4, 5, 9, 'Inventore veritatis doloribus dolores.', '9785069731781', '3th Edition', 'English', 37.99, 24, 23, '2018', 'Dolor voluptates exercitationem porro asperiores hic amet quas. Dolorum distinctio assumenda dolor tempore et. Non rem voluptatem sit dicta beatae in. Cumque aperiam est perspiciatis incidunt.', 'https://picsum.photos/seed/book3/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(4, 7, 2, 5, 'Voluptas ex in officiis.', '9781250574004', '2th Edition', 'English', 189.99, 29, 27, '2007', 'Molestias quisquam earum consequatur recusandae rerum voluptatem. Voluptates ab voluptate consequatur deleniti nihil id. Quibusdam inventore nihil explicabo omnis. Necessitatibus ea error hic autem ratione fugiat dolore animi.', 'https://picsum.photos/seed/book4/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(5, 7, 12, 4, 'Non eum omnis.', '9781683661175', '4th Edition', 'Spanish', 169.99, 23, 23, '2010', 'Qui commodi odit nobis provident molestias repellendus ratione qui. Beatae laboriosam at qui sint. Enim omnis eum maxime culpa dolores. Numquam quisquam autem quos corrupti.', 'https://picsum.photos/seed/book5/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(6, 7, 1, 10, 'Rerum sunt omnis.', '9785631818865', '4th Edition', 'English', 72.99, 7, 7, '2001', 'Nulla totam quaerat ut et dolorum. Vitae eaque aperiam voluptates. Sunt dolores dolorum nulla unde ut libero.', 'https://picsum.photos/seed/book6/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(7, 5, 17, 7, 'Dolorum sed ipsam.', '9786630392359', '4th Edition', 'German', 115.99, 6, 5, '2025', 'Alias et ut aperiam ut sit. Accusantium explicabo non quis est. Aliquam quidem ut veritatis ut sit quia cupiditate. Rem non autem odio assumenda alias.', 'https://picsum.photos/seed/book7/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(8, 5, 11, 3, 'Ullam sapiente similique et.', '9782089812197', '2th Edition', 'Spanish', 160.99, 9, 8, '2000', 'Qui officiis cum libero occaecati quas. Voluptatem rerum laboriosam perspiciatis eligendi nihil animi quidem. Est repudiandae eligendi beatae. Ratione qui qui at debitis.', 'https://picsum.photos/seed/book8/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(9, 8, 16, 9, 'Iusto nihil amet.', '9789700151175', '4th Edition', 'German', 131.99, 8, 6, '2011', 'Maxime adipisci non reiciendis eum hic doloremque ullam. Alias aut nulla nemo rerum. Laboriosam laudantium quae eligendi quos corrupti sint similique.', 'https://picsum.photos/seed/book9/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(10, 7, 10, 8, 'Et quas non.', '9788619073753', '2th Edition', 'English', 162.99, 26, 25, '2009', 'Qui minima sit similique cumque. Sit explicabo laboriosam quidem ex non sed facere earum. Occaecati esse distinctio iusto commodi. Porro sed et veritatis qui.', 'https://picsum.photos/seed/book10/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(11, 2, 15, 10, 'Fuga accusantium debitis velit aut.', '9782953726853', '2th Edition', 'English', 70.99, 9, 8, '2020', 'Architecto nihil iure distinctio et incidunt dolores. Dolore rerum nostrum quia hic explicabo. Ex ut dolorum facilis placeat voluptatem.', 'https://picsum.photos/seed/book11/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(12, 2, 9, 6, 'Voluptas libero deserunt ut.', '9787354087250', '4th Edition', 'German', 148.99, 30, 28, '2025', 'Blanditiis quod ex quae vero sint. Sed minus totam tempore. Totam animi aut sequi in alias.', 'https://picsum.photos/seed/book12/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(13, 1, 2, 4, 'Maiores omnis qui.', '9787879041754', '3th Edition', 'English', 141.99, 5, 5, '2006', 'Dolorem quas voluptatem et labore libero. Necessitatibus nesciunt maxime architecto et qui. Officia consequatur nesciunt corporis magni in id.', 'https://picsum.photos/seed/book13/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(14, 8, 20, 7, 'Alias velit soluta sed.', '9783961645263', '3th Edition', 'Spanish', 53.99, 7, 5, '2009', 'Inventore neque iure et deserunt. Aut excepturi sit ipsam odio optio aperiam provident. Tempore omnis voluptate consequatur consequatur corporis. Quam sit iure et maxime quod minus ea explicabo.', 'https://picsum.photos/seed/book14/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(15, 3, 6, 10, 'Blanditiis quo.', '9789792103251', '1th Edition', 'English', 80.99, 16, 16, '2021', 'Qui et a eum odit nisi aut. Voluptas corporis suscipit doloribus qui quibusdam. Omnis exercitationem voluptas laboriosam voluptates. Illum amet voluptatibus hic provident cumque unde praesentium rerum.', 'https://picsum.photos/seed/book15/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(16, 6, 11, 5, 'Qui nihil et.', '9784101556235', '3th Edition', 'French', 31.99, 11, 8, '2000', 'Voluptatibus ea nulla aut sunt ipsum voluptatum recusandae. Officia et non est ut at laudantium est aut. Quae quaerat voluptas ipsam sunt sequi vel quam. Quas dolore repudiandae aut fugit est recusandae.', 'https://picsum.photos/seed/book16/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(17, 8, 11, 9, 'Quidem vero et.', '9788508829866', '1th Edition', 'English', 58.99, 28, 28, '2006', 'Assumenda sit nostrum in quo. Totam quibusdam enim ut officiis. Inventore placeat recusandae iste quisquam tempore nam. Voluptatibus laboriosam repudiandae rem similique et ea ducimus.', 'https://picsum.photos/seed/book17/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(18, 1, 7, 9, 'Similique in temporibus consequatur.', '9789017153183', '1th Edition', 'Spanish', 157.99, 21, 20, '2004', 'Neque molestiae porro sit sint facere numquam necessitatibus hic. Perspiciatis qui facilis dolor sequi dicta earum sapiente. Consequuntur voluptatum nemo impedit quod illum enim quisquam. Aspernatur voluptatum eligendi molestias aut facilis. Aliquid nostrum rerum aut omnis enim nobis praesentium.', 'https://picsum.photos/seed/book18/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(19, 2, 7, 10, 'Consectetur aspernatur adipisci.', '9784622344747', '3th Edition', 'Spanish', 198.99, 8, 8, '2009', 'Vel quo temporibus labore. Qui minus enim aut reiciendis. Eum ipsum non corrupti explicabo molestiae consequatur odio non.', 'https://picsum.photos/seed/book19/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(20, 5, 11, 10, 'Quod velit et fugiat.', '9787603383326', '3th Edition', 'French', 127.99, 11, 11, '2004', 'Perspiciatis nulla quia omnis tempora quaerat qui in. Sit ducimus nulla quia quo et nemo ut. Ullam et consequatur repudiandae ipsum consequatur nostrum.', 'https://picsum.photos/seed/book20/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(21, 4, 2, 1, 'Aspernatur voluptas hic.', '9786700051236', '3th Edition', 'Spanish', 69.99, 22, 21, '2017', 'Odit quam odit ex saepe eligendi eligendi iure. Accusamus veniam explicabo accusamus ad explicabo omnis. Et debitis iste hic aut est vel cupiditate. Quia ipsa doloribus libero voluptas rem.', 'https://picsum.photos/seed/book21/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(22, 3, 1, 6, 'Sit architecto quos.', '9781463004342', '1th Edition', 'English', 114.99, 27, 26, '2004', 'Et ad quia et omnis veniam maiores totam perspiciatis. Reprehenderit voluptates vel eos nisi voluptatem dolores consequatur. Minima mollitia accusantium qui quos. Nam perferendis debitis est officiis.', 'https://picsum.photos/seed/book22/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(23, 1, 7, 1, 'Animi facilis sit.', '9783775264820', '4th Edition', 'Spanish', 79.99, 30, 29, '2012', 'Commodi ut sit praesentium beatae. Inventore dicta velit eos molestiae facere. Corrupti dolor fugiat alias omnis omnis ut eum qui. Velit dolor vitae distinctio quasi.', 'https://picsum.photos/seed/book23/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(24, 8, 10, 4, 'Dicta impedit consequatur omnis.', '9781734719475', '1th Edition', 'French', 26.99, 19, 17, '2006', 'Assumenda dolorem rem modi consequatur qui facilis in. Occaecati sint quia sint. Accusantium quidem ut eaque deleniti. Animi sint fugiat beatae earum tenetur nostrum.', 'https://picsum.photos/seed/book24/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(25, 1, 12, 3, 'Qui aut.', '9789096237687', '2th Edition', 'English', 149.99, 14, 14, '2011', 'Minus asperiores eos quo. Est accusantium accusamus ratione dolorem voluptatem ut. Quam ullam perferendis non et.', 'https://picsum.photos/seed/book25/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(26, 5, 1, 7, 'Voluptatem in placeat assumenda.', '9787554153161', '2th Edition', 'English', 109.99, 11, 11, '2015', 'Quae aut perferendis cumque earum. Pariatur sunt sed quia ipsam ducimus tempore. Saepe ad laudantium ad illo soluta. Corrupti et aliquid voluptatem.', 'https://picsum.photos/seed/book26/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(27, 6, 17, 10, 'Iste natus rerum.', '9783783419573', '3th Edition', 'French', 127.99, 11, 9, '2009', 'Rerum sit voluptatem alias fugiat amet voluptatem. Animi perspiciatis facilis cumque odio. Quia qui quam optio. Hic aut quod in animi.', 'https://picsum.photos/seed/book27/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(28, 7, 20, 1, 'Accusantium ut et.', '9783808713871', '2th Edition', 'German', 192.99, 17, 16, '2009', 'Exercitationem voluptatem neque totam nostrum. Minus fugit est doloremque adipisci voluptas. Et qui pariatur reiciendis non soluta dolor.', 'https://picsum.photos/seed/book28/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(29, 6, 5, 10, 'Et distinctio est.', '9781940347243', '4th Edition', 'English', 189.99, 17, 17, '2020', 'Quas facilis iure corporis quia. Repellat quas rerum quo ea. Dolor voluptas officia nisi tenetur.', 'https://picsum.photos/seed/book29/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(30, 3, 3, 9, 'Incidunt omnis dolorum.', '9783602457001', '4th Edition', 'German', 67.99, 6, 6, '2023', 'Tempora eum eaque ducimus molestiae incidunt eos. Praesentium minima consequatur soluta provident maxime. Enim ut tenetur similique repudiandae corporis est nesciunt id.', 'https://picsum.photos/seed/book30/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(31, 3, 3, 10, 'Beatae maiores ea non.', '9788458382119', '3th Edition', 'German', 65.99, 13, 12, '2015', 'Consequatur aliquam ex optio sapiente aliquid. Voluptas ad reiciendis voluptas neque.', 'https://picsum.photos/seed/book31/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(32, 6, 8, 8, 'Quaerat ab et voluptatem.', '9785002388843', '3th Edition', 'Spanish', 176.99, 10, 10, '2007', 'Odio dolores aut nesciunt eligendi. Omnis maxime mollitia corporis sed accusantium. Nobis et molestias mollitia iure nulla quas. Nostrum tempora ipsum fugiat quibusdam.', 'https://picsum.photos/seed/book32/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(33, 5, 11, 6, 'Quaerat temporibus eos voluptas.', '9789734195954', '4th Edition', 'German', 16.99, 5, 5, '2001', 'Repudiandae iure optio dolorum provident ut ex beatae. Assumenda eaque nulla est cumque. Esse minima reiciendis nam non id tempora.', 'https://picsum.photos/seed/book33/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(34, 1, 17, 5, 'Ea minima modi voluptatibus.', '9788641685719', '3th Edition', 'English', 197.99, 21, 20, '2018', 'Possimus est occaecati laudantium molestiae aperiam nobis. Aspernatur est velit adipisci et adipisci.', 'https://picsum.photos/seed/book34/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(35, 5, 2, 1, 'Vitae quia dolores atque.', '9788490497701', '4th Edition', 'English', 146.99, 14, 14, '2026', 'Eos officiis sapiente aut enim vel. Aut consequatur nulla doloremque. Sunt reprehenderit ab ducimus qui aut iusto dolores.', 'https://picsum.photos/seed/book35/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(36, 3, 3, 2, 'Doloribus non laudantium blanditiis praesentium.', '9783670104477', '4th Edition', 'German', 113.99, 15, 14, '2001', 'Exercitationem tempora quaerat enim sit. Laudantium neque nobis sed consectetur quo modi ad. Ipsum quia consequuntur illum. Dolorem voluptates distinctio similique velit nulla nihil.', 'https://picsum.photos/seed/book36/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(37, 1, 19, 1, 'Autem incidunt officiis.', '9782259027903', '2th Edition', 'Spanish', 29.99, 25, 21, '2021', 'Facilis et eos aut asperiores aut non consequuntur. Quibusdam minima qui esse aspernatur corrupti eaque at ea. Iure hic quidem aut est veniam optio ut. Sed sed necessitatibus officiis quaerat culpa. Assumenda itaque modi fugiat ut omnis non.', 'https://picsum.photos/seed/book37/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(38, 4, 2, 3, 'Provident sint.', '9788901629558', '1th Edition', 'German', 115.99, 19, 19, '2016', 'Voluptatem sequi harum aut inventore eius doloremque. Architecto vitae dolores debitis consequatur modi et suscipit. Sit sint quia id ut quaerat vitae eum perspiciatis.', 'https://picsum.photos/seed/book38/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(39, 1, 17, 9, 'Qui voluptas autem et.', '9789400565739', '4th Edition', 'English', 172.99, 14, 13, '2018', 'Fuga fugit architecto voluptatem numquam voluptas itaque nam. Nisi impedit odit qui voluptas numquam cum laboriosam sed. Est ut dolorum pariatur totam labore. Voluptatum voluptas libero officiis minima illo totam.', 'https://picsum.photos/seed/book39/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(40, 4, 4, 8, 'Alias eum.', '9787515202265', '2th Edition', 'Spanish', 27.99, 11, 11, '2013', 'Omnis ratione corrupti iste natus harum autem beatae quia. Eum qui et blanditiis quia et consequatur itaque accusamus.', 'https://picsum.photos/seed/book40/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(41, 1, 4, 2, 'Odit quaerat et.', '9784710674551', '3th Edition', 'Spanish', 200.99, 11, 10, '2001', 'Labore quam nam quae eos ipsam eaque est ut. In libero ut qui architecto. Et ut similique quis illo.', 'https://picsum.photos/seed/book41/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(42, 6, 9, 2, 'Laborum rerum eveniet.', '9781748029898', '2th Edition', 'English', 77.99, 20, 19, '2008', 'Et maxime voluptates similique numquam et incidunt. Fugiat ipsam aut maxime delectus perspiciatis. Pariatur velit eaque quasi quia doloribus.', 'https://picsum.photos/seed/book42/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(43, 3, 6, 10, 'Veritatis nulla et.', '9784747558387', '1th Edition', 'Spanish', 114.99, 24, 23, '2003', 'Delectus molestiae saepe qui aperiam quae delectus. Architecto vel quia et adipisci nostrum molestiae. Sapiente fugit dignissimos tempora incidunt illo. Qui tempora eum nemo.', 'https://picsum.photos/seed/book43/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(44, 3, 18, 3, 'Asperiores vitae.', '9781966603051', '1th Edition', 'Spanish', 87.99, 10, 8, '2002', 'Ipsum pariatur labore non voluptatem aut ullam repellat quidem. Voluptas rem amet fugit. Et minima nulla molestiae in ea. Voluptatibus unde est enim quos non culpa.', 'https://picsum.photos/seed/book44/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(45, 3, 4, 1, 'Aut non velit soluta.', '9787858522099', '3th Edition', 'French', 46.99, 7, 7, '2001', 'Quia et sunt sint harum delectus. Autem eum repudiandae est facere adipisci necessitatibus. Et aut consequuntur dolores voluptas aut optio. Voluptatem cupiditate sed esse.', 'https://picsum.photos/seed/book45/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(46, 7, 15, 1, 'Illum est quo laborum.', '9786312017942', '3th Edition', 'English', 193.99, 14, 14, '2024', 'Eos ut ad ipsa eligendi sint aut. Asperiores est eos quam sint. Commodi quo ut minima sint laboriosam corrupti veniam est. Aut quos odit voluptas assumenda.', 'https://picsum.photos/seed/book46/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(47, 3, 5, 6, 'Eum qui delectus.', '9788453818393', '3th Edition', 'English', 24.99, 9, 9, '2013', 'Quod aut et quam. Voluptates vero qui ut quo. Et ullam minus numquam quia repellendus et sit.', 'https://picsum.photos/seed/book47/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(48, 3, 10, 8, 'Iste impedit incidunt dolorem.', '9787054496596', '4th Edition', 'Spanish', 65.99, 19, 18, '2026', 'Et officia voluptatibus non. Incidunt quasi asperiores itaque sit corrupti iste nisi. Numquam error sit modi. Facere aut nesciunt dolores alias iste.', 'https://picsum.photos/seed/book48/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:51', NULL),
(49, 2, 2, 7, 'Nostrum nesciunt non.', '9784024662599', '3th Edition', 'French', 71.99, 30, 30, '2001', 'Fugit excepturi voluptatem est rerum commodi animi inventore. Sed quam illo voluptatem est iusto ipsum. Ea in sit vitae sapiente quis consectetur.', 'https://picsum.photos/seed/book49/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(50, 8, 10, 3, 'Occaecati possimus.', '9788657812601', '1th Edition', 'Spanish', 45.99, 8, 8, '2002', 'Est id et ea ducimus. Consequatur distinctio perspiciatis incidunt expedita temporibus quia corporis. Dolorum est cumque eius fugiat non necessitatibus corrupti. Numquam tenetur deleniti doloribus aperiam est vel dicta non. Tempore excepturi neque voluptatum sed.', 'https://picsum.photos/seed/book50/300/450', 'available', '2026-08-10 09:49:40', '2026-08-10 09:49:40', NULL),
(51, 6, 19, 3, 'data', '1234', '2', 'English', 1000.00, 1, 1, '2022', 'nothing', 'book-covers/M8cf0wkppMl0EtxyiwWyrnflYOEn10W2yBPWCQ6J.webp', 'available', '2026-08-10 10:11:49', '2026-08-10 10:11:49', 'ebooks/fjTQrsLsevPReT3ZgBOsZM3rpTKd8VvdacmxV90p.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `book_issues`
--

CREATE TABLE `book_issues` (
  `id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date NOT NULL,
  `actual_return_date` date DEFAULT NULL,
  `fine` decimal(8,2) NOT NULL DEFAULT '0.00',
  `fine_status` enum('unpaid','paid','waived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `waiver_reason` text COLLATE utf8mb4_unicode_ci,
  `status` enum('issued','returned','overdue') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'issued',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_issues`
--

INSERT INTO `book_issues` (`id`, `book_id`, `member_id`, `issue_date`, `return_date`, `actual_return_date`, `fine`, `fine_status`, `waiver_reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 37, 17, '2026-08-03', '2026-08-17', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(2, 4, 11, '2026-08-05', '2026-08-19', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(3, 3, 8, '2026-08-01', '2026-08-15', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(4, 7, 10, '2026-08-06', '2026-08-20', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(5, 10, 18, '2026-07-28', '2026-08-11', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(6, 8, 2, '2026-08-04', '2026-08-18', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(7, 4, 30, '2026-08-03', '2026-08-17', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(8, 44, 7, '2026-08-04', '2026-08-18', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(9, 44, 14, '2026-07-26', '2026-08-09', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(10, 16, 9, '2026-07-17', '2026-07-31', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(11, 16, 16, '2026-07-11', '2026-07-25', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(12, 41, 14, '2026-07-13', '2026-07-27', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(13, 23, 30, '2026-07-30', '2026-08-13', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(14, 27, 30, '2026-07-29', '2026-08-12', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(15, 37, 28, '2026-07-27', '2026-08-10', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(16, 28, 14, '2026-08-04', '2026-08-18', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(17, 27, 22, '2026-07-14', '2026-07-28', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(18, 34, 8, '2026-07-19', '2026-08-02', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(19, 2, 9, '2026-07-15', '2026-07-29', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(20, 36, 26, '2026-08-06', '2026-08-20', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(21, 16, 30, '2026-07-15', '2026-07-29', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(22, 42, 7, '2026-07-28', '2026-08-11', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(23, 24, 15, '2026-08-05', '2026-08-19', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(24, 22, 17, '2026-07-27', '2026-08-10', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(25, 9, 8, '2026-08-02', '2026-08-16', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(26, 43, 2, '2026-08-05', '2026-08-19', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(27, 37, 21, '2026-07-12', '2026-07-26', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(28, 14, 8, '2026-07-13', '2026-07-27', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(29, 12, 24, '2026-07-30', '2026-08-13', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(30, 21, 17, '2026-07-13', '2026-07-27', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(31, 24, 2, '2026-07-27', '2026-08-10', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(32, 12, 29, '2026-07-13', '2026-07-27', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(33, 31, 21, '2026-08-05', '2026-08-19', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(34, 37, 8, '2026-08-04', '2026-08-18', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(35, 48, 2, '2026-07-30', '2026-08-13', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(36, 14, 6, '2026-08-09', '2026-08-23', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(37, 11, 6, '2026-07-29', '2026-08-12', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(38, 39, 5, '2026-07-20', '2026-08-03', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(39, 18, 18, '2026-08-10', '2026-08-24', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(40, 9, 29, '2026-07-31', '2026-08-14', NULL, 0.00, 'unpaid', NULL, 'issued', '2026-08-10 09:49:51', '2026-08-10 09:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `book_reservations`
--

CREATE TABLE `book_reservations` (
  `id` bigint UNSIGNED NOT NULL,
  `book_id` bigint UNSIGNED NOT NULL,
  `member_id` bigint UNSIGNED NOT NULL,
  `reserved_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','fulfilled','cancelled','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book_reservations`
--

INSERT INTO `book_reservations` (`id`, `book_id`, `member_id`, `reserved_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 14, 14, '2026-08-08 18:30:00', 'cancelled', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(2, 8, 5, '2026-08-07 18:30:00', 'pending', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(3, 15, 18, '2026-08-07 18:30:00', 'fulfilled', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(4, 34, 19, '2026-08-06 18:30:00', 'cancelled', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(5, 12, 8, '2026-08-03 18:30:00', 'fulfilled', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(6, 21, 11, '2026-08-04 18:30:00', 'pending', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(7, 38, 24, '2026-08-07 18:30:00', 'fulfilled', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(8, 4, 3, '2026-08-05 18:30:00', 'pending', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(9, 13, 12, '2026-08-08 18:30:00', 'fulfilled', '2026-08-10 09:49:51', '2026-08-10 09:49:51'),
(10, 15, 10, '2026-08-03 18:30:00', 'pending', '2026-08-10 09:49:51', '2026-08-10 09:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Artificial Intelligence 39', 'Consectetur ad accusamus voluptatibus consequuntur asperiores ab omnis dolorum distinctio corrupti vitae doloribus.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(2, 'World History 10', 'Molestiae voluptas eos voluptatibus distinctio itaque temporibus accusantium sit ut eos.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(3, 'Software Engineering 91', 'Et nulla sunt voluptatem ut adipisci qui atque porro.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(4, 'Quantum Physics 65', 'Reprehenderit veritatis nihil quas et ratione laborum totam quos dolorum odit quidem ut.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(5, 'Mathematics 62', 'Iusto ex error quaerat magni mollitia et hic impedit ut voluptatum aut atque.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(6, 'Data Science 1', 'Non officia beatae explicabo non et praesentium ratione veniam in debitis cumque fuga.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(7, 'Literature 66', 'Nisi aut qui ab ea assumenda quia tempora voluptatem voluptas quia illo.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(8, 'Computer Science 43', 'Iure rerum ducimus veritatis enim fugiat omnis accusamus porro nulla eos ut aperiam itaque.', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `book_issue_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
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
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `membership_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `joining_date` date NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `user_id`, `membership_no`, `joining_date`, `address`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'MEM-10001', '2026-02-10', '462 Evan Drive Suite 197\nLake Margot, WI 19275', '1-283-831-8744', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(2, 3, 'MEM-52290', '2026-05-03', '3619 Christiansen Branch Suite 887\nPort Terryview, MI 19078-1891', '806-914-8136', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(3, 4, 'MEM-81131', '2026-07-21', '579 Alfonzo Shores\nSmithmouth, AR 15532', '(754) 555-4679', 'active', '2026-08-10 09:49:41', '2026-08-10 09:49:41'),
(4, 5, 'MEM-20958', '2026-08-02', '490 Kiel Shoals Apt. 443\nLake Jayde, ID 29734', '1-731-567-3851', 'active', '2026-08-10 09:49:41', '2026-08-10 09:49:41'),
(5, 6, 'MEM-74156', '2026-03-24', '74704 Isom Forges Suite 322\nTomasamouth, IA 95781-8607', '+1-616-633-5020', 'active', '2026-08-10 09:49:42', '2026-08-10 09:49:42'),
(6, 7, 'MEM-45078', '2025-08-15', '2545 Monserrate Loaf\nJerdeport, VT 34221-6003', '+17402771766', 'active', '2026-08-10 09:49:42', '2026-08-10 09:49:42'),
(7, 8, 'MEM-50099', '2026-02-15', '543 Kshlerin Meadow\nWest Dangelo, WA 91692-5817', '210.449.8148', 'active', '2026-08-10 09:49:42', '2026-08-10 09:49:42'),
(8, 9, 'MEM-17096', '2026-06-18', '978 Heidenreich Valleys\nNew Tessport, OR 81488', '1-267-476-2586', 'active', '2026-08-10 09:49:43', '2026-08-10 09:49:43'),
(9, 10, 'MEM-93421', '2026-04-28', '7391 Reinhold Gateway Suite 349\nSchimmelhaven, AL 01760-9764', '+1 (680) 378-8303', 'active', '2026-08-10 09:49:43', '2026-08-10 09:49:43'),
(10, 11, 'MEM-51029', '2025-10-28', '9958 Wuckert Loop\nPort Matilda, IN 38078', '279.889.6480', 'active', '2026-08-10 09:49:43', '2026-08-10 09:49:43'),
(11, 12, 'MEM-82689', '2025-10-10', '915 Moses Extension\nNew Elnaview, IN 05760', '930.769.9147', 'active', '2026-08-10 09:49:44', '2026-08-10 09:49:44'),
(12, 13, 'MEM-49507', '2025-12-26', '974 Asia Fields\nRolandoshire, MT 18153', '+1.325.294.0905', 'active', '2026-08-10 09:49:44', '2026-08-10 09:49:44'),
(13, 14, 'MEM-50606', '2026-02-08', '509 Swaniawski Heights Apt. 139\nKellyberg, DE 20518-8434', '1-931-230-4885', 'active', '2026-08-10 09:49:44', '2026-08-10 09:49:44'),
(14, 15, 'MEM-98523', '2025-08-23', '465 Aufderhar Grove Apt. 462\nTreutelburgh, NY 47105-9173', '+18175009252', 'active', '2026-08-10 09:49:45', '2026-08-10 09:49:45'),
(15, 16, 'MEM-32576', '2026-02-18', '35413 Jaycee Loaf\nAntwonmouth, MA 93916-0475', '+17865280410', 'active', '2026-08-10 09:49:45', '2026-08-10 09:49:45'),
(16, 17, 'MEM-13267', '2025-08-30', '983 Anya Flat\nArnoldmouth, NY 52367', '559.395.6795', 'active', '2026-08-10 09:49:46', '2026-08-10 09:49:46'),
(17, 18, 'MEM-29104', '2025-11-07', '42837 Vincent Roads\nEast Lolitatown, TX 57656', '+1 (458) 617-8826', 'active', '2026-08-10 09:49:46', '2026-08-10 09:49:46'),
(18, 19, 'MEM-53422', '2026-01-04', '9336 Weimann Square\nHeidenreichfurt, WV 73102', '985-840-5169', 'active', '2026-08-10 09:49:46', '2026-08-10 09:49:46'),
(19, 20, 'MEM-82779', '2026-07-31', '773 Murray Dale\nDayanaside, NC 38182-4357', '(727) 437-9034', 'active', '2026-08-10 09:49:47', '2026-08-10 09:49:47'),
(20, 21, 'MEM-36301', '2026-04-11', '7623 Benton Centers Apt. 176\nSouth Maynard, ID 52051-2024', '806-640-2798', 'active', '2026-08-10 09:49:47', '2026-08-10 09:49:47'),
(21, 22, 'MEM-59185', '2026-06-14', '1575 Bauch Plaza Suite 728\nLoumouth, OK 18307', '1-985-568-6356', 'active', '2026-08-10 09:49:47', '2026-08-10 09:49:47'),
(22, 23, 'MEM-33949', '2026-06-17', '332 Joaquin Roads\nNew Oswaldo, NE 17791-2373', '+1-660-312-1944', 'active', '2026-08-10 09:49:48', '2026-08-10 09:49:48'),
(23, 24, 'MEM-45057', '2026-05-23', '3395 Hamill Parks Apt. 843\nNew Rae, DE 52303', '202-575-2213', 'active', '2026-08-10 09:49:48', '2026-08-10 09:49:48'),
(24, 25, 'MEM-49111', '2026-02-21', '6747 Delphia Via\nNew Cleve, NC 72796', '+1-667-404-9803', 'active', '2026-08-10 09:49:49', '2026-08-10 09:49:49'),
(25, 26, 'MEM-24766', '2025-09-16', '565 Emmerich Summit Suite 336\nZiemeview, WA 72843', '+1.229.413.8224', 'active', '2026-08-10 09:49:49', '2026-08-10 09:49:49'),
(26, 27, 'MEM-48328', '2026-02-14', '58681 Dylan Hill\nNicolaport, NC 49990-8917', '(920) 453-3859', 'active', '2026-08-10 09:49:49', '2026-08-10 09:49:49'),
(27, 28, 'MEM-94735', '2026-06-07', '310 Ruthie Island Apt. 775\nNew Aiyanaberg, MN 51322-9096', '+13616280697', 'active', '2026-08-10 09:49:50', '2026-08-10 09:49:50'),
(28, 29, 'MEM-15093', '2026-06-20', '5056 Anastasia Inlet Apt. 896\nRobbview, MS 56011', '+1-762-831-0385', 'active', '2026-08-10 09:49:50', '2026-08-10 09:49:50'),
(29, 30, 'MEM-90140', '2025-11-17', '535 Kreiger Square Apt. 535\nNorth Prestonfort, SD 59255', '+1-757-788-7048', 'active', '2026-08-10 09:49:50', '2026-08-10 09:49:50'),
(30, 31, 'MEM-25937', '2025-10-31', '67046 Ashly Mill Apt. 218\nWest Vincenzaville, NC 74748', '+1 (551) 889-6607', 'active', '2026-08-10 09:49:51', '2026-08-10 09:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_23_174144_create_categories_table', 1),
(5, '2026_07_23_174532_create_authors_table', 1),
(6, '2026_07_23_174739_create_publishers_table', 1),
(7, '2026_07_23_174750_create_members_table', 1),
(8, '2026_07_23_174836_create_books_table', 1),
(9, '2026_07_23_175041_create_book_issues_table', 1),
(10, '2026_07_24_064638_add_role_to_users_table', 1),
(11, '2026_07_25_063521_create_notifications_table', 1),
(12, '2026_07_26_212615_add_avatar_to_users_table', 1),
(13, '2026_07_31_192451_create_supports_table', 1),
(14, '2026_08_09_034435_add_file_path_to_books_table', 1),
(15, '2026_08_09_203448_create_book_reservations_table', 1),
(16, '2026_08_09_220319_add_fine_status_and_waiver_reason_to_book_issues_table', 1),
(17, '2026_08_10_031101_create_fines_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `name`, `email`, `phone`, `address`, `website`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Abernathy, Langosh and Gerlach Publishing', 'hritchie@hill.com', '(765) 272-5956', '91130 Senger Hollow\nNew Randyborough, ME 86018-3536', 'https://www.abernathylangoshandgerlachpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(2, 'Hoeger-Macejkovic Publishing', 'zieme.adella@parker.net', '+1 (724) 658-0289', '4921 Cassin Plain Apt. 075\nKulasborough, WV 99530', 'https://www.hoeger-macejkovicpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(3, 'Bogisich, Miller and Hahn Publishing', 'schuppe.misty@beer.info', '+18209766157', '1816 Brielle Brook\nEast Isai, IA 33054-6828', 'https://www.bogisichmillerandhahnpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(4, 'Quigley Group Publishing', 'liza.dare@sanford.com', '980.824.2965', '12263 Pfannerstill Island Apt. 166\nBotsfordtown, MN 58845-1047', 'https://www.quigleygrouppublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(5, 'Rosenbaum, Wiegand and Weber Publishing', 'dnicolas@bauch.org', '1-854-235-5726', '649 Kailey Cape\nRoweborough, ME 66915', 'https://www.rosenbaumwiegandandweberpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(6, 'Upton-O\'Conner Publishing', 'nkub@ledner.com', '726-601-0870', '73084 Pamela Rue\nSouth Huldaside, CA 86004', 'https://www.upton-o\'connerpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(7, 'Brown, Durgan and Haag Publishing', 'iankunding@howe.com', '+14582521639', '217 Stanton Overpass\nMariaborough, NM 71676-2008', 'https://www.browndurganandhaagpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(8, 'Prosacco, Corkery and Grimes Publishing', 'okeefe.julian@mccullough.com', '(786) 781-1226', '38086 Albertha Canyon Apt. 034\nEast Reid, WY 97916-0452', 'https://www.prosaccocorkeryandgrimespublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(9, 'Steuber, Brekke and Friesen Publishing', 'elmira82@padberg.com', '573.585.6309', '2267 McDermott Street Apt. 485\nHyattfurt, PA 79428-5643', 'https://www.steuberbrekkeandfriesenpublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(10, 'VonRueden, Rosenbaum and Morissette Publishing', 'emanuel78@damore.com', '(660) 659-5625', '2329 Theo Parkways Suite 406\nNorth Althea, MD 00401', 'https://www.vonruedenrosenbaumandmorissettepublishing.com', 'active', '2026-08-10 09:49:40', '2026-08-10 09:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('FMoouCUB0lNGilyVcx2kdgMCjg95KM1SRuXG7YIr', 1, '127.0.0.1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI2akZ5VktYVEJIQWFJWG9TZ0o2OURUbVBHMU1IdFJkcm9KaE9FSlBQIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1786376519);

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','in_progress','resolved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('Admin','Member') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Member',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User 1', 'admin1@yopmail.com', NULL, 'Admin', '2026-08-10 09:49:39', '$2y$12$w78vdQEw2IMTdZ2QzSmMkuwNSBHHgW63VAcCGTJq3FXS02rrQsW.S', NULL, '2026-08-10 09:49:39', '2026-08-10 09:49:39'),
(2, 'Member User 1', 'member1@yopmail.com', NULL, 'Member', '2026-08-10 09:49:39', '$2y$12$2eFW14JhJTHFWDTFMcCb.e7CbE3ShtVExmWyRMlJzKOOuBduZ5/GK', NULL, '2026-08-10 09:49:39', '2026-08-10 09:49:39'),
(3, 'Christ Turner', 'erath@example.com', NULL, 'Member', NULL, '$2y$12$MJ5KtZrkJ6dAqVzRPw4SK.q5iv.FsFwtPEDMjwgxU3EMvTh/1pXxi', NULL, '2026-08-10 09:49:40', '2026-08-10 09:49:40'),
(4, 'Mrs. Monica Ondricka', 'hilpert.alessandra@example.org', NULL, 'Member', NULL, '$2y$12$nD98P5ZKbF3ZJBKIgaHnDOdc4UquqxxH/fBg9Z7p8YF.GOsriENl6', NULL, '2026-08-10 09:49:41', '2026-08-10 09:49:41'),
(5, 'Dallas Kuvalis', 'paige08@example.net', NULL, 'Member', NULL, '$2y$12$WhA.FKrwUPDvlxZ8uy/IOOEYexS73HoRdzcD4xeD8hnYFu6KqadB6', NULL, '2026-08-10 09:49:41', '2026-08-10 09:49:41'),
(6, 'Dr. Tiffany Reinger IV', 'gsteuber@example.net', NULL, 'Member', NULL, '$2y$12$vsfYzz9B9oeXTm.qdcmjfe4xUAL6vlodvf1996h562R2GqKg6Fsi6', NULL, '2026-08-10 09:49:42', '2026-08-10 09:49:42'),
(7, 'Alexys Luettgen', 'vandervort.johann@example.net', NULL, 'Member', NULL, '$2y$12$42vaXdt8SG7zq6nU/jCdEeZUCDoRrJ2TzpLlo.nyuKq94DV1D1JSK', NULL, '2026-08-10 09:49:42', '2026-08-10 09:49:42'),
(8, 'Miss Gilda Howell II', 'rolfson.alycia@example.com', NULL, 'Member', NULL, '$2y$12$xd7jmveHnapxPqaCt1P8Uuu3ZFRrpmHK5krxiaumeJ1D/6J7qagxe', NULL, '2026-08-10 09:49:42', '2026-08-10 09:49:42'),
(9, 'Alejandrin Stamm', 'olarson@example.org', NULL, 'Member', NULL, '$2y$12$0h/rYd2zfuz.v981fpswfuQApUReaJw88EMmmJif8IdAkUbznaYAS', NULL, '2026-08-10 09:49:43', '2026-08-10 09:49:43'),
(10, 'Prof. Matilde Wilderman I', 'utowne@example.com', NULL, 'Member', NULL, '$2y$12$MmkmbEaB5zffDoIIMamp9O3GuQbqtxmJ3KOgoBpQDLkEiLUKK2UUa', NULL, '2026-08-10 09:49:43', '2026-08-10 09:49:43'),
(11, 'Prof. Layne Zboncak', 'plittel@example.net', NULL, 'Member', NULL, '$2y$12$.Xt17ZbfZgznjdyuqq8niuiYNEa3knJVzoqlqKcKT59xewileDVA2', NULL, '2026-08-10 09:49:43', '2026-08-10 09:49:43'),
(12, 'Tito Olson', 'breitenberg.evangeline@example.net', NULL, 'Member', NULL, '$2y$12$Pyqz7DFqnSGXb7YFBkmgbO4yCtHsqI2fAPpaG7k59KgNTkpVLSsya', NULL, '2026-08-10 09:49:44', '2026-08-10 09:49:44'),
(13, 'Isobel Johns', 'aida.thiel@example.net', NULL, 'Member', NULL, '$2y$12$9kSM.WgqlonpNrfezFw40uf8xfrCYbEkKWjppnxyKnGoqDYugTgfO', NULL, '2026-08-10 09:49:44', '2026-08-10 09:49:44'),
(14, 'Miss Rhoda Oberbrunner', 'norwood.grimes@example.net', NULL, 'Member', NULL, '$2y$12$15.DTEMNWcgXQsuep2pdROCyUCF1okB91m4OadwCpf4x9DjA5Tt8W', NULL, '2026-08-10 09:49:44', '2026-08-10 09:49:44'),
(15, 'Lilian McDermott', 'clinton.braun@example.com', NULL, 'Member', NULL, '$2y$12$JR87LYjqltEns9xZCBZPY.wMwdPuww4mKhaePMppH9r1Q75pKneJK', NULL, '2026-08-10 09:49:45', '2026-08-10 09:49:45'),
(16, 'Mathilde Bailey V', 'johnson.jordi@example.net', NULL, 'Member', NULL, '$2y$12$yj/1JSice22zfJYeqva3nua6qB1aKg8wrC2QgG96QZWXFj/kKTd1m', NULL, '2026-08-10 09:49:45', '2026-08-10 09:49:45'),
(17, 'Florine Boyle', 'keyshawn93@example.net', NULL, 'Member', NULL, '$2y$12$GDRSr4/BCUKfNohYhdJsRu7e13dywNbrIbL0l8i1j0zlbLrGkI9CO', NULL, '2026-08-10 09:49:46', '2026-08-10 09:49:46'),
(18, 'Mr. Ernest Kassulke', 'marquardt.zaria@example.org', NULL, 'Member', NULL, '$2y$12$DGGZ6Ta5Jknu4P6YK/LwmOjW6gwG1FkucEaOEGHbm6NOoWthe6xSe', NULL, '2026-08-10 09:49:46', '2026-08-10 09:49:46'),
(19, 'Cassandra Wisoky', 'kelvin44@example.net', NULL, 'Member', NULL, '$2y$12$SSUp7zECv1D.cDVeT3MYVe4lXegpoZTEsCjjidIajH3Wx./XeRXju', NULL, '2026-08-10 09:49:46', '2026-08-10 09:49:46'),
(20, 'Jordane Kling', 'faye01@example.net', NULL, 'Member', NULL, '$2y$12$YOIVCEWugfsf2mhWgRF6y.UxnmcxzCh8QXG8b8Il03Vojb6x2KSQ6', NULL, '2026-08-10 09:49:47', '2026-08-10 09:49:47'),
(21, 'Dr. Myron Kirlin', 'athena.barton@example.org', NULL, 'Member', NULL, '$2y$12$z3ZTlEsGXnocUiKmtsGGyuLF3gHlJn.dm.gtT134LhperLrmCEYY.', NULL, '2026-08-10 09:49:47', '2026-08-10 09:49:47'),
(22, 'Breanna Ebert', 'alfonzo.hirthe@example.org', NULL, 'Member', NULL, '$2y$12$OfxVhynS.8MfvGgWZYcjD.KVOWDe7qbZQIkUqsw5HM9F.CapYT8pC', NULL, '2026-08-10 09:49:47', '2026-08-10 09:49:47'),
(23, 'Alba Mohr', 'mnitzsche@example.org', NULL, 'Member', NULL, '$2y$12$RNeMswp9gsbc7RZ6DRjQbOIp6yUAkCrIhlfErw3/Uxvdqx7dmbvB6', NULL, '2026-08-10 09:49:48', '2026-08-10 09:49:48'),
(24, 'Mathias Wiegand', 'raegan.medhurst@example.net', NULL, 'Member', NULL, '$2y$12$Jt9HV0QLdKVL94Xh.4XybeVdm2CVDC/UFIIgyWyZH3HdkcTdj5H8O', NULL, '2026-08-10 09:49:48', '2026-08-10 09:49:48'),
(25, 'Alvah Rohan', 'shields.ivory@example.com', NULL, 'Member', NULL, '$2y$12$ueogQuEB8UKm1pGT/kqaAO.IOTMDyQqcBu.9.etQPp2ev7efXzq1O', NULL, '2026-08-10 09:49:49', '2026-08-10 09:49:49'),
(26, 'Ozella Keeling I', 'dparisian@example.com', NULL, 'Member', NULL, '$2y$12$jJG7.AMnuiGRaxgxGRbhGef01vAvNdqeQskhNXysTOTA2LMIc07FS', NULL, '2026-08-10 09:49:49', '2026-08-10 09:49:49'),
(27, 'Casandra Willms', 'pat93@example.com', NULL, 'Member', NULL, '$2y$12$Xf3k2XudrT1.Dv0iYTPsWuelJZ5Z0nPNC0vgDiO84Zkok9XXcHExe', NULL, '2026-08-10 09:49:49', '2026-08-10 09:49:49'),
(28, 'Miss Camille Wunsch', 'dawson51@example.net', NULL, 'Member', NULL, '$2y$12$xULxNlScnRkK0wq19ncfm.xVouSFQd3YmhMZAO0Hve/Zx08v6sVV.', NULL, '2026-08-10 09:49:50', '2026-08-10 09:49:50'),
(29, 'Garfield Brakus', 'savion.hammes@example.com', NULL, 'Member', NULL, '$2y$12$vKZvs2SKLl8tNJknoRiMSehOJQDr/CHfqf8wnZgN3QnzeTTa9bMqe', NULL, '2026-08-10 09:49:50', '2026-08-10 09:49:50'),
(30, 'Armani Schuppe', 'bnader@example.net', NULL, 'Member', NULL, '$2y$12$IKE7fzD3SUcQBx3a4kJesuZrosNHLYNv.yyNd23puObjK3IdAt3Wa', NULL, '2026-08-10 09:49:50', '2026-08-10 09:49:50'),
(31, 'Bonnie Adams', 'mraz.tabitha@example.com', NULL, 'Member', NULL, '$2y$12$Ye/2RtdxHqZPXMtfg.3GaeeNV4sNDc6EhGeXGWWMoESYYQvYdamGi', NULL, '2026-08-10 09:49:51', '2026-08-10 09:49:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `authors_email_unique` (`email`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `books_isbn_unique` (`isbn`),
  ADD KEY `books_category_id_foreign` (`category_id`),
  ADD KEY `books_author_id_foreign` (`author_id`),
  ADD KEY `books_publisher_id_foreign` (`publisher_id`);

--
-- Indexes for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_issues_book_id_foreign` (`book_id`),
  ADD KEY `book_issues_member_id_foreign` (`member_id`);

--
-- Indexes for table `book_reservations`
--
ALTER TABLE `book_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_reservations_book_id_foreign` (`book_id`),
  ADD KEY `book_reservations_member_id_foreign` (`member_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fines_user_id_foreign` (`user_id`),
  ADD KEY `fines_book_issue_id_foreign` (`book_issue_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_membership_no_unique` (`membership_no`),
  ADD KEY `members_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `publishers_email_unique` (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supports_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `book_issues`
--
ALTER TABLE `book_issues`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `book_reservations`
--
ALTER TABLE `book_reservations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_issues`
--
ALTER TABLE `book_issues`
  ADD CONSTRAINT `book_issues_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_issues_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `book_reservations`
--
ALTER TABLE `book_reservations`
  ADD CONSTRAINT `book_reservations_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_reservations_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fines_book_issue_id_foreign` FOREIGN KEY (`book_issue_id`) REFERENCES `book_issues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fines_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supports`
--
ALTER TABLE `supports`
  ADD CONSTRAINT `supports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
