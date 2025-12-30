-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2025 at 07:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phonebook_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `action_type` enum('contact_add','contact_edit','contact_delete','group_add','group_edit','group_delete','group_member_add','group_member_remove','template_add','template_edit','template_delete','import_contacts','export_contacts','import_group_members','message_sent') NOT NULL,
  `details` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `severity` enum('info','success','warning','danger') DEFAULT 'info',
  `user_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `action_type`, `details`, `timestamp`, `is_read`, `severity`, `user_id`) VALUES
(301, 'message_sent', 'SMS sent to 1 recipient(s).', '2025-12-30 13:51:27', 0, 'info', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `phone`, `email`, `address`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Alice Johnson', '+12345678901', 'alice.j@example.com', '123 Main St, New York, NY', 'VIP client', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(2, 'Bob Smith', '+12345678902', 'bob.smith@gmail.com', '456 Oak Ave, Los Angeles, CA', 'Regular customer', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(3, 'Carol White', '+12345678903', 'carol.white@outlook.com', '789 Pine Rd, Chicago, IL', 'Prefers email', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(4, 'David Brown', '+12345678904', 'david.brown@yahoo.com', '321 Elm St, Houston, TX', 'Business partner', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(5, 'Emma Davis', '+12345678905', 'emma.davis@hotmail.com', '654 Maple Dr, Phoenix, AZ', 'Birthday: March 15', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(6, 'Frank Garcia', '+12345678906', 'frank.g@example.com', '987 Cedar Ln, Philadelphia, PA', 'Tech enthusiast', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(7, 'Grace Miller', '+12345678907', 'grace.m@company.com', '147 Birch Blvd, San Antonio, TX', 'Marketing lead', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(8, 'Henry Wilson', '+12345678908', 'henry.w@gmail.com', '258 Spruce Way, San Diego, CA', 'Loyal since 2020', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(9, 'Isabella Moore', '+12345678909', 'isabella.m@domain.com', '369 Walnut Ct, Dallas, TX', 'Family friend', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(10, 'James Taylor', '+12345678910', 'james.taylor@work.com', '741 Cherry Ave, San Jose, CA', 'Project manager', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(11, 'Katherine Anderson', '+12345678911', 'kate.a@example.com', '852 Poplar St, Austin, TX', 'Prefers SMS', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(12, 'Liam Thomas', '+12345678912', 'liam.thomas@gmail.com', '963 Willow Rd, Jacksonville, FL', 'Gym buddy', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(13, 'Mia Jackson', '+12345678913', 'mia.j@outlook.com', '159 Sycamore Dr, Fort Worth, TX', 'New subscriber', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(14, 'Noah Martinez', '+12345678914', 'noah.m@yahoo.com', '753 Alder Pl, Columbus, OH', 'Early adopter', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(15, 'Olivia Hernandez', '+12345678915', 'olivia.h@company.org', '951 Magnolia Blvd, Charlotte, NC', 'Event attendee', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(16, 'Patrick Lopez', '+12345678916', 'patrick.l@gmail.com', '357 Cypress St, Indianapolis, IN', 'Referral', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(17, 'Quinn Perez', '+12345678917', 'quinn.p@example.com', '468 Palm Ave, San Francisco, CA', 'Influencer', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(18, 'Riley Gonzalez', '+12345678918', 'riley.g@domain.net', '579 Redwood Dr, Seattle, WA', 'Beta tester', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(19, 'Sophia Wilson', '+12345678919', 'sophia.w@hotmail.com', '680 Sequoia Ln, Denver, CO', 'Long-term client', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(20, 'Tyler Lee', '+12345678920', 'tyler.lee@biz.com', '791 Aspen Ct, Washington, DC', 'Potential investor', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(21, 'Patrick Herrera', '+7809532793', 'patrick.herrera@gmail.com', '731 Main St, Yekaterinburg, RU', 'Prefers SMS', '2025-10-08 05:55:37', '2025-10-08 05:55:37'),
(22, 'Chen Morales', '+8103505561', 'chen.morales@org.net', '613 Birch Blvd, Yokohama, JP', 'Loyal since 2020', '2025-05-29 14:09:47', '2025-05-29 14:09:47'),
(23, 'Raj Anderson', '+8681421824', 'raj.anderson@mail.ru', '652 Main St, Wuhan, CN', 'VIP client', '2025-03-26 11:39:53', '2025-03-26 11:39:53'),
(24, 'Priya Morales', '+4464390001', 'priya.morales@biz.com', '124 Main St, Edinburgh, UK', 'Referral', '2025-02-03 03:25:07', '2025-02-03 03:25:07'),
(25, 'Vikram Morales', '+3394455707', 'vikram.morales@outlook.com', '464 Oak Ave, Paris, FR', 'Prefers email', '2025-09-13 16:26:10', '2025-09-13 16:26:10'),
(26, 'Pedro Davis', '+4487778865', 'pedro.davis@biz.com', '382 Elm St, Leicester, UK', 'Referral', '2025-03-23 17:21:47', '2025-03-23 17:21:47'),
(27, 'Patrick Taylor', '+4955395288', 'patrick.taylor@outlook.com', '900 Cedar Ln, Stuttgart, DE', 'Tech enthusiast', '2025-11-14 16:00:58', '2025-11-14 16:00:58'),
(28, 'Emma Smith', '+9122141869', 'emma.smith@domain.com', '889 Pine Rd, Pune, IN', 'Regular customer', '2025-03-24 05:55:07', '2025-03-24 05:55:07'),
(29, 'Anita Morales', '+5526076990', 'anita.morales@yahoo.com', '563 Walnut Ct, Porto Alegre, BR', 'Loyal since 2020', '2025-05-12 21:15:07', '2025-05-12 21:15:07'),
(30, 'David Anderson', '+4408769971', 'david.anderson@mail.ru', '142 Elm St, Leeds, UK', 'New subscriber', '2025-12-21 16:22:02', '2025-12-21 16:22:02'),
(31, 'Wei Johnson', '+5556087096', 'wei.johnson@org.net', '335 Main St, Belo Horizonte, BR', 'Prefers email', '2025-07-01 09:20:00', '2025-07-01 09:20:00'),
(32, 'Alejandro Ortiz', '+9157906743', 'alejandro.ortiz@domain.com', '742 Birch Blvd, Pune, IN', 'Prefers email', '2025-01-16 08:33:53', '2025-01-16 08:33:53'),
(33, 'Vikram Rodriguez', '+3359467278', 'vikram.rodriguez@company.com', '187 Walnut Ct, Toulouse, FR', 'Loyal since 2020', '2025-03-06 23:42:16', '2025-03-06 23:42:16'),
(34, 'Yumi Miller', '+5580096078', 'yumi.miller@yahoo.com', '269 Walnut Ct, Recife, BR', 'Regular customer', '2025-06-03 13:29:47', '2025-06-03 13:29:47'),
(35, 'Diego Ramirez', '+8607180706', 'diego.ramirez@gmail.com', '772 Spruce Way, Chongqing, CN', 'Referral', '2025-11-05 14:46:42', '2025-11-05 14:46:42'),
(36, 'Quinn Suarez', '+4449945550', 'quinn.suarez@org.net', '572 Cherry Ave, London, UK', 'Regular customer', '2025-04-25 05:58:27', '2025-04-25 05:58:27'),
(37, 'Alice Gomez', '+3348235997', 'alice.gomez@biz.com', '524 Maple Dr, Strasbourg, FR', 'None', '2025-10-15 16:19:43', '2025-10-15 16:19:43'),
(38, 'Giulia Thomas', '+7533986806', 'giulia.thomas@biz.com', '943 Elm St, Kazan, RU', 'Long-term client', '2025-10-16 16:31:09', '2025-10-16 16:31:09'),
(39, 'Lucia Moore', '+3337939999', 'lucia.moore@company.com', '609 Oak Ave, Lille, FR', 'Marketing lead', '2025-02-19 13:34:56', '2025-02-19 13:34:56'),
(40, 'Sophia White', '+5557840070', 'sophia.white@mail.ru', '388 Maple Dr, Salvador, BR', 'Regular customer', '2025-03-06 11:57:15', '2025-03-06 11:57:15'),
(41, 'Lucia White', '+4915044684', 'lucia.white@outlook.com', '565 Maple Dr, Hamburg, DE', 'Family friend', '2025-10-23 15:52:02', '2025-10-23 15:52:02'),
(42, 'Carlos Morales', '+1383003702', 'carlos.morales@mail.ru', '791 Maple Dr, San Diego, US', 'Event attendee', '2025-02-10 13:18:25', '2025-02-10 13:18:25'),
(43, 'Riley Jackson', '+3305957649', 'riley.jackson@mail.ru', '250 Main St, Lyon, FR', 'Project manager', '2025-06-03 14:10:19', '2025-06-03 14:10:19'),
(44, 'Ivan Brown', '+8117504222', 'ivan.brown@company.com', '665 Oak Ave, Yokohama, JP', 'Long-term client', '2025-04-12 12:13:32', '2025-04-12 12:13:32'),
(45, 'Riley Lee', '+5591259655', 'riley.lee@hotmail.com', '105 Cedar Ln, Curitiba, BR', 'Early adopter', '2025-09-25 08:37:05', '2025-09-25 08:37:05'),
(46, 'Chen White', '+8635446473', 'chen.white@outlook.com', '136 Cedar Ln, Shenzhen, CN', 'New subscriber', '2025-09-28 14:13:18', '2025-09-28 14:13:18'),
(47, 'Yumi Perez', '+8651301935', 'yumi.perez@mail.ru', '449 Main St, Beijing, CN', 'Tech enthusiast', '2025-03-08 11:44:08', '2025-03-08 11:44:08'),
(48, 'Tyler Rivera', '+4452264853', 'tyler.rivera@example.com', '481 Maple Dr, London, UK', 'Regular customer', '2025-08-08 06:28:29', '2025-08-08 06:28:29'),
(49, 'Quinn Alvarez', '+1236299305', 'quinn.alvarez@domain.com', '529 Cherry Ave, Los Angeles, US', 'Beta tester', '2025-05-30 02:55:36', '2025-05-30 02:55:36'),
(50, 'Alejandro Smith', '+1593320766', 'alejandro.smith@hotmail.com', '210 Main St, San Diego, US', 'VIP client', '2025-02-07 22:12:09', '2025-02-07 22:12:09'),
(51, 'Patrick Moore', '+5503033215', 'patrick.moore@org.net', '230 Elm St, Brasília, BR', 'New subscriber', '2025-11-24 14:00:05', '2025-11-24 14:00:05'),
(52, 'Olivia Hernandez', '+5506320353', 'olivia.hernandez@hotmail.com', '101 Oak Ave, Fortaleza, BR', 'Prefers email', '2025-09-14 20:02:35', '2025-09-14 20:02:35'),
(53, 'Ahmed Vasquez', '+9199069496', 'ahmed.vasquez@outlook.com', '389 Main St, Chennai, IN', 'Family friend', '2025-07-14 20:37:45', '2025-07-14 20:37:45'),
(54, 'Bob Garcia', '+8127729079', 'bob.garcia@org.net', '357 Birch Blvd, Kobe, JP', 'Prefers email', '2025-12-28 06:36:05', '2025-12-28 06:36:05'),
(55, 'Wei Garcia', '+9145885911', 'wei.garcia@hotmail.com', '257 Birch Blvd, Hyderabad, IN', 'Prefers email', '2025-06-01 16:14:19', '2025-06-01 16:14:19'),
(56, 'Katherine Medina', '+4944182198', 'katherine.medina@yahoo.com', '709 Cedar Ln, Munich, DE', 'Influencer', '2025-03-04 21:45:39', '2025-03-04 21:45:39'),
(57, 'Sophia Thomas', '+4415549458', 'sophia.thomas@hotmail.com', '408 Maple Dr, Glasgow, UK', 'Family friend', '2025-12-25 08:29:49', '2025-12-25 08:29:49'),
(58, 'Alejandro Ramos', '+1542110388', 'alejandro.ramos@company.com', '450 Elm St, Philadelphia, US', 'Project manager', '2025-05-31 19:22:15', '2025-05-31 19:22:15'),
(59, 'Yumi Gutierrez', '+9161171456', 'yumi.gutierrez@hotmail.com', '731 Spruce Way, Surat, IN', 'Regular customer', '2025-11-27 14:41:20', '2025-11-27 14:41:20'),
(60, 'Katherine Gutierrez', '+9150433443', 'katherine.gutierrez@hotmail.com', '111 Cedar Ln, Mumbai, IN', 'Project manager', '2025-04-10 12:22:17', '2025-04-10 12:22:17'),
(61, 'Olivia Suarez', '+9119479961', 'olivia.suarez@biz.com', '172 Birch Blvd, Mumbai, IN', 'Long-term client', '2025-07-06 09:42:20', '2025-07-06 09:42:20'),
(62, 'Luca Reyes', '+8694203441', 'luca.reyes@company.com', '293 Pine Rd, Shanghai, CN', 'Influencer', '2025-09-29 08:09:04', '2025-09-29 08:09:04'),
(63, 'Ivan Sanchez', '+1327941039', 'ivan.sanchez@yahoo.com', '715 Cherry Ave, Philadelphia, US', 'Marketing lead', '2025-02-01 23:07:29', '2025-02-01 23:07:29'),
(64, 'Maria Ramos', '+8608279272', 'maria.ramos@hotmail.com', '661 Cedar Ln, Beijing, CN', 'Project manager', '2025-02-20 22:28:01', '2025-02-20 22:28:01'),
(65, 'Alejandro Reyes', '+9154617938', 'alejandro.reyes@hotmail.com', '289 Cedar Ln, Jaipur, IN', 'Regular customer', '2025-11-03 20:28:05', '2025-11-03 20:28:05'),
(66, 'Lucia Flores', '+8623824922', 'lucia.flores@outlook.com', '750 Walnut Ct, Chengdu, CN', 'Referral', '2025-03-24 13:44:53', '2025-03-24 13:44:53'),
(67, 'Mei Suarez', '+8105426010', 'mei.suarez@hotmail.com', '637 Main St, Fukuoka, JP', 'Referral', '2025-03-29 03:14:33', '2025-03-29 03:14:33'),
(68, 'Carlos Miller', '+7359421278', 'carlos.miller@domain.com', '417 Cherry Ave, Novosibirsk, RU', 'Long-term client', '2025-01-31 18:29:17', '2025-01-31 18:29:17'),
(69, 'Pedro Vasquez', '+3342349281', 'pedro.vasquez@domain.com', '654 Main St, Montpellier, FR', 'Family friend', '2025-08-20 10:06:10', '2025-08-20 10:06:10'),
(70, 'Pedro Miller', '+7164632543', 'pedro.miller@mail.ru', '910 Pine Rd, Moscow, RU', 'Birthday: March 15', '2025-03-06 08:27:27', '2025-03-06 08:27:27'),
(71, 'Liam Lee', '+1709895603', 'liam.lee@yahoo.com', '200 Cherry Ave, Los Angeles, US', 'New subscriber', '2025-10-08 13:39:44', '2025-10-08 13:39:44'),
(72, 'Luca Ramirez', '+8666777698', 'luca.ramirez@yahoo.com', '199 Main St, Chongqing, CN', 'Birthday: March 15', '2025-12-11 18:56:27', '2025-12-11 18:56:27'),
(73, 'Isabella Thomas', '+4400665566', 'isabella.thomas@mail.ru', '373 Pine Rd, London, UK', 'Tech enthusiast', '2025-10-08 20:09:26', '2025-10-08 20:09:26'),
(74, 'Carlos Rivera', '+7923000047', 'carlos.rivera@domain.com', '450 Main St, Chelyabinsk, RU', 'Business partner', '2025-04-14 07:11:04', '2025-04-14 07:11:04'),
(75, 'Jean Rivera', '+7860485279', 'jean.rivera@yahoo.com', '992 Cherry Ave, Omsk, RU', 'Influencer', '2025-08-09 06:05:38', '2025-08-09 06:05:38'),
(76, 'Riley Castro', '+4488343827', 'riley.castro@outlook.com', '938 Pine Rd, Liverpool, UK', 'Event attendee', '2025-01-24 06:17:25', '2025-01-24 06:17:25'),
(77, 'David Castillo', '+9186341549', 'david.castillo@biz.com', '255 Elm St, Kolkata, IN', 'Project manager', '2025-10-27 22:24:49', '2025-10-27 22:24:49'),
(78, 'Aisha Thomas', '+1137034736', 'aisha.thomas@example.com', '597 Birch Blvd, Los Angeles, US', 'Project manager', '2025-07-20 18:25:38', '2025-07-20 18:25:38'),
(79, 'Diego Ramos', '+3361815183', 'diego.ramos@company.com', '875 Elm St, Strasbourg, FR', 'Beta tester', '2025-01-10 17:22:21', '2025-01-10 17:22:21'),
(80, 'Olga Moreno', '+5250571099', 'olga.moreno@mail.ru', '821 Cherry Ave, Torreón, MX', 'Referral', '2025-04-16 10:42:59', '2025-04-16 10:42:59'),
(81, 'Riley Moreno', '+7536317195', 'riley.moreno@mail.ru', '824 Elm St, Saint Petersburg, RU', 'Beta tester', '2025-11-25 05:08:39', '2025-11-25 05:08:39'),
(82, 'Maria Sanchez', '+1328647157', 'maria.sanchez@org.net', '403 Elm St, Chicago, US', 'Loyal since 2020', '2025-05-24 17:28:04', '2025-05-24 17:28:04'),
(83, 'Olivia Cruz', '+4476874705', 'olivia.cruz@mail.ru', '886 Walnut Ct, Birmingham, UK', 'Birthday: March 15', '2025-07-22 08:24:38', '2025-07-22 08:24:38'),
(84, 'Giulia Johnson', '+8197957348', 'giulia.johnson@company.com', '281 Birch Blvd, Yokohama, JP', 'Marketing lead', '2025-07-17 19:08:11', '2025-07-17 19:08:11'),
(85, 'Chen Alvarez', '+3361991869', 'chen.alvarez@yahoo.com', '691 Birch Blvd, Bordeaux, FR', 'Influencer', '2025-04-08 14:13:17', '2025-04-08 14:13:17'),
(86, 'Grace Gomez', '+3388453336', 'grace.gomez@mail.ru', '347 Cedar Ln, Paris, FR', 'Birthday: March 15', '2025-03-04 16:08:47', '2025-03-04 16:08:47'),
(87, 'Quinn Suarez', '+9167197894', 'quinn.suarez@yahoo.com', '333 Spruce Way, Delhi, IN', 'Family friend', '2025-07-06 15:41:25', '2025-07-06 15:41:25'),
(88, 'Alice Wilson', '+1772400912', 'alice.wilson@outlook.com', '367 Elm St, San Jose, US', 'Gym buddy', '2025-08-14 14:52:29', '2025-08-14 14:52:29'),
(89, 'Ivan Anderson', '+8644619980', 'ivan.anderson@domain.com', '887 Cedar Ln, Chongqing, CN', 'Prefers email', '2025-07-07 21:17:02', '2025-07-07 21:17:02'),
(90, 'Patrick Gonzalez', '+4486887904', 'patrick.gonzalez@gmail.com', '802 Oak Ave, Leeds, UK', 'Project manager', '2025-06-07 04:45:43', '2025-06-07 04:45:43'),
(91, 'Kenji Johnson', '+4477902401', 'kenji.johnson@hotmail.com', '306 Pine Rd, Birmingham, UK', 'None', '2025-11-06 08:30:37', '2025-11-06 08:30:37'),
(92, 'Alice Ramos', '+8679615655', 'alice.ramos@example.com', '189 Main St, Chongqing, CN', 'Long-term client', '2025-12-12 07:05:32', '2025-12-12 07:05:32'),
(93, 'Mia Romero', '+4951813798', 'mia.romero@example.com', '127 Walnut Ct, Frankfurt, DE', 'Prefers email', '2025-09-24 22:38:22', '2025-09-24 22:38:22'),
(94, 'Frank Castro', '+9158855350', 'frank.castro@org.net', '455 Elm St, Surat, IN', 'Potential investor', '2025-11-24 13:35:56', '2025-11-24 13:35:56'),
(95, 'Olivia Perez', '+4403140549', 'olivia.perez@mail.ru', '811 Main St, Glasgow, UK', 'Event attendee', '2025-01-22 14:58:44', '2025-01-22 14:58:44'),
(96, 'Jean Moore', '+8649548269', 'jean.moore@example.com', '892 Birch Blvd, Guangzhou, CN', 'New subscriber', '2025-07-15 07:21:09', '2025-07-15 07:21:09'),
(97, 'Sophia Gutierrez', '+9164414373', 'sophia.gutierrez@mail.ru', '784 Cedar Ln, Pune, IN', 'Referral', '2025-08-31 19:00:36', '2025-08-31 19:00:36'),
(98, 'Pedro Rivera', '+5206639342', 'pedro.rivera@domain.com', '565 Spruce Way, Guadalajara, MX', 'Loyal since 2020', '2025-06-26 06:04:32', '2025-06-26 06:04:32'),
(99, 'Anita Ruiz', '+4921675486', 'anita.ruiz@mail.ru', '208 Main St, Leipzig, DE', 'Prefers SMS', '2025-04-23 00:18:39', '2025-04-23 00:18:39'),
(100, 'Anna Vasquez', '+4953808028', 'anna.vasquez@example.com', '636 Oak Ave, Essen, DE', 'Birthday: March 15', '2025-02-01 14:21:16', '2025-02-01 14:21:16'),
(101, 'Aisha Smith', '+8138519104', 'aisha.smith@yahoo.com', '360 Elm St, Fukuoka, JP', 'New subscriber', '2025-08-18 22:18:44', '2025-08-18 22:18:44'),
(102, 'Lucia Thomas', '+4969063999', 'lucia.thomas@yahoo.com', '312 Elm St, Cologne, DE', 'Birthday: March 15', '2025-04-12 22:05:00', '2025-04-12 22:05:00'),
(103, 'Aisha Gonzalez', '+1034875686', 'aisha.gonzalez@biz.com', '275 Cherry Ave, San Antonio, US', 'Beta tester', '2025-05-24 03:58:54', '2025-05-24 03:58:54'),
(104, 'Isabella Davis', '+8676101978', 'isabella.davis@org.net', '467 Main St, Tianjin, CN', 'VIP client', '2025-12-10 17:19:28', '2025-12-10 17:19:28'),
(105, 'Isabella Thomas', '+7586459651', 'isabella.thomas@biz.com', '489 Elm St, Moscow, RU', 'Early adopter', '2025-06-13 12:54:02', '2025-06-13 12:54:02'),
(106, 'Olivia Ruiz', '+1678137639', 'olivia.ruiz@mail.ru', '807 Pine Rd, Los Angeles, US', 'Project manager', '2025-09-29 18:16:08', '2025-09-29 18:16:08'),
(107, 'Ling Anderson', '+5211525801', 'ling.anderson@mail.ru', '970 Spruce Way, Guadalajara, MX', 'Tech enthusiast', '2025-01-20 17:20:11', '2025-01-20 17:20:11'),
(108, 'Liam Gonzalez', '+1860101664', 'liam.gonzalez@domain.com', '155 Walnut Ct, Chicago, US', 'Marketing lead', '2025-02-24 22:31:43', '2025-02-24 22:31:43'),
(109, 'Isabel Moreno', '+9146560358', 'isabel.moreno@org.net', '276 Walnut Ct, Chennai, IN', 'Early adopter', '2025-07-30 17:30:06', '2025-07-30 17:30:06'),
(110, 'Kenji Brown', '+5252583930', 'kenji.brown@yahoo.com', '314 Pine Rd, Puebla, MX', 'Influencer', '2025-06-10 07:46:27', '2025-06-10 07:46:27'),
(111, 'James Lopez', '+5248038043', 'james.lopez@example.com', '782 Maple Dr, Monterrey, MX', 'Gym buddy', '2025-03-07 18:28:11', '2025-03-07 18:28:11'),
(112, 'Frank Jimenez', '+4403906175', 'frank.jimenez@yahoo.com', '424 Pine Rd, Leeds, UK', 'Beta tester', '2025-01-12 18:01:46', '2025-01-12 18:01:46'),
(113, 'Mia Romero', '+1291804275', 'mia.romero@domain.com', '907 Elm St, San Jose, US', 'Early adopter', '2025-03-15 14:08:27', '2025-03-15 14:08:27'),
(114, 'Wei Rivera', '+5593231892', 'wei.rivera@org.net', '312 Elm St, Porto Alegre, BR', 'Long-term client', '2025-11-27 04:13:42', '2025-11-27 04:13:42'),
(115, 'Raj Miller', '+8613673595', 'raj.miller@hotmail.com', '590 Birch Blvd, Tianjin, CN', 'Influencer', '2025-06-19 00:46:32', '2025-06-19 00:46:32'),
(116, 'Raj Martinez', '+7652831892', 'raj.martinez@company.com', '906 Birch Blvd, Kazan, RU', 'Beta tester', '2025-10-12 02:20:55', '2025-10-12 02:20:55'),
(117, 'Raj Torres', '+4473750633', 'raj.torres@hotmail.com', '299 Spruce Way, Glasgow, UK', 'Loyal since 2020', '2025-08-21 01:10:55', '2025-08-21 01:10:55'),
(118, 'Marie Moreno', '+7510050188', 'marie.moreno@gmail.com', '828 Spruce Way, Saint Petersburg, RU', 'Prefers SMS', '2025-11-16 08:49:29', '2025-11-16 08:49:29'),
(119, 'Noah Gonzalez', '+7727681764', 'noah.gonzalez@hotmail.com', '808 Cedar Ln, Yekaterinburg, RU', 'Tech enthusiast', '2025-09-22 03:48:51', '2025-09-22 03:48:51'),
(120, 'Olivia Ruiz', '+8113127289', 'olivia.ruiz@outlook.com', '305 Pine Rd, Sapporo, JP', 'Beta tester', '2025-12-03 23:37:53', '2025-12-03 23:37:53');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'VIP Clients', 'High-value customers who receive exclusive offers', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(2, 'Newsletter Subscribers', 'All users signed up for monthly updates', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(3, 'Family & Friends', 'Personal contacts', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(4, 'Business Partners', 'Companies and collaborators', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(5, 'Event Attendees 2025', 'People who attended our December launch event', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(6, 'Premium Clients', 'Exclusive high-value clients', '2025-09-01 09:05:27', '2025-09-01 09:05:27'),
(7, 'Active Subscribers', 'Engaged newsletter recipients', '2025-03-08 05:20:24', '2025-03-08 05:20:24'),
(8, 'Close Friends', 'Personal close contacts', '2025-06-30 13:52:04', '2025-06-30 13:52:04'),
(9, 'Strategic Partners', 'Key business collaborators', '2025-08-30 21:15:55', '2025-08-30 21:15:55'),
(10, 'Launch Event 2025', 'Attendees of the 2025 product launch', '2025-06-20 13:30:44', '2025-06-20 13:30:44'),
(11, 'Tech Enthusiasts', 'Users interested in new technology', '2025-07-20 01:59:29', '2025-07-20 01:59:29'),
(12, 'Marketing Team', 'Internal marketing department contacts', '2025-09-13 15:41:47', '2025-09-13 15:41:47'),
(13, 'Sales Leads', 'Potential customers in pipeline', '2025-12-12 06:36:54', '2025-12-12 06:36:54'),
(14, 'Customer Support', 'Users who frequently contact support', '2025-12-06 18:39:33', '2025-12-06 18:39:33'),
(15, 'Beta Testers', 'Early access product testers', '2025-03-26 13:59:35', '2025-03-26 13:59:35'),
(16, 'Investors', 'Current and potential investors', '2025-07-21 04:32:02', '2025-07-21 04:32:02'),
(17, 'Local Community', 'Nearby residents and local businesses', '2025-05-11 03:51:00', '2025-05-11 03:51:00'),
(18, 'International Partners', 'Overseas collaborators and distributors', '2025-04-30 11:39:13', '2025-04-30 11:39:13'),
(19, 'Holiday List 2025', 'Contacts for holiday greetings', '2025-05-21 09:31:23', '2025-05-21 09:31:23'),
(20, 'Birthday Club', 'Contacts with recorded birthdays', '2025-07-19 05:20:39', '2025-07-19 05:20:39'),
(21, 'Feedback Panel', 'Users who provide regular feedback', '2025-08-30 06:20:59', '2025-08-30 06:20:59'),
(22, 'Premium Members', 'Paid subscription tier members', '2025-09-15 00:10:46', '2025-09-15 00:10:46'),
(23, 'New Registrations', 'Users who signed up in the last 30 days', '2025-02-21 09:29:55', '2025-02-21 09:29:55'),
(24, 'Alumni Network', 'Past customers and event attendees', '2025-01-01 05:19:28', '2025-01-01 05:19:28'),
(25, 'Volunteers', 'People helping with events and initiatives', '2025-07-07 05:53:08', '2025-07-07 05:53:08');

-- --------------------------------------------------------

--
-- Table structure for table `group_members`
--

CREATE TABLE `group_members` (
  `group_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `role` enum('member','deputy leader','leader','treasurer','secretary') NOT NULL DEFAULT 'member',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_members`
--

INSERT INTO `group_members` (`group_id`, `contact_id`, `role`, `added_at`) VALUES
(1, 1, 'leader', '2025-12-27 13:36:51'),
(1, 4, 'deputy leader', '2025-12-27 13:36:51'),
(1, 7, 'treasurer', '2025-12-27 13:36:51'),
(1, 19, 'secretary', '2025-12-27 13:36:51'),
(1, 23, 'treasurer', '2025-01-04 07:07:14'),
(1, 36, 'treasurer', '2025-10-14 09:31:52'),
(1, 38, 'leader', '2025-10-13 23:59:29'),
(1, 51, 'secretary', '2025-10-03 01:46:12'),
(1, 56, 'leader', '2025-07-15 04:31:20'),
(1, 81, 'leader', '2025-01-04 06:13:10'),
(2, 1, 'member', '2025-01-15 09:09:03'),
(2, 2, 'leader', '2025-12-27 13:36:51'),
(2, 3, 'deputy leader', '2025-12-27 13:36:51'),
(2, 5, 'member', '2025-12-27 13:36:51'),
(2, 8, 'member', '2025-12-27 13:36:51'),
(2, 11, 'member', '2025-12-27 13:36:51'),
(2, 13, 'member', '2025-12-27 13:36:51'),
(2, 14, 'member', '2025-12-27 13:36:51'),
(2, 18, 'member', '2025-12-27 13:36:51'),
(2, 20, 'member', '2025-12-27 13:36:51'),
(2, 59, 'deputy leader', '2025-04-18 09:49:29'),
(2, 62, 'leader', '2025-11-30 10:51:14'),
(2, 66, 'treasurer', '2025-04-24 07:54:35'),
(2, 69, 'member', '2025-10-18 06:56:40'),
(2, 70, 'deputy leader', '2025-07-10 17:18:34'),
(2, 76, 'member', '2025-12-27 06:52:50'),
(2, 83, 'deputy leader', '2025-08-22 21:54:16'),
(2, 86, 'deputy leader', '2025-03-26 13:40:35'),
(2, 87, 'deputy leader', '2025-11-06 17:13:28'),
(2, 99, 'member', '2025-09-10 00:52:37'),
(2, 105, 'secretary', '2025-01-07 04:07:11'),
(3, 9, 'leader', '2025-12-27 13:36:51'),
(3, 10, 'member', '2025-11-09 17:12:56'),
(3, 12, 'member', '2025-12-27 13:36:51'),
(3, 16, 'member', '2025-12-27 13:36:51'),
(3, 52, 'member', '2025-07-21 18:11:14'),
(3, 58, 'treasurer', '2025-10-07 10:34:06'),
(3, 104, 'member', '2025-01-10 09:01:26'),
(3, 115, 'leader', '2025-06-20 06:24:07'),
(4, 4, 'leader', '2025-12-27 13:36:51'),
(4, 10, 'member', '2025-12-27 13:36:51'),
(4, 15, 'deputy leader', '2025-07-31 11:27:31'),
(4, 20, 'member', '2025-12-27 13:36:51'),
(4, 23, 'treasurer', '2025-09-17 11:03:36'),
(4, 36, 'deputy leader', '2025-04-14 13:06:50'),
(4, 78, 'deputy leader', '2025-10-25 06:54:06'),
(4, 84, 'treasurer', '2025-04-17 21:44:20'),
(4, 85, 'secretary', '2025-02-02 18:27:34'),
(5, 1, 'leader', '2025-12-27 13:36:51'),
(5, 6, 'member', '2025-12-27 13:36:51'),
(5, 10, 'member', '2025-07-15 05:04:01'),
(5, 15, 'member', '2025-12-27 13:36:51'),
(5, 17, 'member', '2025-12-27 13:36:51'),
(5, 28, 'leader', '2025-06-16 16:08:12'),
(5, 34, 'treasurer', '2025-12-11 00:55:40'),
(5, 103, 'treasurer', '2025-05-12 03:04:05'),
(5, 114, 'treasurer', '2025-05-31 02:43:58'),
(5, 115, 'member', '2025-10-01 08:17:26'),
(6, 8, 'secretary', '2025-07-15 19:25:12'),
(6, 38, 'member', '2025-08-23 21:45:24'),
(6, 40, 'deputy leader', '2025-09-09 11:15:47'),
(6, 51, 'deputy leader', '2025-02-13 09:49:16'),
(6, 53, 'secretary', '2025-12-13 23:12:09'),
(6, 63, 'deputy leader', '2025-03-28 02:00:09'),
(6, 66, 'treasurer', '2025-07-30 10:08:53'),
(6, 75, 'leader', '2025-03-24 06:40:24'),
(6, 77, 'treasurer', '2025-06-22 04:38:27'),
(6, 90, 'deputy leader', '2025-09-23 14:25:40'),
(6, 98, 'secretary', '2025-06-26 09:22:26'),
(6, 116, 'secretary', '2025-11-15 12:08:14'),
(7, 3, 'leader', '2025-11-19 02:52:20'),
(7, 8, 'leader', '2025-08-31 08:28:12'),
(7, 24, 'secretary', '2025-06-03 01:17:54'),
(7, 43, 'secretary', '2025-06-03 17:06:31'),
(7, 44, 'deputy leader', '2025-11-27 02:12:32'),
(7, 48, 'secretary', '2025-12-14 00:33:39'),
(7, 58, 'treasurer', '2025-10-08 01:53:31'),
(7, 106, 'member', '2025-10-01 17:35:12'),
(8, 3, 'treasurer', '2025-03-15 12:19:30'),
(8, 11, 'secretary', '2025-04-29 02:53:21'),
(8, 13, 'member', '2025-03-07 11:46:03'),
(8, 68, 'deputy leader', '2025-07-19 16:08:15'),
(8, 75, 'leader', '2025-09-30 04:51:28'),
(8, 77, 'member', '2025-06-26 19:09:27'),
(8, 78, 'deputy leader', '2025-02-14 03:48:25'),
(8, 82, 'member', '2025-04-07 06:10:34'),
(8, 92, 'deputy leader', '2025-05-24 06:24:55'),
(8, 94, 'secretary', '2025-07-30 21:41:08'),
(8, 97, 'leader', '2025-06-19 23:49:16'),
(8, 102, 'treasurer', '2025-01-26 17:17:04'),
(8, 107, 'leader', '2025-10-17 00:32:44'),
(9, 2, 'deputy leader', '2025-10-12 18:49:18'),
(9, 3, 'member', '2025-07-12 02:32:03'),
(9, 23, 'member', '2025-07-12 19:13:11'),
(9, 51, 'leader', '2025-04-24 17:48:33'),
(9, 86, 'deputy leader', '2025-04-24 21:05:45'),
(10, 13, 'leader', '2025-07-20 14:08:18'),
(10, 15, 'deputy leader', '2025-06-23 05:44:32'),
(10, 18, 'secretary', '2025-12-25 15:39:31'),
(10, 42, 'leader', '2025-09-28 04:24:16'),
(10, 101, 'treasurer', '2025-03-02 17:30:05'),
(10, 117, 'deputy leader', '2025-08-04 23:02:17'),
(11, 2, 'member', '2025-04-02 14:18:53'),
(11, 3, 'member', '2025-03-19 15:21:15'),
(11, 21, 'member', '2025-05-16 04:27:28'),
(11, 26, 'deputy leader', '2025-08-02 19:39:35'),
(11, 29, 'secretary', '2025-05-29 13:56:33'),
(11, 34, 'secretary', '2025-09-03 19:41:18'),
(11, 38, 'treasurer', '2025-03-10 00:46:17'),
(11, 39, 'treasurer', '2025-07-17 20:49:19'),
(11, 41, 'secretary', '2025-01-01 19:26:57'),
(11, 50, 'member', '2025-09-03 20:24:12'),
(11, 65, 'leader', '2025-03-17 12:45:00'),
(11, 67, 'treasurer', '2025-05-04 17:16:57'),
(11, 78, 'treasurer', '2025-01-31 23:41:02'),
(11, 115, 'deputy leader', '2025-08-22 03:32:01'),
(11, 116, 'deputy leader', '2025-12-25 07:31:18'),
(12, 7, 'leader', '2025-06-11 07:12:47'),
(12, 22, 'secretary', '2025-06-22 19:02:40'),
(12, 44, 'deputy leader', '2025-01-30 15:46:45'),
(12, 75, 'deputy leader', '2025-11-21 21:10:52'),
(12, 99, 'member', '2025-06-19 15:50:50'),
(12, 105, 'treasurer', '2025-12-19 09:29:17'),
(13, 1, 'deputy leader', '2025-10-22 15:37:24'),
(13, 14, 'deputy leader', '2025-07-29 02:09:35'),
(13, 21, 'leader', '2025-04-14 17:31:56'),
(13, 29, 'deputy leader', '2025-05-20 21:14:40'),
(13, 40, 'deputy leader', '2025-05-04 00:03:18'),
(13, 55, 'treasurer', '2025-08-22 03:25:49'),
(13, 59, 'secretary', '2025-02-10 09:02:55'),
(13, 65, 'member', '2025-07-21 12:51:53'),
(13, 76, 'deputy leader', '2025-03-06 23:23:28'),
(13, 83, 'secretary', '2025-12-23 13:17:40'),
(13, 86, 'secretary', '2025-07-11 00:24:08'),
(13, 87, 'treasurer', '2025-03-28 11:51:25'),
(13, 89, 'secretary', '2025-04-22 15:53:52'),
(13, 97, 'deputy leader', '2025-04-02 17:43:12'),
(13, 117, 'treasurer', '2025-03-30 16:17:53'),
(14, 1, 'deputy leader', '2025-04-16 12:28:12'),
(14, 4, 'secretary', '2025-10-06 20:44:20'),
(14, 9, 'member', '2025-10-23 10:13:53'),
(14, 18, 'member', '2025-11-05 20:50:31'),
(14, 59, 'treasurer', '2025-04-08 15:41:57'),
(14, 64, 'leader', '2025-12-26 06:04:22'),
(14, 66, 'member', '2025-12-01 23:47:29'),
(14, 68, 'secretary', '2025-02-21 23:53:37'),
(14, 77, 'deputy leader', '2025-04-07 20:02:35'),
(14, 88, 'treasurer', '2025-03-07 07:24:00'),
(14, 111, 'leader', '2025-10-05 04:42:28'),
(15, 10, 'treasurer', '2025-05-15 18:32:35'),
(15, 17, 'leader', '2025-01-08 16:29:57'),
(15, 24, 'treasurer', '2025-11-16 05:14:11'),
(15, 32, 'treasurer', '2025-09-01 12:38:53'),
(15, 34, 'treasurer', '2025-04-23 21:29:41'),
(15, 51, 'member', '2025-07-19 09:28:47'),
(15, 55, 'treasurer', '2025-08-09 19:31:22'),
(15, 56, 'leader', '2025-08-16 04:35:17'),
(15, 57, 'deputy leader', '2025-03-25 07:32:10'),
(15, 60, 'leader', '2025-05-19 01:15:02'),
(15, 73, 'secretary', '2025-03-05 09:05:23'),
(15, 96, 'treasurer', '2025-01-11 02:06:39'),
(15, 117, 'deputy leader', '2025-11-07 12:29:01'),
(16, 13, 'deputy leader', '2025-10-15 13:58:53'),
(16, 17, 'leader', '2025-11-30 16:08:27'),
(16, 35, 'leader', '2025-07-02 07:49:58'),
(16, 40, 'deputy leader', '2025-05-13 18:37:03'),
(16, 93, 'deputy leader', '2025-11-05 05:54:32'),
(16, 110, 'treasurer', '2025-10-10 13:49:44'),
(17, 8, 'leader', '2025-07-10 13:43:06'),
(17, 29, 'treasurer', '2025-01-16 09:29:57'),
(17, 49, 'member', '2025-08-01 07:20:58'),
(17, 57, 'deputy leader', '2025-11-03 04:48:49'),
(17, 65, 'leader', '2025-12-26 20:44:27'),
(17, 77, 'member', '2025-10-09 06:40:40'),
(18, 2, 'deputy leader', '2025-04-23 05:57:47'),
(18, 30, 'secretary', '2025-02-08 09:36:08'),
(18, 31, 'secretary', '2025-11-14 19:18:40'),
(18, 54, 'treasurer', '2025-11-23 03:34:18'),
(18, 56, 'deputy leader', '2025-08-14 07:35:11'),
(18, 88, 'deputy leader', '2025-02-24 17:22:36'),
(18, 112, 'treasurer', '2025-02-23 23:59:46'),
(19, 6, 'leader', '2025-12-29 08:42:48'),
(19, 9, 'treasurer', '2025-05-09 18:11:03'),
(19, 12, 'leader', '2025-09-20 12:23:20'),
(19, 37, 'secretary', '2025-02-13 19:43:25'),
(19, 41, 'treasurer', '2025-08-24 20:51:26'),
(19, 43, 'treasurer', '2025-05-03 00:52:06'),
(19, 47, 'treasurer', '2025-05-18 19:14:38'),
(19, 48, 'member', '2025-06-08 03:45:49'),
(19, 77, 'deputy leader', '2025-05-21 19:37:06'),
(19, 87, 'member', '2025-09-28 20:24:49'),
(19, 93, 'leader', '2025-01-21 20:14:05'),
(19, 98, 'treasurer', '2025-07-12 22:22:26'),
(19, 112, 'leader', '2025-10-09 03:27:49'),
(19, 118, 'leader', '2025-09-27 04:53:32'),
(19, 120, 'secretary', '2025-12-27 03:56:31'),
(20, 14, 'leader', '2025-05-15 05:56:18'),
(20, 24, 'treasurer', '2025-03-19 20:46:20'),
(20, 31, 'secretary', '2025-12-05 19:05:18'),
(20, 49, 'member', '2025-12-27 19:51:52'),
(20, 87, 'leader', '2025-08-30 00:10:08'),
(20, 110, 'treasurer', '2025-10-10 20:58:13'),
(20, 117, 'leader', '2025-09-28 03:49:35'),
(20, 118, 'treasurer', '2025-11-25 02:38:51'),
(20, 120, 'member', '2025-10-17 09:00:39'),
(21, 3, 'secretary', '2025-01-30 17:48:30'),
(21, 5, 'deputy leader', '2025-02-05 04:34:47'),
(21, 34, 'treasurer', '2025-10-27 22:34:46'),
(21, 61, 'secretary', '2025-09-13 23:57:18'),
(21, 63, 'member', '2025-06-03 09:18:23'),
(21, 110, 'deputy leader', '2025-10-23 04:37:06'),
(22, 9, 'secretary', '2025-05-28 21:03:29'),
(22, 17, 'leader', '2025-08-18 10:11:36'),
(22, 19, 'treasurer', '2025-12-23 07:10:47'),
(22, 40, 'deputy leader', '2025-06-28 04:00:20'),
(22, 56, 'treasurer', '2025-01-22 17:28:07'),
(22, 92, 'deputy leader', '2025-03-03 12:17:15'),
(22, 96, 'deputy leader', '2025-04-25 11:37:41'),
(22, 101, 'deputy leader', '2025-02-11 09:09:47'),
(22, 108, 'treasurer', '2025-11-29 20:26:25'),
(23, 2, 'member', '2025-09-12 00:00:08'),
(23, 52, 'leader', '2025-12-14 12:48:45'),
(23, 55, 'treasurer', '2025-01-09 20:59:28'),
(23, 57, 'secretary', '2025-09-17 13:13:14'),
(23, 62, 'member', '2025-06-10 07:41:06'),
(23, 84, 'deputy leader', '2025-07-18 13:03:15'),
(23, 92, 'leader', '2025-07-12 18:15:24'),
(23, 106, 'treasurer', '2025-11-01 03:48:34'),
(24, 2, 'treasurer', '2025-08-02 15:08:48'),
(24, 27, 'secretary', '2025-06-08 10:59:23'),
(24, 44, 'secretary', '2025-06-12 01:01:51'),
(24, 45, 'member', '2025-04-14 23:57:36'),
(24, 70, 'treasurer', '2025-09-10 16:14:52'),
(24, 80, 'deputy leader', '2025-12-10 07:39:57'),
(24, 83, 'leader', '2025-12-05 01:49:32'),
(24, 86, 'secretary', '2025-04-12 02:43:10'),
(24, 98, 'deputy leader', '2025-07-09 16:02:49'),
(24, 102, 'leader', '2025-05-21 08:38:07'),
(24, 106, 'treasurer', '2025-09-11 23:07:39'),
(24, 108, 'member', '2025-07-21 02:43:05'),
(24, 112, 'leader', '2025-09-11 04:49:09'),
(25, 4, 'member', '2025-04-05 09:11:18'),
(25, 20, 'treasurer', '2025-10-29 00:47:54'),
(25, 41, 'secretary', '2025-01-12 19:21:45'),
(25, 43, 'deputy leader', '2025-04-29 08:58:22'),
(25, 47, 'leader', '2025-05-20 06:47:34'),
(25, 69, 'leader', '2025-01-19 10:30:14'),
(25, 85, 'member', '2025-12-05 01:06:26'),
(25, 119, 'treasurer', '2025-03-01 18:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `sent_messages`
--

CREATE TABLE `sent_messages` (
  `id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `message_content` text NOT NULL,
  `recipients` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('sent','failed','blocked') NOT NULL DEFAULT 'sent',
  `message_type` enum('single','bulk','group') NOT NULL DEFAULT 'single',
  `scheduled_at` datetime DEFAULT NULL,
  `channel` enum('sms','email','whatsapp') DEFAULT 'sms',
  `email_subject` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sent_messages`
--

INSERT INTO `sent_messages` (`id`, `template_id`, `message_content`, `recipients`, `sent_at`, `status`, `message_type`, `scheduled_at`, `channel`, `email_subject`) VALUES
(1, 1, 'Hello Alice Johnson...\n\nWelcome...', '1', '2025-12-23 10:32:50', 'sent', 'single', NULL, 'sms', NULL),
(2, 3, 'Exclusive Offer for Bob Smith!...\n\nGet 20% off...', '2,3,5', '2025-12-23 10:32:50', 'sent', 'single', NULL, 'sms', NULL),
(3, 5, 'Dear Carol White...\n\nWishing you...', '1,4,7,19', '2025-12-23 10:32:50', 'sent', 'single', NULL, 'sms', NULL),
(4, 4, 'Hi Emma Davis...\n\nDon’t forget...', '1,6,15,17', '2025-12-23 10:32:50', 'sent', 'single', NULL, 'sms', NULL),
(5, 2, 'Happy Birthday, Grace Miller!...', '7', '2025-12-23 10:32:50', 'sent', 'single', NULL, 'sms', NULL),
(6, 8, 'Thank you, Henry Wilson!...\n\nWe truly appreciate...', '8,11', '2025-12-23 10:32:50', 'sent', 'single', NULL, 'sms', NULL),
(7, 5, 'Message content 1', '120,93,114,18,47', '2025-10-28 22:17:27', 'blocked', 'single', NULL, 'sms', NULL),
(8, 16, 'Message content 2', '91,63,37', '2025-05-31 08:12:31', 'failed', 'group', NULL, 'sms', NULL),
(9, 4, 'Message content 3', '75', '2025-12-28 00:14:35', 'failed', 'bulk', NULL, 'sms', NULL),
(10, 23, 'Message content 4', '89,92', '2025-04-10 21:30:57', 'blocked', 'single', NULL, 'sms', NULL),
(11, 8, 'Message content 5', '30,20', '2025-07-30 09:26:40', 'sent', 'group', NULL, 'sms', NULL),
(12, NULL, 'Message content 6', '70', '2025-08-03 22:10:50', 'blocked', 'single', NULL, 'sms', NULL),
(13, 1, 'Message content 7', '45,21,112,91,26', '2025-11-02 11:53:42', 'blocked', 'single', NULL, 'sms', NULL),
(14, 9, 'Message content 8', '20,93,87,28,18', '2025-10-29 08:48:06', 'failed', 'single', NULL, 'sms', NULL),
(15, 17, 'Message content 9', '106,11,113,87', '2025-10-11 11:12:37', 'blocked', 'group', NULL, 'sms', NULL),
(16, 24, 'Message content 10', '82,115,13', '2025-06-20 05:09:45', 'sent', 'bulk', NULL, 'sms', NULL),
(17, 15, 'Message content 11', '88,19,93', '2025-06-26 19:03:49', 'sent', 'bulk', NULL, 'sms', NULL),
(18, 15, 'Message content 12', '86,61,71,92', '2025-05-22 11:18:39', 'failed', 'bulk', NULL, 'sms', NULL),
(19, 11, 'Message content 13', '43,65,18,61', '2025-03-23 15:58:18', 'failed', 'bulk', NULL, 'sms', NULL),
(20, 23, 'Message content 14', '100,107,61,71', '2025-10-09 21:46:27', 'sent', 'bulk', NULL, 'sms', NULL),
(21, 7, 'Message content 15', '2,105,39,112,85', '2025-07-01 10:53:27', 'blocked', 'single', NULL, 'sms', NULL),
(22, 13, 'Message content 16', '48,61,31,19,30', '2025-09-04 11:20:40', 'sent', 'single', NULL, 'sms', NULL),
(23, 6, 'Message content 17', '115', '2025-01-21 23:33:00', 'blocked', 'bulk', NULL, 'sms', NULL),
(24, 11, 'Message content 18', '14,97,81', '2025-02-08 12:48:13', 'failed', 'group', NULL, 'sms', NULL),
(25, 9, 'Message content 19', '17,116,73,5', '2025-08-13 04:38:08', 'failed', 'group', NULL, 'sms', NULL),
(26, 21, 'Message content 20', '7,9', '2025-05-14 04:21:04', 'sent', 'group', NULL, 'sms', NULL),
(27, 20, 'Message content 21', '45,26', '2025-08-03 12:13:36', 'failed', 'single', NULL, 'sms', NULL),
(28, 7, 'Message content 22', '49,81,27,86', '2025-07-09 19:34:03', 'blocked', 'bulk', NULL, 'sms', NULL),
(29, 1, 'Message content 23', '34,21,99', '2025-09-18 18:57:05', 'failed', 'group', NULL, 'sms', NULL),
(30, 14, 'Message content 24', '115,108,94,60', '2025-09-18 18:57:05', 'sent', 'single', NULL, 'sms', NULL),
(31, 14, 'Message content 25', '96,46,29,84,120', '2025-05-01 02:49:55', 'failed', 'bulk', NULL, 'sms', NULL),
(32, 23, 'Message content 26', '51,111', '2025-03-25 11:20:28', 'failed', 'group', NULL, 'sms', NULL),
(33, 3, 'Message content 27', '87', '2025-11-10 07:00:37', 'sent', 'bulk', NULL, 'sms', NULL),
(34, 13, 'Message content 28', '108,28', '2025-01-19 06:53:39', 'sent', 'bulk', NULL, 'sms', NULL),
(35, 18, 'Message content 29', '105,21', '2025-07-16 14:25:56', 'sent', 'group', NULL, 'sms', NULL),
(36, 16, 'Message content 30', '65,27,71,38', '2025-01-10 11:21:19', 'blocked', 'bulk', NULL, 'sms', NULL),
(37, 9, 'Message content 31', '49,85,111,33', '2025-12-01 11:22:23', 'sent', 'single', NULL, 'sms', NULL),
(38, 16, 'Message content 32', '32', '2025-01-21 04:09:11', 'failed', 'group', NULL, 'sms', NULL),
(39, 12, 'Message content 33', '6,81,65,15', '2025-02-20 23:16:56', 'blocked', 'single', NULL, 'sms', NULL),
(40, 8, 'Message content 34', '36', '2025-05-22 17:32:06', 'failed', 'group', NULL, 'sms', NULL),
(41, 1, 'Message content 35', '23,17', '2025-12-16 07:27:43', 'failed', 'bulk', NULL, 'sms', NULL),
(42, 7, 'Message content 36', '110,112', '2025-11-29 09:27:44', 'blocked', 'single', NULL, 'sms', NULL),
(43, 15, 'Message content 37', '69,75,35,106,109', '2025-12-25 00:36:56', 'sent', 'bulk', NULL, 'sms', NULL),
(44, 15, 'Message content 38', '50,104,112,13', '2025-10-27 18:08:14', 'sent', 'single', NULL, 'sms', NULL),
(45, 6, 'Message content 39', '59,68,71,29', '2025-05-28 06:32:20', 'blocked', 'single', NULL, 'sms', NULL),
(46, 14, 'Message content 40', '118', '2025-03-24 22:27:06', 'blocked', 'bulk', NULL, 'sms', NULL),
(47, 25, 'Message content 41', '17', '2025-08-27 20:01:06', 'blocked', 'bulk', NULL, 'sms', NULL),
(48, 6, 'Message content 42', '16,59', '2025-08-11 18:07:49', 'blocked', 'single', NULL, 'sms', NULL),
(49, 18, 'Message content 43', '114', '2025-06-26 12:23:15', 'failed', 'bulk', NULL, 'sms', NULL),
(50, 9, 'Message content 44', '71,116,23', '2025-04-22 07:59:00', 'failed', 'group', NULL, 'sms', NULL),
(51, 7, 'Message content 45', '29,4', '2025-11-24 14:04:26', 'failed', 'bulk', NULL, 'sms', NULL),
(52, 14, 'Message content 46', '90,52,109', '2025-02-17 00:57:35', 'blocked', 'single', NULL, 'sms', NULL),
(53, 12, 'Message content 47', '32,86,23', '2025-12-16 12:52:03', 'sent', 'single', NULL, 'sms', NULL),
(54, 21, 'Message content 48', '13,17,91,55', '2025-04-18 13:36:00', 'sent', 'group', NULL, 'sms', NULL),
(55, 3, 'Message content 49', '38,52,5,77,30', '2025-12-24 08:59:14', 'blocked', 'single', NULL, 'sms', NULL),
(56, 4, 'Message content 50', '2', '2025-11-18 02:20:18', 'sent', 'bulk', NULL, 'sms', NULL),
(57, 22, 'Message content 51', '107,77,41,6,111', '2025-03-30 01:24:13', 'sent', 'group', NULL, 'sms', NULL),
(58, 7, 'Message content 52', '54,59,118', '2025-04-21 11:40:52', 'failed', 'single', NULL, 'sms', NULL),
(59, 24, 'Message content 53', '10,113', '2025-08-25 19:15:21', 'failed', 'group', NULL, 'sms', NULL),
(60, 22, 'Message content 54', '94,120,89', '2025-04-24 03:10:37', 'blocked', 'single', NULL, 'sms', NULL),
(61, 25, 'Message content 55', '48,58', '2025-10-22 03:26:23', 'blocked', 'single', NULL, 'sms', NULL),
(62, 24, 'Message content 56', '79,35,6', '2025-07-06 14:14:28', 'failed', 'single', NULL, 'sms', NULL),
(63, 24, 'Message content 57', '16,118,74', '2025-04-13 05:04:14', 'sent', 'bulk', NULL, 'sms', NULL),
(64, 5, 'Message content 58', '32,116,66,34', '2025-03-10 02:23:42', 'failed', 'bulk', NULL, 'sms', NULL),
(65, 21, 'Message content 59', '6,27', '2025-03-18 17:11:49', 'blocked', 'bulk', NULL, 'sms', NULL),
(66, 18, 'Message content 60', '41,38,64,63', '2025-12-11 08:28:29', 'blocked', 'bulk', NULL, 'sms', NULL),
(67, 2, 'Message content 61', '24,75,113', '2025-10-26 16:01:42', 'sent', 'bulk', NULL, 'sms', NULL),
(68, 5, 'Message content 62', '13,23', '2025-01-26 12:34:58', 'sent', 'bulk', NULL, 'sms', NULL),
(69, 25, 'Message content 63', '103,31', '2025-01-17 23:29:15', 'failed', 'single', NULL, 'sms', NULL),
(70, 4, 'Message content 64', '75,38,92', '2025-04-09 04:03:08', 'failed', 'group', NULL, 'sms', NULL),
(71, 24, 'Message content 65', '89,29', '2025-06-28 01:13:22', 'blocked', 'group', NULL, 'sms', NULL),
(72, 4, 'Message content 66', '20,17', '2025-08-20 09:17:51', 'blocked', 'bulk', NULL, 'sms', NULL),
(73, 21, 'Message content 67', '14,51,104', '2025-03-11 12:02:13', 'blocked', 'bulk', NULL, 'sms', NULL),
(74, 5, 'Message content 68', '62', '2025-06-07 14:22:06', 'failed', 'group', NULL, 'sms', NULL),
(75, 13, 'Message content 69', '100,94,32,81', '2025-10-31 01:02:04', 'blocked', 'single', NULL, 'sms', NULL),
(76, 14, 'Message content 70', '29,48,30,8,84', '2025-03-28 23:55:04', 'sent', 'single', NULL, 'sms', NULL),
(77, 11, 'Message content 71', '66,111,42,39,88', '2025-01-25 08:02:06', 'failed', 'bulk', NULL, 'sms', NULL),
(78, 18, 'Message content 72', '81', '2025-07-13 09:38:11', 'blocked', 'group', NULL, 'sms', NULL),
(79, 23, 'Message content 73', '118,40,119,90,24', '2025-10-09 00:27:51', 'failed', 'group', NULL, 'sms', NULL),
(80, 24, 'Message content 74', '19,60,91', '2025-10-25 17:29:55', 'blocked', 'bulk', NULL, 'sms', NULL),
(81, 1, 'Message content 75', '69', '2025-10-05 01:18:43', 'failed', 'group', NULL, 'sms', NULL),
(82, 1, 'Message content 76', '88,94,11,20,41', '2025-06-16 07:50:48', 'blocked', 'bulk', NULL, 'sms', NULL),
(83, 12, 'Message content 77', '17,102,63,25', '2025-02-27 08:49:51', 'sent', 'bulk', NULL, 'sms', NULL),
(84, 14, 'Message content 78', '93', '2025-12-12 01:59:04', 'sent', 'bulk', NULL, 'sms', NULL),
(85, 24, 'Message content 79', '87,102,85,81,30', '2025-06-07 06:20:26', 'blocked', 'group', NULL, 'sms', NULL),
(86, 3, 'Message content 80', '7,87,34', '2025-06-11 22:00:15', 'sent', 'bulk', NULL, 'sms', NULL),
(87, 9, 'Message content 81', '111,78,89,31', '2025-08-12 05:38:23', 'sent', 'group', NULL, 'sms', NULL),
(88, 17, 'Message content 82', '60,95', '2025-04-02 01:43:44', 'sent', 'single', NULL, 'sms', NULL),
(89, 15, 'Message content 83', '116,71', '2025-12-12 04:16:16', 'sent', 'group', NULL, 'sms', NULL),
(90, 15, 'Message content 84', '2,27,85,116', '2025-03-08 22:39:02', 'sent', 'single', NULL, 'sms', NULL),
(91, 24, 'Message content 85', '2', '2025-10-05 16:21:28', 'failed', 'bulk', NULL, 'sms', NULL),
(92, 4, 'Message content 86', '18,37,102', '2025-10-25 13:07:18', 'sent', 'group', NULL, 'sms', NULL),
(93, 1, 'Message content 87', '50,38,66,2', '2025-10-31 22:15:20', 'sent', 'group', NULL, 'sms', NULL),
(94, 12, 'Message content 88', '109,30,114,90', '2025-10-13 06:07:02', 'blocked', 'single', NULL, 'sms', NULL),
(95, 13, 'Message content 89', '15,116,90,98,84', '2025-11-19 16:06:08', 'failed', 'bulk', NULL, 'sms', NULL),
(96, 25, 'Message content 90', '71,66,97', '2025-01-15 17:49:26', 'failed', 'group', NULL, 'sms', NULL),
(97, 12, 'Message content 91', '2', '2025-10-27 16:11:20', 'sent', 'single', NULL, 'sms', NULL),
(98, 7, 'Message content 92', '42,7,96', '2025-02-26 04:41:51', 'sent', 'bulk', NULL, 'sms', NULL),
(99, NULL, 'Message content 93', '5', '2025-01-28 14:14:26', 'sent', 'single', NULL, 'sms', NULL),
(100, 21, 'Message content 94', '41,101', '2025-12-11 02:46:49', 'blocked', 'group', NULL, 'sms', NULL),
(101, 7, 'Message content 95', '23', '2025-08-14 15:46:47', 'failed', 'single', NULL, 'sms', NULL),
(102, 13, 'Message content 96', '53,107,66,55,77', '2025-05-21 02:27:22', 'failed', 'bulk', NULL, 'sms', NULL),
(103, 20, 'Message content 97', '18,119,34', '2025-03-04 23:56:37', 'sent', 'single', NULL, 'sms', NULL),
(104, 15, 'Message content 98', '74,72,51,108', '2025-07-25 19:24:39', 'failed', 'bulk', NULL, 'sms', NULL),
(105, 12, 'Message content 99', '8', '2025-07-06 08:24:40', 'failed', 'single', NULL, 'sms', NULL),
(106, 22, 'Message content 100', '64,86,104,2', '2025-04-13 18:01:08', 'failed', 'bulk', NULL, 'sms', NULL),
(107, NULL, 'Content for Birthday Greeting: Hello Jim, this is a sample message.', '+254711230692', '2025-12-30 13:51:27', 'sent', 'single', NULL, 'sms', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_key` varchar(50) NOT NULL,
  `value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `value`) VALUES
('admin_email', 'admin@example.com'),
('api_key', 'your_default_api_key'),
('app_name', 'Phonebook Admin');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `system_name` varchar(255) NOT NULL DEFAULT 'Phonebook System',
  `admin_email` varchar(255) NOT NULL DEFAULT 'admin@mail.com',
  `timezone` varchar(100) NOT NULL DEFAULT 'Asia/Manila',
  `theme` varchar(20) NOT NULL DEFAULT 'light'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `system_name`, `admin_email`, `timezone`, `theme`) VALUES
(1, 'Phonebook Admin', 'admin@example.com', 'Asia/Manila', 'light');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Welcome Message', 'Hello {name},\n\nWelcome to our community! We are thrilled to have you on board.\n\nBest regards,\nThe Team', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(2, 'Birthday Greeting', 'Happy Birthday, {name}!\n\nWishing you a fantastic year ahead filled with joy and success.\n\nWarm wishes,\nYour Friends', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(3, 'Promotion Alert', 'Exclusive Offer for {name}!\n\nGet 20% off your next purchase. Use code VIP20 at checkout.\n\nHurry – limited time!', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(4, 'Event Reminder', 'Hi {name},\n\nDon’t forget: Our big event is tomorrow at 7 PM!\n\nWe can\'t wait to see you there.', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(5, 'Holiday Wishes', 'Dear {name},\n\nWishing you and your loved ones a joyful holiday season and a prosperous New Year!\n\nHappy Holidays!', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(6, 'Feedback Request', 'Hello {name},\n\nWe value your opinion! Could you spare 2 minutes to share your feedback?\n\n[Survey Link]', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(7, 'Payment Reminder', 'Hi {name},\n\nThis is a friendly reminder that your invoice is due in 3 days.\n\nThank you for your prompt attention.', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(8, 'Thank You Note', 'Thank you, {name}!\n\nWe truly appreciate your recent purchase and continued support.\n\nLooking forward to serving you again.', '2025-12-23 10:32:49', '2025-12-23 10:32:49'),
(9, 'Event Reminder (Copy)', 'Hi {name},\n\nDon’t forget: Our big event is tomorrow at 7 PM!\n\nWe can\'t wait to see you there.', '2025-12-27 13:28:24', '2025-12-27 13:28:24'),
(10, 'Welcome Message', 'Content for Welcome Message: Hello {name}, this is a sample message.', '2025-06-26 04:43:03', '2025-06-26 04:43:03'),
(11, 'Birthday Greeting', 'Content for Birthday Greeting: Hello {name}, this is a sample message.', '2025-07-18 09:25:24', '2025-07-18 09:25:24'),
(12, 'Promotion Alert', 'Content for Promotion Alert: Hello {name}, this is a sample message.', '2025-03-03 02:43:02', '2025-03-03 02:43:02'),
(13, 'Event Reminder', 'Content for Event Reminder: Hello {name}, this is a sample message.', '2025-10-07 13:38:21', '2025-10-07 13:38:21'),
(14, 'Holiday Wishes', 'Content for Holiday Wishes: Hello {name}, this is a sample message.', '2025-11-08 19:31:07', '2025-11-08 19:31:07'),
(15, 'Feedback Request', 'Content for Feedback Request: Hello {name}, this is a sample message.', '2025-07-07 12:41:14', '2025-07-07 12:41:14'),
(16, 'Payment Reminder', 'Content for Payment Reminder: Hello {name}, this is a sample message.', '2025-10-20 04:36:49', '2025-10-20 04:36:49'),
(17, 'Thank You Note', 'Content for Thank You Note: Hello {name}, this is a sample message.', '2025-06-10 00:50:59', '2025-06-10 00:50:59'),
(18, 'Newsletter Update', 'Content for Newsletter Update: Hello {name}, this is a sample message.', '2025-08-28 01:03:44', '2025-08-28 01:03:44'),
(19, 'Product Launch', 'Content for Product Launch: Hello {name}, this is a sample message.', '2025-05-28 00:21:11', '2025-05-28 00:21:11'),
(20, 'Survey Invitation', 'Content for Survey Invitation: Hello {name}, this is a sample message.', '2025-01-25 02:55:42', '2025-01-25 02:55:42'),
(21, 'Account Verification', 'Content for Account Verification: Hello {name}, this is a sample message.', '2025-07-30 14:26:30', '2025-07-30 14:26:30'),
(22, 'Password Reset', 'Content for Password Reset: Hello {name}, this is a sample message.', '2025-05-14 18:01:15', '2025-05-14 18:01:15'),
(23, 'Order Confirmation', 'Content for Order Confirmation: Hello {name}, this is a sample message.', '2025-04-06 18:15:47', '2025-04-06 18:15:47'),
(24, 'Shipping Update', 'Content for Shipping Update: Hello {name}, this is a sample message.', '2025-11-04 04:39:15', '2025-11-04 04:39:15'),
(25, 'Cancellation Notice', 'Content for Cancellation Notice: Hello {name}, this is a sample message.', '2025-10-30 06:39:44', '2025-10-30 06:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bio` text DEFAULT NULL,
  `theme` varchar(20) DEFAULT 'light',
  `profile_pic` varchar(255) DEFAULT NULL,
  `2fa_enabled` tinyint(1) DEFAULT 0,
  `notifications_enabled` tinyint(1) DEFAULT 1,
  `two_fa_enabled` tinyint(1) DEFAULT 0,
  `notify_system` tinyint(1) DEFAULT 1,
  `notify_security` tinyint(1) DEFAULT 1,
  `notify_messaging` tinyint(1) DEFAULT 1,
  `notify_activity` tinyint(1) DEFAULT 0,
  `two_fa_code` varchar(6) DEFAULT NULL,
  `two_fa_expiry` datetime DEFAULT NULL,
  `auto_backup` tinyint(1) DEFAULT 1,
  `role` varchar(50) DEFAULT NULL,
  `weather_city` varchar(100) DEFAULT 'Nairobi',
  `subscription_plan` varchar(50) DEFAULT 'Free',
  `subscription_status` enum('Active','Expired','Pending') DEFAULT 'Active',
  `renewal_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `bio`, `theme`, `profile_pic`, `2fa_enabled`, `notifications_enabled`, `two_fa_enabled`, `notify_system`, `notify_security`, `notify_messaging`, `notify_activity`, `two_fa_code`, `two_fa_expiry`, `auto_backup`, `role`, `weather_city`, `subscription_plan`, `subscription_status`, `renewal_date`) VALUES
(1, 'school_admin', 'jimmuri99@gmail.com', '$2y$10$NsK5x5Ltl42WQX2oA/ipZOG.0ummjFUk2hCH1ZRDeTxICBsqgAQSS', '2025-12-27 14:11:18', '', 'light', 'profile_1_1766934129.png', 0, 1, 1, 1, 1, 1, 0, '187757', '2025-12-28 16:32:37', 1, NULL, 'Nairobi', 'Pro', 'Active', '2026-01-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `group_members`
--
ALTER TABLE `group_members`
  ADD PRIMARY KEY (`group_id`,`contact_id`),
  ADD KEY `contact_id` (`contact_id`);

--
-- Indexes for table `sent_messages`
--
ALTER TABLE `sent_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sent_messages`
--
ALTER TABLE `sent_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_members`
--
ALTER TABLE `group_members`
  ADD CONSTRAINT `group_members_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_members_ibfk_2` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sent_messages`
--
ALTER TABLE `sent_messages`
  ADD CONSTRAINT `sent_messages_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `templates` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
