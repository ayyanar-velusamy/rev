-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2024 at 10:13 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `revival`
--

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `form_name` varchar(50) NOT NULL DEFAULT 'Contact Form',
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `form_name`, `name`, `email`, `phone`, `comment`, `created_at`, `updated_at`) VALUES
(1, 'Contact Form', 'sdfas', 'asdsad@dsf.dfh', '42342344', 'dsfdsfsd', '2020-12-28 12:55:51', '2020-12-28 12:55:51'),
(2, 'Contact Form', 'asdfasdf', 'asdfad@sddd.com', '789797654645', 'ssdsddfdg', '2020-12-28 13:11:40', '2020-12-28 13:11:40'),
(3, 'Contact Form', 'gdfd gdfgdfg', 'admin@gmail.com', '453453655', 'sdfsdf', '2020-12-28 13:15:10', '2020-12-28 13:15:10'),
(4, 'Contact Form', 'gdfd gdfgdfg', 'admin@gmail.com', '45345365', 'fdgdfg', '2020-12-28 13:15:31', '2020-12-28 13:15:31'),
(5, 'Contact Form', 'Ayyanar', 'inr.cse@gmail.com', '9952642738', 'My test comment', '2020-12-28 13:43:25', '2020-12-28 13:43:25'),
(6, 'Contact Form', 'test', 'test@gmail.com', '9092377706', 'Testing', '2020-12-29 04:14:28', '2020-12-29 04:14:28'),
(7, 'Houston Office', 'Ayyanar', 'inr.cse@gmail.com', '98989898', 'test', '2020-12-29 07:57:25', '2020-12-29 07:57:25'),
(8, 'Maryland Office', 'Ayyanar', 'findanoffice@gmail.com', '0980909090909', 'test', '2021-01-05 14:35:46', '2021-01-05 14:35:46'),
(9, 'Contact Form', 'asda', 'asda@dsfd.dfg', '34234234324', 'dsfdsfsdf', '2021-01-05 14:37:08', '2021-01-05 14:37:08'),
(10, 'About Contact Form', 'temk', 'muthu.dev@velaninfo.com', '7897987987987', 'temktemktemk', '2021-01-05 14:59:22', '2021-01-05 14:59:22'),
(11, 'Annandale Office', 'Test', 'inr.cse@gmail.com', '9898989898', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error optio in quia ipsum quae neque alias eligendi, nulla nisi. Veniam ut quis similique culpa natus dolor aliquam officiis ratione libero. Expedita asperiores aliquam provident amet dolores.', '2021-01-05 20:39:11', '2021-01-05 20:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `menu_en` longtext NOT NULL,
  `menu_es` longtext NOT NULL,
  `menu_ar` longtext NOT NULL,
  `route` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 2,
  `parent_menu` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_en`, `menu_es`, `menu_ar`, `route`, `link`, `type`, `parent_menu`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Home', 'Casa', 'الصفحة الرئيسية', 'index', '/', 1, 0, 1, '2020-12-16 07:51:16', '2020-12-16 07:51:16'),
(2, 'About Us', 'Sobre nosotras', 'معلومات عنا', 'about-us', 'home-health-care-about-us', 1, 0, 1, '2020-12-16 21:13:46', '2020-12-16 07:51:16'),
(3, 'History', 'History', 'History', 'history', 'home-health-care-history', 1, 2, 1, '2020-12-19 02:24:16', '2020-12-16 07:52:47'),
(4, 'Quality Measures', 'Quality Measures', 'Quality Measures', 'quality-measures', 'home-health-care-quality-measures', 1, 2, 1, '2020-12-19 03:01:16', '2020-12-16 07:52:47'),
(5, 'Our Services', 'Nuestros servicios', 'خدماتنا', 'our-services', 'home-health-care-our-services', 1, 0, 1, '2020-12-16 21:22:45', '2020-12-16 07:53:42'),
(6, 'Careers', 'Careers', 'Careers', 'careers', 'home-health-care-careers', 1, 0, 1, '2020-12-19 02:17:41', '2020-12-16 07:53:42'),
(7, 'Resources', 'Resources', 'Resources', 'resources', 'home-health-care-resources', 1, 0, 1, '2020-12-19 02:18:50', '2020-12-16 07:54:22'),
(8, 'Testimonials', 'Testimonials', 'Testimonials', 'testimonials', 'home-health-care-clients-testimonials', 1, 0, 1, '2020-12-19 02:20:02', '2020-12-16 07:54:22'),
(9, 'Contact Us', '', '', 'contact', 'home-health-care-contact-us', 1, 0, 1, '2020-12-16 07:55:00', '2020-12-16 07:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_10_11_063704_add_columns_to_users_table', 1),
(4, '2019_11_15_060830_create_permission_tables', 1),
(5, '2019_11_15_104739_add_module_id_to_permissions_table', 1),
(6, '2019_11_15_105425_create_modules_table', 1),
(7, '2019_11_19_083214_create_notifications_table', 1),
(8, '2019_11_21_131800_add_status_column_to_roles_table', 1),
(9, '2020_04_22_113023_add_login_fields_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Model\\User', 1),
(1, 'App\\Model\\User', 4),
(2, 'App\\Model\\User', 2),
(2, 'App\\Model\\User', 3),
(2, 'App\\Model\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `display_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'role', 'User Role Management', 'active', '2020-10-26 21:26:38', '2020-10-26 21:26:38'),
(2, 'user', 'User Management', 'active', '2020-10-26 21:26:38', '2020-10-26 21:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('1e1a5ae7-8f27-459e-8af6-c00ffa790eaf', 'App\\Notifications\\ProfileUpdateNotification', 'App\\Model\\User', 2, '{\"user_name\":\"Admin Admin\",\"details\":{\"id\":2,\"first_name\":\"MK\",\"last_name\":\"Dev\",\"designation\":null,\"team\":null,\"department\":null,\"email\":\"mail2mk.dev@gmail.com\",\"email_verified_at\":null,\"image\":null,\"mobile\":\"78897897978\",\"change_email\":null,\"change_email_token\":null,\"changed_at\":null,\"status\":\"active\",\"login\":\"no\",\"last_login_at\":null,\"last_login_ip\":null,\"created_at\":\"2020-10-27 02:58:18\",\"updated_at\":\"2020-11-05 23:48:08\",\"deleted_at\":null}}', NULL, '2020-11-05 18:18:08', '2020-11-05 18:18:08'),
('58e31ec9-dc47-4a5d-b772-f8220fff5b3b', 'App\\Notifications\\ProfileUpdateNotification', 'App\\Model\\User', 4, '{\"user_name\":\"Admin Admin\",\"details\":{\"id\":4,\"first_name\":\"jgfhj\",\"last_name\":\"fghj\",\"designation\":null,\"team\":null,\"department\":null,\"email\":\"jfgh@wwe.com\",\"email_verified_at\":null,\"image\":null,\"mobile\":\"4534534534\",\"change_email\":null,\"change_email_token\":null,\"changed_at\":null,\"status\":\"active\",\"login\":\"no\",\"last_login_at\":null,\"last_login_ip\":null,\"created_at\":\"2020-11-04 20:24:42\",\"updated_at\":\"2020-11-04 20:24:42\",\"deleted_at\":null}}', NULL, '2020-11-05 18:17:40', '2020-11-05 18:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `page_name` varchar(100) NOT NULL,
  `parent_menu` int(11) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `image` text NOT NULL,
  `default_page` int(11) NOT NULL DEFAULT 0,
  `content_en` longtext NOT NULL,
  `content_fr` longtext NOT NULL,
  `content_es` longtext NOT NULL,
  `content_ar` longtext NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `menu_id`, `page_name`, `parent_menu`, `meta_description`, `meta_keyword`, `image`, `default_page`, `content_en`, `content_fr`, `content_es`, `content_ar`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Home', 1, 'index', 0, 'Home', 'Home', 'WwEGSMphJOSaHVxN2mwVGK2XHBvcvsLlpcqdK9u4.png', 1, '<h2 class=\"text-uppercase mt-0\">Welcome To <span class=\"text-theme-color-2\"> Revival Home Care </span></h2>\r\n\r\n<p class=\"lead\">WE OFFER Do taking care of your responsibilities and finding time to be with your loved one prove to be a herculean task? Are you looking for a home care agency that can assist your loved one when you are away? Well, you can ease your mind from worrying too much. A home care services provider in Virginia and Maryland can help you and your family.<br />\r\n<br />\r\nFor your home care services dilemma, you can trust only one name: <b>Revival Homecare Agency</b>. Our agency exists to provide you and our community with health services that bring comfort in a familiar setting, your home. Our competent staff and employees have been serving the people of Virginia and Maryland for years. Keeping your loved one healthy and relaxed is our top priority. For more information about our services, please call us at 888-225-6905.</p>', '<h2 class=\"text-uppercase mt-0\">Welcome To <span class=\"text-theme-color-2\"> Revival Home Care </span></h2>\r\n\r\n<p class=\"lead\">WE OFFER Do taking care of your responsibilities and finding time to be with your loved one prove to be a herculean task? Are you looking for a home care agency that can assist your loved one when you are away? Well, you can ease your mind from worrying too much. A home care services provider in Virginia and Maryland can help you and your family.<br />\r\n<br />\r\nFor your home care services dilemma, you can trust only one name: <b>Revival Homecare Agency</b>. Our agency exists to provide you and our community with health services that bring comfort in a familiar setting, your home. Our competent staff and employees have been serving the people of Virginia and Maryland for years. Keeping your loved one healthy and relaxed is our top priority. For more information about our services, please call us at 888-225-6905.</p>', '', '', 'active', '2020-12-16 21:04:36', '2020-11-06 09:20:09'),
(2, 'About', 2, 'about-us', 0, 'About Us', 'About Us', 'ieXMSMSaRe8keAtpaQSDyyFYKjToTLfKdpirK2nO.png', 1, '<h2 class=\"text-uppercase mt-0\">About<span class=\"text-theme-color-2\">&nbsp;Us</span></h2>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"javascript:;\">Our Brochure</a></li>\r\n	<li><a href=\"javascript:;\">Our Flyer</a></li>\r\n</ul>\r\n\r\n<p><br />\r\nWhat is Home Health Care?<br />\r\nIt is a manner of care delivery that is ideal for most homebound patients. Care can be provided to individuals of any age with conditions that require continuing care by a medical professional, structured treatment or nursing care instruction.<br />\r\nServices range from high-tech medical procedures to basic personal care which are provided with the aim to:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Reduce the strain caused by long-term hospitalization</li>\r\n	<li>Lessen nursing home bills during an illness or disability</li>\r\n	<li>Create more flexible home-based care options for the patient and the family</li>\r\n</ul>\r\n\r\n<p><br />\r\nStaying at home enables one to maintain social ties and involvement with community, friends, and family. This preserves a sense of independence and security for the patient. In many cases, the consistency of home health care can eliminate the need for hospitalization altogether.<br />\r\nWe have the ability to provide appropriate medical and non-medical care to you and your family. If you prefer remaining in the home rather than in institutional settings,&nbsp;<b>Revival Homecare Agency</b>&nbsp;is here to help. We are dedicated to providing the highest quality of healthcare in the comfort of your own home. With a team approach to address your needs, we offer holistic care plans that consider your physical, psychological and spiritual needs as a patient.</p>\r\n\r\n<ul class=\"list-img\">\r\n</ul>', '', '<p>Sobre nosotros<br />\r\nNuestro folleto<br />\r\nNuestro Flyer<br />\r\n&iquest;Qu&eacute; es la atenci&oacute;n m&eacute;dica domiciliaria?<br />\r\nEs una forma de prestaci&oacute;n de atenci&oacute;n que es ideal para la mayor&iacute;a de los pacientes confinados en casa. Se puede brindar atenci&oacute;n a personas de cualquier edad con afecciones que requieran atenci&oacute;n continua por parte de un profesional m&eacute;dico, tratamiento estructurado o instrucci&oacute;n de atenci&oacute;n de enfermer&iacute;a.<br />\r\nLos servicios van desde procedimientos m&eacute;dicos de alta tecnolog&iacute;a hasta cuidados personales b&aacute;sicos que se brindan con el objetivo de:</p>\r\n\r\n<p>reducir la tensi&oacute;n causada por la hospitalizaci&oacute;n a largo plazo<br />\r\nreducir las facturas de los hogares de ancianos durante una enfermedad o discapacidad<br />\r\nCrear opciones de atenci&oacute;n domiciliaria m&aacute;s flexibles para el paciente y la familia.<br />\r\nQuedarse en casa le permite a uno mantener los lazos sociales y la participaci&oacute;n con la comunidad, los amigos y la familia. Esto preserva un sentido de independencia y seguridad para el paciente. En muchos casos, la coherencia de la atenci&oacute;n m&eacute;dica domiciliaria puede eliminar por completo la necesidad de hospitalizaci&oacute;n.<br />\r\nTenemos la capacidad de brindarle atenci&oacute;n m&eacute;dica y no m&eacute;dica adecuada a usted y a su familia. Si prefiere permanecer en el hogar en lugar de en un entorno institucional, Revival Homecare Agency est&aacute; aqu&iacute; para ayudarlo. Estamos dedicados a brindar atenci&oacute;n m&eacute;dica de la m&aacute;s alta calidad en la comodidad de su hogar. Con un enfoque de equipo para abordar sus necesidades, ofrecemos planes de atenci&oacute;n integral que consideran sus necesidades f&iacute;sicas, psicol&oacute;gicas y espirituales como paciente.</p>', '<p>معلومات عنا<br />\r\nكتيبنا<br />\r\nنشرة إعلانية لدينا<br />\r\nما هي الرعاية الصحية المنزلية؟<br />\r\nإنها طريقة لتقديم الرعاية مثالية لمعظم المرضى الموجودين في المنزل. يمكن تقديم الرعاية للأفراد في أي عمر ممن يعانون من ظروف تتطلب رعاية مستمرة من قبل أخصائي طبي أو علاج منظم أو تعليمات رعاية تمريضية.<br />\r\nتتراوح الخدمات من الإجراءات الطبية عالية التقنية إلى الرعاية الشخصية الأساسية التي يتم تقديمها بهدف:</p>\r\n\r\n<p>تقليل الضغط الناجم عن الاستشفاء طويل الأمد<br />\r\nتقليل فواتير دار رعاية المسنين أثناء المرض أو الإعاقة<br />\r\nخلق خيارات رعاية منزلية أكثر مرونة للمريض والأسرة<br />\r\nيمكّن البقاء في المنزل الفرد من الحفاظ على الروابط الاجتماعية والمشاركة مع المجتمع والأصدقاء والعائلة. هذا يحافظ على الشعور بالاستقلال والأمان للمريض في كثير من الحالات ، يمكن لاتساق الرعاية الصحية المنزلية أن يلغي الحاجة إلى الاستشفاء تمامًا.<br />\r\nلدينا القدرة على تقديم الرعاية الطبية وغير الطبية المناسبة لك ولعائلتك. إذا كنت تفضل البقاء في المنزل بدلاً من المؤسسات ، فإن Revival Homecare Agency هنا لمساعدتك. نحن ملتزمون بتوفير أعلى مستويات الجودة من الرعاية الصحية في راحة منزلك. من خلال نهج الفريق لتلبية احتياجاتك ، نقدم خطط رعاية شاملة تراعي احتياجاتك الجسدية والنفسية والروحية كمريض.</p>', 'active', '2020-12-28 19:19:26', '2020-11-25 18:26:12'),
(3, 'History', 3, 'history', 0, 'History', 'History', 'PdURQD3k4tJtMqs4777G1IjTjJzdiJZLZv9sBMO2.png', 1, '<h2 class=\"text-uppercase mt-0\">History</h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;was established based on the idea of completely giving back to the community. The idea of servicing loved ones with the comfort of family, friends, neighbors and a familiar setting was incredible as the patient&rsquo;s psychological state would encourage a speedy recovery. Founded in 2007; both Akram Elzend, DPT (President) and Amir Elsayed, DPT (Vice President) understood the need and importance in having alternatives in healthcare that are not only cost efficient, but do not take out the personal feelings and values of the traditional aspects in patient care. While being at home and surrounded with love and comfort, facing different medical issues can be challenging to both the patient and his or her family.</p>\r\n\r\n<p>Here at Revival Homecare Agency our number one mission is to provide the highest quality of care, easing the patient&rsquo;s pain and guiding family and friends through this apprehensive journey. By providing Home Health Care services, our clinicians not only address our patient&rsquo;s medical needs, but also focus on meeting their physical, psychological, environmental and spiritual needs within the comforts and settings of their own home.</p>\r\n\r\n<p>Home health care is an essential part of health care today, touching the lives of nearly every American. It encompasses a broad range of professional health care and support services provided in the home. As hospital stays decrease, increasing numbers of patients need highly-skilled services when they return home. Home care is necessary when a person needs ongoing care that cannot easily or effectively be provided solely by family and friends. Home health care services usually include assisting those persons who are recovering, disabled, chronically or terminally ill and are in need of medical, nursing, social, or therapeutic treatment and or assistance with the essential activities of daily living.</p>\r\n\r\n<p>Since its establishment in Northern Virginia,&nbsp;<b>Revival Homecare Agency</b>&nbsp;has expanded its services and is now currently serving the Richmond and Maryland community bringing forth professionalism, reliability, and knowledge of the medical industry. Our highly qualified team has grown to over 100 employees, including licensed and certified clinicians with expertise in skilled nursing, physical therapy, occupational therapy, speech therapy, and personal care.</p>\r\n\r\n<p>Using a team approach, our team of skilled professionals and non-medical professionals seek to provide assistance and support during difficult times. They are not only courteous, supportive, personable, and friendly, they are also carefully screened and receive specialized training so you can feel comfortable allowing our staff into your home. By providing that &ldquo;Personal Touch&rdquo; or one-on-one care with patients,&nbsp;<b>Revival Homecare Agency</b>&nbsp;strives to be your number one choice in home care services for you and or your loved ones.</p>', '<h2 class=\"text-uppercase mt-0\">History</h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;was established based on the idea of completely giving back to the community. The idea of servicing loved ones with the comfort of family, friends, neighbors and a familiar setting was incredible as the patient&rsquo;s psychological state would encourage a speedy recovery. Founded in 2007; both Akram Elzend, DPT (President) and Amir Elsayed, DPT (Vice President) understood the need and importance in having alternatives in healthcare that are not only cost efficient, but do not take out the personal feelings and values of the traditional aspects in patient care. While being at home and surrounded with love and comfort, facing different medical issues can be challenging to both the patient and his or her family.</p>\r\n\r\n<p>Here at Revival Homecare Agency our number one mission is to provide the highest quality of care, easing the patient&rsquo;s pain and guiding family and friends through this apprehensive journey. By providing Home Health Care services, our clinicians not only address our patient&rsquo;s medical needs, but also focus on meeting their physical, psychological, environmental and spiritual needs within the comforts and settings of their own home.</p>\r\n\r\n<p>Home health care is an essential part of health care today, touching the lives of nearly every American. It encompasses a broad range of professional health care and support services provided in the home. As hospital stays decrease, increasing numbers of patients need highly-skilled services when they return home. Home care is necessary when a person needs ongoing care that cannot easily or effectively be provided solely by family and friends. Home health care services usually include assisting those persons who are recovering, disabled, chronically or terminally ill and are in need of medical, nursing, social, or therapeutic treatment and or assistance with the essential activities of daily living.</p>\r\n\r\n<p>Since its establishment in Northern Virginia,&nbsp;<b>Revival Homecare Agency</b>&nbsp;has expanded its services and is now currently serving the Richmond and Maryland community bringing forth professionalism, reliability, and knowledge of the medical industry. Our highly qualified team has grown to over 100 employees, including licensed and certified clinicians with expertise in skilled nursing, physical therapy, occupational therapy, speech therapy, and personal care.</p>\r\n\r\n<p>Using a team approach, our team of skilled professionals and non-medical professionals seek to provide assistance and support during difficult times. They are not only courteous, supportive, personable, and friendly, they are also carefully screened and receive specialized training so you can feel comfortable allowing our staff into your home. By providing that &ldquo;Personal Touch&rdquo; or one-on-one care with patients,&nbsp;<b>Revival Homecare Agency</b>&nbsp;strives to be your number one choice in home care services for you and or your loved ones.</p>', '<h2 class=\"text-uppercase mt-0\">History</h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;was established based on the idea of completely giving back to the community. The idea of servicing loved ones with the comfort of family, friends, neighbors and a familiar setting was incredible as the patient&rsquo;s psychological state would encourage a speedy recovery. Founded in 2007; both Akram Elzend, DPT (President) and Amir Elsayed, DPT (Vice President) understood the need and importance in having alternatives in healthcare that are not only cost efficient, but do not take out the personal feelings and values of the traditional aspects in patient care. While being at home and surrounded with love and comfort, facing different medical issues can be challenging to both the patient and his or her family.</p>\r\n\r\n<p>Here at Revival Homecare Agency our number one mission is to provide the highest quality of care, easing the patient&rsquo;s pain and guiding family and friends through this apprehensive journey. By providing Home Health Care services, our clinicians not only address our patient&rsquo;s medical needs, but also focus on meeting their physical, psychological, environmental and spiritual needs within the comforts and settings of their own home.</p>\r\n\r\n<p>Home health care is an essential part of health care today, touching the lives of nearly every American. It encompasses a broad range of professional health care and support services provided in the home. As hospital stays decrease, increasing numbers of patients need highly-skilled services when they return home. Home care is necessary when a person needs ongoing care that cannot easily or effectively be provided solely by family and friends. Home health care services usually include assisting those persons who are recovering, disabled, chronically or terminally ill and are in need of medical, nursing, social, or therapeutic treatment and or assistance with the essential activities of daily living.</p>\r\n\r\n<p>Since its establishment in Northern Virginia,&nbsp;<b>Revival Homecare Agency</b>&nbsp;has expanded its services and is now currently serving the Richmond and Maryland community bringing forth professionalism, reliability, and knowledge of the medical industry. Our highly qualified team has grown to over 100 employees, including licensed and certified clinicians with expertise in skilled nursing, physical therapy, occupational therapy, speech therapy, and personal care.</p>\r\n\r\n<p>Using a team approach, our team of skilled professionals and non-medical professionals seek to provide assistance and support during difficult times. They are not only courteous, supportive, personable, and friendly, they are also carefully screened and receive specialized training so you can feel comfortable allowing our staff into your home. By providing that &ldquo;Personal Touch&rdquo; or one-on-one care with patients,&nbsp;<b>Revival Homecare Agency</b>&nbsp;strives to be your number one choice in home care services for you and or your loved ones.</p>', '<h2 class=\"text-uppercase mt-0\">History</h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;was established based on the idea of completely giving back to the community. The idea of servicing loved ones with the comfort of family, friends, neighbors and a familiar setting was incredible as the patient&rsquo;s psychological state would encourage a speedy recovery. Founded in 2007; both Akram Elzend, DPT (President) and Amir Elsayed, DPT (Vice President) understood the need and importance in having alternatives in healthcare that are not only cost efficient, but do not take out the personal feelings and values of the traditional aspects in patient care. While being at home and surrounded with love and comfort, facing different medical issues can be challenging to both the patient and his or her family.</p>\r\n\r\n<p>Here at Revival Homecare Agency our number one mission is to provide the highest quality of care, easing the patient&rsquo;s pain and guiding family and friends through this apprehensive journey. By providing Home Health Care services, our clinicians not only address our patient&rsquo;s medical needs, but also focus on meeting their physical, psychological, environmental and spiritual needs within the comforts and settings of their own home.</p>\r\n\r\n<p>Home health care is an essential part of health care today, touching the lives of nearly every American. It encompasses a broad range of professional health care and support services provided in the home. As hospital stays decrease, increasing numbers of patients need highly-skilled services when they return home. Home care is necessary when a person needs ongoing care that cannot easily or effectively be provided solely by family and friends. Home health care services usually include assisting those persons who are recovering, disabled, chronically or terminally ill and are in need of medical, nursing, social, or therapeutic treatment and or assistance with the essential activities of daily living.</p>\r\n\r\n<p>Since its establishment in Northern Virginia,&nbsp;<b>Revival Homecare Agency</b>&nbsp;has expanded its services and is now currently serving the Richmond and Maryland community bringing forth professionalism, reliability, and knowledge of the medical industry. Our highly qualified team has grown to over 100 employees, including licensed and certified clinicians with expertise in skilled nursing, physical therapy, occupational therapy, speech therapy, and personal care.</p>\r\n\r\n<p>Using a team approach, our team of skilled professionals and non-medical professionals seek to provide assistance and support during difficult times. They are not only courteous, supportive, personable, and friendly, they are also carefully screened and receive specialized training so you can feel comfortable allowing our staff into your home. By providing that &ldquo;Personal Touch&rdquo; or one-on-one care with patients,&nbsp;<b>Revival Homecare Agency</b>&nbsp;strives to be your number one choice in home care services for you and or your loved ones.</p>', 'active', '2020-12-19 02:24:16', '2020-12-15 06:50:20'),
(4, 'QUALITY MEASURES', 4, 'quality-measures', 2, 'QUALITY MEASURES', 'QUALITY MEASURES', 'PyJfozUisA8PeBlBoFCilXXMeL3fLjcxZS6ciJgs.png', 1, '<h2 class=\"text-uppercase mt-0\">QUALITY&nbsp;<span class=\"text-theme-color-2\">MEASURES</span></h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;is guided by a tradition of personal, clinical, and technological excellence .We are dedicated to providing the highest quality home-based patient care with compassion and respect for each person.</p>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;recognizes the unique physical, emotional, and spiritual needs of each person receiving health care in the home. We strive to extend the highest level of courtesy, safety and service to patients, family/caregivers, visitors, and each other. We deliver state-of-the-art home health services with identified centers of excellence. We engage in a wide range of continuing education, clinical education, and other programs for professionals and the public.</p>\r\n\r\n<p>We strive to create an environment of teamwork and participation, where, through continuous performance improvement and open communication, health care professionals pursue excellence and take pride in their work, the organization, and their personal development. We believe that the quality of our human resources&mdash;organization personnel, physicians, and volunteers&mdash;is the key to our continued success. We provide physicians an environment that fosters high quality diagnosis and treatment. We maintain financial viability through a cost-effective operation to meet our long-term commitment to the community.</p>\r\n\r\n<p><b>Revival Homecare Agency</b><br />\r\n<br />\r\n(This information comes from the Home Health Outcome and Assessment Information Set (OASIS) C during the time period April 2012 &ndash; March 2013)<br />\r\nThe information in Home Health Compare should be looked at carefully. Use it with the other information you gather about home health agencies as you decide where to get home health services. You may want to contact your doctor, your State Survey Agency or your State Quality Improvement Organization for more information. To report quality problems, contact the State Quality Improvement Organization or State Home Health Hotline number that can be found in the Helpful Contacts section of this website.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Most people value being able to take care of themselves. In some cases, it may take more time for you to walk and move around yourself than to have someone do things for you. But, it is important that home health care staff and informal caregivers encourage you to do as much as you can for yourself. Your home health staff will evaluate your need for, and teach you how to use any special devices or equipment that you may need to help you increase you ability to perform some activities and your ability to get in and out of bed yourself may help you live independently as long as possible in your own home without the assistance of another person.If you can get in and out of bed with little help, you may be more independent, feel better about yourself, and stay more active. This can affect your health in a good way.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Home health staff should ask if you are having pain at each visit. If you are in pain, you (or someone on your behalf) should tell the staff. Efforts can then be made to find and treat the cause and make you more comfortable. If pain is not treated, you may not be able to perform daily routines, may become depressed, or have an overall poor quality of life. Pain may also be a sign of a new or worsening health problem.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Normal wound healing after an operation is an important marker of good care. Patients whose wounds heal normally generally feel better and can get back to their daily activities sooner than those whose wounds don&rsquo;t heal normally. After an operation, patients often go home to recover and their doctor may refer them for home health care. One way to measure the quality of care that home health agencies give is to look at how well their patients&rsquo; wounds heal after an operation.Higher percentages are better.</p>\r\n\r\n<p>For medicines to work properly, they need to be taken correctly. Taking too much or too little medicine can keep it from helping you feel better and, in some cases, can make you sicker, make you confused (which could affect your safety), or even cause death. Home health staff can help teach you ways to organize your medicines and take them properly. Getting better at taking your medicines correctly means the home health agency is doing a good job teaching you how to take your medicines.</p>\r\n\r\n<p>A home health care provider may refer a patient to emergency care when this is the best way to treat the patient&rsquo;s current condition. However, some emergency care may be avoided if the home health staff is doing a good job at checking your health condition to detect problems early. They also need to check how well you are eating, drinking, and taking your medicines, and how safe your home is. Home health staff must coordinate your care. This involves communicating regularly with you, your informal caregivers, your doctor, and anyone else who provides care for you. Lower percentages are better.</p>', '<h2 class=\"text-uppercase mt-0\">QUALITY&nbsp;<span class=\"text-theme-color-2\">MEASURES</span></h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;is guided by a tradition of personal, clinical, and technological excellence .We are dedicated to providing the highest quality home-based patient care with compassion and respect for each person.</p>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;recognizes the unique physical, emotional, and spiritual needs of each person receiving health care in the home. We strive to extend the highest level of courtesy, safety and service to patients, family/caregivers, visitors, and each other. We deliver state-of-the-art home health services with identified centers of excellence. We engage in a wide range of continuing education, clinical education, and other programs for professionals and the public.</p>\r\n\r\n<p>We strive to create an environment of teamwork and participation, where, through continuous performance improvement and open communication, health care professionals pursue excellence and take pride in their work, the organization, and their personal development. We believe that the quality of our human resources&mdash;organization personnel, physicians, and volunteers&mdash;is the key to our continued success. We provide physicians an environment that fosters high quality diagnosis and treatment. We maintain financial viability through a cost-effective operation to meet our long-term commitment to the community.</p>\r\n\r\n<p><b>Revival Homecare Agency</b><br />\r\n<br />\r\n(This information comes from the Home Health Outcome and Assessment Information Set (OASIS) C during the time period April 2012 &ndash; March 2013)<br />\r\nThe information in Home Health Compare should be looked at carefully. Use it with the other information you gather about home health agencies as you decide where to get home health services. You may want to contact your doctor, your State Survey Agency or your State Quality Improvement Organization for more information. To report quality problems, contact the State Quality Improvement Organization or State Home Health Hotline number that can be found in the Helpful Contacts section of this website.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Most people value being able to take care of themselves. In some cases, it may take more time for you to walk and move around yourself than to have someone do things for you. But, it is important that home health care staff and informal caregivers encourage you to do as much as you can for yourself. Your home health staff will evaluate your need for, and teach you how to use any special devices or equipment that you may need to help you increase you ability to perform some activities and your ability to get in and out of bed yourself may help you live independently as long as possible in your own home without the assistance of another person.If you can get in and out of bed with little help, you may be more independent, feel better about yourself, and stay more active. This can affect your health in a good way.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Home health staff should ask if you are having pain at each visit. If you are in pain, you (or someone on your behalf) should tell the staff. Efforts can then be made to find and treat the cause and make you more comfortable. If pain is not treated, you may not be able to perform daily routines, may become depressed, or have an overall poor quality of life. Pain may also be a sign of a new or worsening health problem.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Normal wound healing after an operation is an important marker of good care. Patients whose wounds heal normally generally feel better and can get back to their daily activities sooner than those whose wounds don&rsquo;t heal normally. After an operation, patients often go home to recover and their doctor may refer them for home health care. One way to measure the quality of care that home health agencies give is to look at how well their patients&rsquo; wounds heal after an operation.Higher percentages are better.</p>\r\n\r\n<p>For medicines to work properly, they need to be taken correctly. Taking too much or too little medicine can keep it from helping you feel better and, in some cases, can make you sicker, make you confused (which could affect your safety), or even cause death. Home health staff can help teach you ways to organize your medicines and take them properly. Getting better at taking your medicines correctly means the home health agency is doing a good job teaching you how to take your medicines.</p>\r\n\r\n<p>A home health care provider may refer a patient to emergency care when this is the best way to treat the patient&rsquo;s current condition. However, some emergency care may be avoided if the home health staff is doing a good job at checking your health condition to detect problems early. They also need to check how well you are eating, drinking, and taking your medicines, and how safe your home is. Home health staff must coordinate your care. This involves communicating regularly with you, your informal caregivers, your doctor, and anyone else who provides care for you. Lower percentages are better.</p>', '<h2 class=\"text-uppercase mt-0\">QUALITY&nbsp;<span class=\"text-theme-color-2\">MEASURES</span></h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;is guided by a tradition of personal, clinical, and technological excellence .We are dedicated to providing the highest quality home-based patient care with compassion and respect for each person.</p>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;recognizes the unique physical, emotional, and spiritual needs of each person receiving health care in the home. We strive to extend the highest level of courtesy, safety and service to patients, family/caregivers, visitors, and each other. We deliver state-of-the-art home health services with identified centers of excellence. We engage in a wide range of continuing education, clinical education, and other programs for professionals and the public.</p>\r\n\r\n<p>We strive to create an environment of teamwork and participation, where, through continuous performance improvement and open communication, health care professionals pursue excellence and take pride in their work, the organization, and their personal development. We believe that the quality of our human resources&mdash;organization personnel, physicians, and volunteers&mdash;is the key to our continued success. We provide physicians an environment that fosters high quality diagnosis and treatment. We maintain financial viability through a cost-effective operation to meet our long-term commitment to the community.</p>\r\n\r\n<p><b>Revival Homecare Agency</b><br />\r\n<br />\r\n(This information comes from the Home Health Outcome and Assessment Information Set (OASIS) C during the time period April 2012 &ndash; March 2013)<br />\r\nThe information in Home Health Compare should be looked at carefully. Use it with the other information you gather about home health agencies as you decide where to get home health services. You may want to contact your doctor, your State Survey Agency or your State Quality Improvement Organization for more information. To report quality problems, contact the State Quality Improvement Organization or State Home Health Hotline number that can be found in the Helpful Contacts section of this website.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Most people value being able to take care of themselves. In some cases, it may take more time for you to walk and move around yourself than to have someone do things for you. But, it is important that home health care staff and informal caregivers encourage you to do as much as you can for yourself. Your home health staff will evaluate your need for, and teach you how to use any special devices or equipment that you may need to help you increase you ability to perform some activities and your ability to get in and out of bed yourself may help you live independently as long as possible in your own home without the assistance of another person.If you can get in and out of bed with little help, you may be more independent, feel better about yourself, and stay more active. This can affect your health in a good way.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Home health staff should ask if you are having pain at each visit. If you are in pain, you (or someone on your behalf) should tell the staff. Efforts can then be made to find and treat the cause and make you more comfortable. If pain is not treated, you may not be able to perform daily routines, may become depressed, or have an overall poor quality of life. Pain may also be a sign of a new or worsening health problem.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Normal wound healing after an operation is an important marker of good care. Patients whose wounds heal normally generally feel better and can get back to their daily activities sooner than those whose wounds don&rsquo;t heal normally. After an operation, patients often go home to recover and their doctor may refer them for home health care. One way to measure the quality of care that home health agencies give is to look at how well their patients&rsquo; wounds heal after an operation.Higher percentages are better.</p>\r\n\r\n<p>For medicines to work properly, they need to be taken correctly. Taking too much or too little medicine can keep it from helping you feel better and, in some cases, can make you sicker, make you confused (which could affect your safety), or even cause death. Home health staff can help teach you ways to organize your medicines and take them properly. Getting better at taking your medicines correctly means the home health agency is doing a good job teaching you how to take your medicines.</p>\r\n\r\n<p>A home health care provider may refer a patient to emergency care when this is the best way to treat the patient&rsquo;s current condition. However, some emergency care may be avoided if the home health staff is doing a good job at checking your health condition to detect problems early. They also need to check how well you are eating, drinking, and taking your medicines, and how safe your home is. Home health staff must coordinate your care. This involves communicating regularly with you, your informal caregivers, your doctor, and anyone else who provides care for you. Lower percentages are better.</p>', '<h2 class=\"text-uppercase mt-0\">QUALITY&nbsp;<span class=\"text-theme-color-2\">MEASURES</span></h2>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;is guided by a tradition of personal, clinical, and technological excellence .We are dedicated to providing the highest quality home-based patient care with compassion and respect for each person.</p>\r\n\r\n<p><b>Revival Homecare Agency</b>&nbsp;recognizes the unique physical, emotional, and spiritual needs of each person receiving health care in the home. We strive to extend the highest level of courtesy, safety and service to patients, family/caregivers, visitors, and each other. We deliver state-of-the-art home health services with identified centers of excellence. We engage in a wide range of continuing education, clinical education, and other programs for professionals and the public.</p>\r\n\r\n<p>We strive to create an environment of teamwork and participation, where, through continuous performance improvement and open communication, health care professionals pursue excellence and take pride in their work, the organization, and their personal development. We believe that the quality of our human resources&mdash;organization personnel, physicians, and volunteers&mdash;is the key to our continued success. We provide physicians an environment that fosters high quality diagnosis and treatment. We maintain financial viability through a cost-effective operation to meet our long-term commitment to the community.</p>\r\n\r\n<p><b>Revival Homecare Agency</b><br />\r\n<br />\r\n(This information comes from the Home Health Outcome and Assessment Information Set (OASIS) C during the time period April 2012 &ndash; March 2013)<br />\r\nThe information in Home Health Compare should be looked at carefully. Use it with the other information you gather about home health agencies as you decide where to get home health services. You may want to contact your doctor, your State Survey Agency or your State Quality Improvement Organization for more information. To report quality problems, contact the State Quality Improvement Organization or State Home Health Hotline number that can be found in the Helpful Contacts section of this website.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Most people value being able to take care of themselves. In some cases, it may take more time for you to walk and move around yourself than to have someone do things for you. But, it is important that home health care staff and informal caregivers encourage you to do as much as you can for yourself. Your home health staff will evaluate your need for, and teach you how to use any special devices or equipment that you may need to help you increase you ability to perform some activities and your ability to get in and out of bed yourself may help you live independently as long as possible in your own home without the assistance of another person.If you can get in and out of bed with little help, you may be more independent, feel better about yourself, and stay more active. This can affect your health in a good way.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Home health staff should ask if you are having pain at each visit. If you are in pain, you (or someone on your behalf) should tell the staff. Efforts can then be made to find and treat the cause and make you more comfortable. If pain is not treated, you may not be able to perform daily routines, may become depressed, or have an overall poor quality of life. Pain may also be a sign of a new or worsening health problem.</p>\r\n\r\n<h4>Why is this information important?</h4>\r\n\r\n<p>Normal wound healing after an operation is an important marker of good care. Patients whose wounds heal normally generally feel better and can get back to their daily activities sooner than those whose wounds don&rsquo;t heal normally. After an operation, patients often go home to recover and their doctor may refer them for home health care. One way to measure the quality of care that home health agencies give is to look at how well their patients&rsquo; wounds heal after an operation.Higher percentages are better.</p>\r\n\r\n<p>For medicines to work properly, they need to be taken correctly. Taking too much or too little medicine can keep it from helping you feel better and, in some cases, can make you sicker, make you confused (which could affect your safety), or even cause death. Home health staff can help teach you ways to organize your medicines and take them properly. Getting better at taking your medicines correctly means the home health agency is doing a good job teaching you how to take your medicines.</p>\r\n\r\n<p>A home health care provider may refer a patient to emergency care when this is the best way to treat the patient&rsquo;s current condition. However, some emergency care may be avoided if the home health staff is doing a good job at checking your health condition to detect problems early. They also need to check how well you are eating, drinking, and taking your medicines, and how safe your home is. Home health staff must coordinate your care. This involves communicating regularly with you, your informal caregivers, your doctor, and anyone else who provides care for you. Lower percentages are better.</p>', 'active', '2020-12-29 10:18:20', '2020-12-15 07:20:27'),
(5, 'Our Services', 5, 'our-services', 0, 'Our Services', 'Our Services', 'tHiklAyHhOHzEn34geJAJ3RLIanL7SRkb9qySoyV.png', 1, '<h2 class=\"text-uppercase mt-0\">Our<span class=\"text-theme-color-2\">&nbsp;Services</span></h2>\r\n\r\n<p>Home Health Care Services are delivered in the comfort and security of your home. It provides you and your family with the sense of control and peace of mind that is rarely replicated in other approaches to care. At&nbsp;<b>Revival Homecare Agency</b>, our professionals provide the personal care you seek. We give you assistance and support during difficult times on your way to fully healing from illness or at least, in coping with chronic medical conditions.</p>\r\n\r\n<p>Our personal care professionals go through extensive training. They work under the guidance a Registered Nurse. At&nbsp;<b>Revival Homecare Agency</b>, we maintain a courteous, approachable, personable, and time-efficient attitude to best serve you in your home.</p>\r\n\r\n<p>We take pride in providing top quality tailored health care for all patients. As a state-licensed home health care agency, we devote ourselves to offering you nothing but the utmost service as our way of returning your trust in us.</p>\r\n\r\n<p>Our skilled professionals are courteous, supportive and friendly. They have been carefully screened and regularly receive specialized training. We want you to feel comfortable when you allow our staff into your homes.</p>\r\n\r\n<p>Our services include but are not limited to:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"http://localhost/laravel/rev/home-health-care-nursing-services\">Nursing Services</a></li>\r\n	<li><a href=\"http://localhost/laravel/rev/home-health-care-home-health-aide-and-home-maker-services\">Home Health Aide and Home Maker Services</a></li>\r\n	<li><a href=\"http://localhost/laravel/rev/home-health-care-physical-occupational-and-speech-therapy\">Physical, Occupational and Speech Therapy</a></li>\r\n</ul>', '<h2 class=\"text-uppercase mt-0\">Our<span class=\"text-theme-color-2\">&nbsp;Services</span></h2>\r\n\r\n<p>Home Health Care Services are delivered in the comfort and security of your home. It provides you and your family with the sense of control and peace of mind that is rarely replicated in other approaches to care. At&nbsp;<b>Revival Homecare Agency</b>, our professionals provide the personal care you seek. We give you assistance and support during difficult times on your way to fully healing from illness or at least, in coping with chronic medical conditions.</p>\r\n\r\n<p>Our personal care professionals go through extensive training. They work under the guidance a Registered Nurse. At&nbsp;<b>Revival Homecare Agency</b>, we maintain a courteous, approachable, personable, and time-efficient attitude to best serve you in your home.</p>\r\n\r\n<p>We take pride in providing top quality tailored health care for all patients. As a state-licensed home health care agency, we devote ourselves to offering you nothing but the utmost service as our way of returning your trust in us.</p>\r\n\r\n<p>Our skilled professionals are courteous, supportive and friendly. They have been carefully screened and regularly receive specialized training. We want you to feel comfortable when you allow our staff into your homes.</p>\r\n\r\n<p>Our services include but are not limited to:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"http://localhost/laravel/rev/home-health-care-nursing-services\">Nursing Services</a></li>\r\n	<li><a href=\"http://localhost/laravel/rev/home-health-care-home-health-aide-and-home-maker-services\">Home Health Aide and Home Maker Services</a></li>\r\n	<li><a href=\"http://localhost/laravel/rev/home-health-care-physical-occupational-and-speech-therapy\">Physical, Occupational and Speech Therapy</a></li>\r\n</ul>', '<p>Nuestros servicios<br />\r\nLos servicios de atenci&oacute;n m&eacute;dica domiciliaria se brindan en la comodidad y seguridad de su hogar. Le brinda a usted y a su familia una sensaci&oacute;n de control y tranquilidad que rara vez se replica en otros enfoques de atenci&oacute;n. En Revival Homecare Agency, nuestros profesionales brindan el cuidado personal que busca. Le brindamos asistencia y apoyo durante los momentos dif&iacute;ciles en su camino hacia la curaci&oacute;n completa de una enfermedad o, al menos, para hacer frente a afecciones m&eacute;dicas cr&oacute;nicas.</p>\r\n\r\n<p>Nuestros profesionales del cuidado personal pasan por una amplia formaci&oacute;n. Trabajan bajo la gu&iacute;a de una enfermera titulada. En Revival Homecare Agency, mantenemos una actitud cort&eacute;s, accesible, afable y eficiente en el tiempo para brindarle un mejor servicio en su hogar.</p>\r\n\r\n<p>Nos enorgullecemos de brindar atenci&oacute;n m&eacute;dica personalizada de la m&aacute;s alta calidad para todos los pacientes. Como agencia de atenci&oacute;n m&eacute;dica domiciliaria con licencia estatal, nos dedicamos a ofrecerle nada m&aacute;s que el mejor servicio como nuestra forma de devolverle su confianza en nosotros.</p>\r\n\r\n<p>Nuestros profesionales calificados son corteses, comprensivos y amigables. Han sido cuidadosamente seleccionados y reciben regularmente formaci&oacute;n especializada. Queremos que se sienta c&oacute;modo cuando permita que nuestro personal ingrese a sus hogares.</p>\r\n\r\n<p>Nuestros servicios incluyen pero no se limitan a:</p>\r\n\r\n<p>Servicios de enfermer&iacute;a<br />\r\nServicios de asistente de salud en el hogar y amas de casa<br />\r\nTerapia f&iacute;sica, ocupacional y del habla</p>', '<p>خدماتنا<br />\r\nيتم تقديم خدمات الرعاية الصحية المنزلية في راحة وأمان في منزلك. إنه يوفر لك ولعائلتك إحساسًا بالتحكم وراحة البال نادرًا ما يتكرر في مناهج أخرى للرعاية. في Revival Homecare Agency ، يقدم المتخصصون لدينا الرعاية الشخصية التي تبحث عنها. نقدم لك المساعدة والدعم خلال الأوقات الصعبة في طريقك إلى الشفاء التام من المرض أو على الأقل في التعامل مع الحالات الطبية المزمنة.</p>\r\n\r\n<p>يخضع متخصصو العناية الشخصية لدينا لتدريب مكثف. يعملون تحت إشراف ممرضة مسجلة. في وكالة Revival Homecare ، نحافظ على أسلوب مهذب ، ودود ، وأنيق ، وفعال من حيث الوقت لتقديم أفضل خدمة لك في منزلك.</p>\r\n\r\n<p>نحن نفخر بتقديم رعاية صحية عالية الجودة لجميع المرضى. بصفتنا وكالة رعاية صحية منزلية مرخصة من الدولة ، نكرس أنفسنا لنقدم لك سوى أقصى درجات الخدمة كطريقتنا لاستعادة ثقتك بنا.</p>\r\n\r\n<p>مهنيونا المهرة مهذبون وداعمون وودودون. لقد تم فحصهم بعناية وتلقوا تدريبات متخصصة بانتظام. نريدك أن تشعر بالراحة عندما تسمح لموظفينا بالدخول إلى منازلك.</p>\r\n\r\n<p>تشمل خدماتنا على سبيل المثال لا الحصر:</p>\r\n\r\n<p>خدمات التمريض<br />\r\nخدمات المساعدة الصحية المنزلية وصانع المنزل<br />\r\nالعلاج الطبيعي والمهني والنطق</p>', 'active', '2021-01-13 18:00:30', '2020-12-15 08:11:36');
INSERT INTO `pages` (`id`, `title`, `menu_id`, `page_name`, `parent_menu`, `meta_description`, `meta_keyword`, `image`, `default_page`, `content_en`, `content_fr`, `content_es`, `content_ar`, `status`, `updated_at`, `created_at`) VALUES
(6, 'Career', 6, 'careers', 0, 'Career', 'Career', 'iz2b8erSTZYeE3QoDV1YCRZie4Kaf1lngEuVInEF.png', 1, '<h2 class=\"text-uppercase mt-0\">CAREER <span class=\"text-theme-color-2\">OPPURTUNITIES</span></h2>\r\n\r\n<p>Lorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur.</p>\r\n\r\n<p>gorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur</p>\r\n\r\n<p><a class=\"mk btn btn-colored btn-lg btn-flat btn-theme-colored border-left-theme-color-2-6px pl-20 pr-20\" href=\"https://revival-homecare-agency.breezy.hr/\">Click here to apply for current openings</a></p>\r\n\r\n<p>&nbsp;</p>', '<h2 class=\"text-uppercase mt-0\">CAREER <span class=\"text-theme-color-2\">OPPURTUNITIES</span></h2>\r\n\r\n<p>Lorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur.</p>\r\n\r\n<p>gorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur</p>\r\n\r\n<p><a class=\"mk btn btn-colored btn-lg btn-flat btn-theme-colored border-left-theme-color-2-6px pl-20 pr-20\" href=\"https://revival-homecare-agency.breezy.hr/\">Click here to apply for current openings</a></p>', '<h2 class=\"text-uppercase mt-0\">CAREER <span class=\"text-theme-color-2\">OPPURTUNITIES</span></h2>\r\n\r\n<p>Lorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur.</p>\r\n\r\n<p>gorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur</p>\r\n\r\n<p><a class=\"mk btn btn-colored btn-lg btn-flat btn-theme-colored border-left-theme-color-2-6px pl-20 pr-20\" href=\"https://revival-homecare-agency.breezy.hr/\">Click here to apply for current openings</a></p>', '<h2 class=\"text-uppercase mt-0\">CAREER <span class=\"text-theme-color-2\">OPPURTUNITIES</span></h2>\r\n\r\n<p>Lorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur.</p>\r\n\r\n<p>gorem ipsum dolor sit amet conse ctetur lorem ipsum dolor sit amet conse ctetur</p>\r\n\r\n<p><a class=\"mk btn btn-colored btn-lg btn-flat btn-theme-colored border-left-theme-color-2-6px pl-20 pr-20\" href=\"https://revival-homecare-agency.breezy.hr/\">Click here to apply for current openings</a></p>', 'active', '2020-12-19 02:17:41', '2020-12-15 08:19:10'),
(7, 'RESOURCES', 7, 'resources', 0, 'RESOURCES', 'RESOURCES', 'nxnooIrabjl5pulXqjHNZA5Qq6xiDrXzeMyfQSrZ.png', 1, '<h2 class=\"text-uppercase mt-0\">RESOURCES</h2>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"http://www.dhmh.state.md.us/\" target=\"_blank\">Maryland Department of Health and Mental Hygiene</a></li>\r\n	<li><a href=\"http://www.marylandrn.org/\" target=\"_blank\">Maryland Nurses Association</a></li>\r\n	<li><a href=\"http://mhcc.maryland.gov/\" target=\"_blank\">Maryland Healthcare Commission</a></li>\r\n	<li><a href=\"http://www.medicinenet.com/\" target=\"_blank\">MedicineNet &ndash; Health and Medical Information Produced by Doctors</a></li>\r\n	<li><a href=\"http://www.everydayhealth.com/\" target=\"_blank\">Everyday Health &ndash; Online Health Information</a></li>\r\n	<li><a href=\"http://www.healthfinder.gov/\" target=\"_blank\">Health Finder</a>&nbsp;www.healthfinder.gov</li>\r\n	<li><a href=\"http://www.jointcommission.org/\" target=\"_blank\">Joint Commission on Accreditation of Healthcare Organizations</a></li>\r\n	<li><a href=\"http://www.webmd.com/\" target=\"_blank\">WebMD</a>&nbsp;www.webmd.com</li>\r\n	<li><a href=\"http://caregiving.com/\" target=\"_blank\">Caregiving &ndash; Insights, Information, Inspirations</a></li>\r\n	<li><a href=\"http://www.asbestos.com/\" target=\"_blank\">Asbestos &ndash; The Mesothelioma Center</a></li>\r\n	<li><a href=\"https://www.mesotheliomaveterans.org/mesothelioma/symptoms/\" target=\"_blank\">Mesothelioma Symptoms</a></li>\r\n</ul>', '<h2 class=\"text-uppercase mt-0\">RESOURCES</h2>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"http://www.dhmh.state.md.us/\" target=\"_blank\">Maryland Department of Health and Mental Hygiene</a></li>\r\n	<li><a href=\"http://www.marylandrn.org/\" target=\"_blank\">Maryland Nurses Association</a></li>\r\n	<li><a href=\"http://mhcc.maryland.gov/\" target=\"_blank\">Maryland Healthcare Commission</a></li>\r\n	<li><a href=\"http://www.medicinenet.com/\" target=\"_blank\">MedicineNet &ndash; Health and Medical Information Produced by Doctors</a></li>\r\n	<li><a href=\"http://www.everydayhealth.com/\" target=\"_blank\">Everyday Health &ndash; Online Health Information</a></li>\r\n	<li><a href=\"http://www.healthfinder.gov/\" target=\"_blank\">Health Finder</a>&nbsp;www.healthfinder.gov</li>\r\n	<li><a href=\"http://www.jointcommission.org/\" target=\"_blank\">Joint Commission on Accreditation of Healthcare Organizations</a></li>\r\n	<li><a href=\"http://www.webmd.com/\" target=\"_blank\">WebMD</a>&nbsp;www.webmd.com</li>\r\n	<li><a href=\"http://caregiving.com/\" target=\"_blank\">Caregiving &ndash; Insights, Information, Inspirations</a></li>\r\n	<li><a href=\"http://www.asbestos.com/\" target=\"_blank\">Asbestos &ndash; The Mesothelioma Center</a></li>\r\n	<li><a href=\"https://www.mesotheliomaveterans.org/mesothelioma/symptoms/\" target=\"_blank\">Mesothelioma Symptoms</a></li>\r\n</ul>', '<h2 class=\"text-uppercase mt-0\">RESOURCES</h2>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"http://www.dhmh.state.md.us/\" target=\"_blank\">Maryland Department of Health and Mental Hygiene</a></li>\r\n	<li><a href=\"http://www.marylandrn.org/\" target=\"_blank\">Maryland Nurses Association</a></li>\r\n	<li><a href=\"http://mhcc.maryland.gov/\" target=\"_blank\">Maryland Healthcare Commission</a></li>\r\n	<li><a href=\"http://www.medicinenet.com/\" target=\"_blank\">MedicineNet &ndash; Health and Medical Information Produced by Doctors</a></li>\r\n	<li><a href=\"http://www.everydayhealth.com/\" target=\"_blank\">Everyday Health &ndash; Online Health Information</a></li>\r\n	<li><a href=\"http://www.healthfinder.gov/\" target=\"_blank\">Health Finder</a>&nbsp;www.healthfinder.gov</li>\r\n	<li><a href=\"http://www.jointcommission.org/\" target=\"_blank\">Joint Commission on Accreditation of Healthcare Organizations</a></li>\r\n	<li><a href=\"http://www.webmd.com/\" target=\"_blank\">WebMD</a>&nbsp;www.webmd.com</li>\r\n	<li><a href=\"http://caregiving.com/\" target=\"_blank\">Caregiving &ndash; Insights, Information, Inspirations</a></li>\r\n	<li><a href=\"http://www.asbestos.com/\" target=\"_blank\">Asbestos &ndash; The Mesothelioma Center</a></li>\r\n	<li><a href=\"https://www.mesotheliomaveterans.org/mesothelioma/symptoms/\" target=\"_blank\">Mesothelioma Symptoms</a></li>\r\n</ul>', '<h2 class=\"text-uppercase mt-0\">RESOURCES</h2>\r\n\r\n<ul class=\"list-img\">\r\n	<li><a href=\"http://www.dhmh.state.md.us/\" target=\"_blank\">Maryland Department of Health and Mental Hygiene</a></li>\r\n	<li><a href=\"http://www.marylandrn.org/\" target=\"_blank\">Maryland Nurses Association</a></li>\r\n	<li><a href=\"http://mhcc.maryland.gov/\" target=\"_blank\">Maryland Healthcare Commission</a></li>\r\n	<li><a href=\"http://www.medicinenet.com/\" target=\"_blank\">MedicineNet &ndash; Health and Medical Information Produced by Doctors</a></li>\r\n	<li><a href=\"http://www.everydayhealth.com/\" target=\"_blank\">Everyday Health &ndash; Online Health Information</a></li>\r\n	<li><a href=\"http://www.healthfinder.gov/\" target=\"_blank\">Health Finder</a>&nbsp;www.healthfinder.gov</li>\r\n	<li><a href=\"http://www.jointcommission.org/\" target=\"_blank\">Joint Commission on Accreditation of Healthcare Organizations</a></li>\r\n	<li><a href=\"http://www.webmd.com/\" target=\"_blank\">WebMD</a>&nbsp;www.webmd.com</li>\r\n	<li><a href=\"http://caregiving.com/\" target=\"_blank\">Caregiving &ndash; Insights, Information, Inspirations</a></li>\r\n	<li><a href=\"http://www.asbestos.com/\" target=\"_blank\">Asbestos &ndash; The Mesothelioma Center</a></li>\r\n	<li><a href=\"https://www.mesotheliomaveterans.org/mesothelioma/symptoms/\" target=\"_blank\">Mesothelioma Symptoms</a></li>\r\n</ul>', 'active', '2020-12-19 02:18:50', '2020-12-15 08:54:21'),
(8, 'HOME HEALTH AIDE SERVICES', 0, 'health-aid-services', 0, 'HOME HEALTH AIDE SERVICES', 'HOME HEALTH AIDE SERVICES', 'd7vtujUBwUVkdzsOwYRTtj8Nsez0h8UCVUlg3QrW.png', 1, '<h2 class=\"text-uppercase mt-0\">Home Health Aide <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our health aides will provide care support and services to our clients to help them feel relieved and relaxed. Without going out of your house, our employees will give your loved one with hands-on personal care to maintain their health.</p>\r\n\r\n<p>Our Home Health Aide Services include the following:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Bathing, grooming and personal hygiene assistance</li>\r\n	<li>Companionship</li>\r\n	<li>Light housekeeping</li>\r\n	<li>Meal preparation</li>\r\n	<li>Medication management</li>\r\n	<li>Mobility assistance</li>\r\n	<li>Blood pressure and temperature monitoring</li>\r\n	<li>Dedicated attention and general supervision of health</li>\r\n	<li>Bathing</li>\r\n	<li>Skin care</li>\r\n	<li>Oral hygiene</li>\r\n	<li>Nail care</li>\r\n	<li>Home exercise program</li>\r\n	<li>Ambulation</li>\r\n	<li>Simple wound care</li>\r\n	<li>Bowel program</li>\r\n	<li>Catheter care</li>\r\n	<li>Light meal preparation</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Home Maker Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Light meal preparation</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you</p>', '<h2 class=\"text-uppercase mt-0\">Home Health Aide <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our health aides will provide care support and services to our clients to help them feel relieved and relaxed. Without going out of your house, our employees will give your loved one with hands-on personal care to maintain their health.</p>\r\n\r\n<p>Our Home Health Aide Services include the following:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Bathing, grooming and personal hygiene assistance</li>\r\n	<li>Companionship</li>\r\n	<li>Light housekeeping</li>\r\n	<li>Meal preparation</li>\r\n	<li>Medication management</li>\r\n	<li>Mobility assistance</li>\r\n	<li>Blood pressure and temperature monitoring</li>\r\n	<li>Dedicated attention and general supervision of health</li>\r\n	<li>Bathing</li>\r\n	<li>Skin care</li>\r\n	<li>Oral hygiene</li>\r\n	<li>Nail care</li>\r\n	<li>Home exercise program</li>\r\n	<li>Ambulation</li>\r\n	<li>Simple wound care</li>\r\n	<li>Bowel program</li>\r\n	<li>Catheter care</li>\r\n	<li>Light meal preparation</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Home Maker Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Light meal preparation</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you</p>', '<h2 class=\"text-uppercase mt-0\">Home Health Aide <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our health aides will provide care support and services to our clients to help them feel relieved and relaxed. Without going out of your house, our employees will give your loved one with hands-on personal care to maintain their health.</p>\r\n\r\n<p>Our Home Health Aide Services include the following:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Bathing, grooming and personal hygiene assistance</li>\r\n	<li>Companionship</li>\r\n	<li>Light housekeeping</li>\r\n	<li>Meal preparation</li>\r\n	<li>Medication management</li>\r\n	<li>Mobility assistance</li>\r\n	<li>Blood pressure and temperature monitoring</li>\r\n	<li>Dedicated attention and general supervision of health</li>\r\n	<li>Bathing</li>\r\n	<li>Skin care</li>\r\n	<li>Oral hygiene</li>\r\n	<li>Nail care</li>\r\n	<li>Home exercise program</li>\r\n	<li>Ambulation</li>\r\n	<li>Simple wound care</li>\r\n	<li>Bowel program</li>\r\n	<li>Catheter care</li>\r\n	<li>Light meal preparation</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Home Maker Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Light meal preparation</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you</p>', '<h2 class=\"text-uppercase mt-0\">Home Health Aide <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our health aides will provide care support and services to our clients to help them feel relieved and relaxed. Without going out of your house, our employees will give your loved one with hands-on personal care to maintain their health.</p>\r\n\r\n<p>Our Home Health Aide Services include the following:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Bathing, grooming and personal hygiene assistance</li>\r\n	<li>Companionship</li>\r\n	<li>Light housekeeping</li>\r\n	<li>Meal preparation</li>\r\n	<li>Medication management</li>\r\n	<li>Mobility assistance</li>\r\n	<li>Blood pressure and temperature monitoring</li>\r\n	<li>Dedicated attention and general supervision of health</li>\r\n	<li>Bathing</li>\r\n	<li>Skin care</li>\r\n	<li>Oral hygiene</li>\r\n	<li>Nail care</li>\r\n	<li>Home exercise program</li>\r\n	<li>Ambulation</li>\r\n	<li>Simple wound care</li>\r\n	<li>Bowel program</li>\r\n	<li>Catheter care</li>\r\n	<li>Light meal preparation</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Home Maker Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Light meal preparation</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n	<li>Wash dishes</li>\r\n	<li>Dust</li>\r\n	<li>Vacuum</li>\r\n	<li>Take out the trash</li>\r\n	<li>Laundry</li>\r\n	<li>Iron clothes</li>\r\n	<li>Change linens</li>\r\n	<li>Make the bed</li>\r\n	<li>Answer the phone</li>\r\n	<li>Sort &amp; assist in reading mail</li>\r\n	<li>Answer the door</li>\r\n	<li>Clip coupons</li>\r\n	<li>Shop for gifts</li>\r\n	<li>Pet care</li>\r\n	<li>Write letters</li>\r\n	<li>Check food freshness</li>\r\n	<li>Grocery shop</li>\r\n	<li>Care for houseplants</li>\r\n	<li>Pick up prescriptions</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you</p>', 'active', '2020-12-29 10:09:32', '2020-12-15 10:55:45'),
(9, 'PHYSICAL, OCCUPATIONAL AND SPEECH THERAP', 0, 'physical-occupational-services', 0, 'PHYSICAL, OCCUPATIONAL AND SPEECH THERAPY SERVICES', 'PHYSICAL, OCCUPATIONAL AND SPEECH THERAPY SERVICES', 'O2YRcyogjIrIQMRcAktV60pDc1tzgnYTREw8KOGF.png', 1, '<h2 class=\"text-uppercase mt-0\">Physical, Occupational and Speech Therapy <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our therapists can provide assessment and solutions to our patients. They will be with you to make sure you get the right treatment. Our highly experienced therapists will work around the clock to be certain that all your needs are attended.</p>\r\n\r\n<p>Our Physical Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain Management</li>\r\n	<li>Post Surgery Care</li>\r\n	<li>Pre Surgery Care</li>\r\n	<li>Education and Training in the use of Assistive Devices</li>\r\n	<li>Orthopedics</li>\r\n	<li>Pediatrics</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Improving Range Of Motion</li>\r\n	<li>Muscle Re-Education</li>\r\n	<li>Regaining Mobility</li>\r\n	<li>Relearning Daily Living Skills And Self-Care Skills</li>\r\n	<li>Strength Training</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Occupational Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Health Assessment</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Basic Skills Evaluation</li>\r\n	<li>Basic Level Skills Education and Training</li>\r\n	<li>Device Assistance Training</li>\r\n	<li>Pain Management</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Therapeutic Programs</li>\r\n	<li>Strength Enhancement</li>\r\n	<li>Balance Restoration</li>\r\n	<li>Sensory Functions Restoration</li>\r\n	<li>Energy Conservation and Management</li>\r\n	<li>Muscle Control Restoration and Enhancement</li>\r\n	<li>Mobility Enhancement</li>\r\n</ul>\r\n\r\n<p>Our Speech Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Home Safety</li>\r\n	<li>Speech</li>\r\n	<li>Language</li>\r\n	<li>Dysphagia (Swallowing)</li>\r\n	<li>Cognition</li>\r\n	<li>Adaptive Speech Devices</li>\r\n	<li>Aural (Hearing) Rehabilitation</li>\r\n	<li>Non-oral Communication</li>\r\n	<li>Home Speech and Language Exercise Program</li>\r\n	<li>Patient Education</li>\r\n	<li>Communication Options/Alternatives</li>\r\n	<li>Eating and Swallowing Strategies</li>\r\n	<li>Speech Articulation Exercise</li>\r\n	<li>Aural Rehabilitation</li>\r\n	<li>Cognitive Skills Evaluation</li>\r\n	<li>Comprehension Skills Assessment</li>\r\n	<li>Sensory Skills Assessment</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', '<h2 class=\"text-uppercase mt-0\">Physical, Occupational and Speech Therapy <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our therapists can provide assessment and solutions to our patients. They will be with you to make sure you get the right treatment. Our highly experienced therapists will work around the clock to be certain that all your needs are attended.</p>\r\n\r\n<p>Our Physical Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain Management</li>\r\n	<li>Post Surgery Care</li>\r\n	<li>Pre Surgery Care</li>\r\n	<li>Education and Training in the use of Assistive Devices</li>\r\n	<li>Orthopedics</li>\r\n	<li>Pediatrics</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Improving Range Of Motion</li>\r\n	<li>Muscle Re-Education</li>\r\n	<li>Regaining Mobility</li>\r\n	<li>Relearning Daily Living Skills And Self-Care Skills</li>\r\n	<li>Strength Training</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Occupational Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Health Assessment</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Basic Skills Evaluation</li>\r\n	<li>Basic Level Skills Education and Training</li>\r\n	<li>Device Assistance Training</li>\r\n	<li>Pain Management</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Therapeutic Programs</li>\r\n	<li>Strength Enhancement</li>\r\n	<li>Balance Restoration</li>\r\n	<li>Sensory Functions Restoration</li>\r\n	<li>Energy Conservation and Management</li>\r\n	<li>Muscle Control Restoration and Enhancement</li>\r\n	<li>Mobility Enhancement</li>\r\n</ul>\r\n\r\n<p>Our Speech Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Home Safety</li>\r\n	<li>Speech</li>\r\n	<li>Language</li>\r\n	<li>Dysphagia (Swallowing)</li>\r\n	<li>Cognition</li>\r\n	<li>Adaptive Speech Devices</li>\r\n	<li>Aural (Hearing) Rehabilitation</li>\r\n	<li>Non-oral Communication</li>\r\n	<li>Home Speech and Language Exercise Program</li>\r\n	<li>Patient Education</li>\r\n	<li>Communication Options/Alternatives</li>\r\n	<li>Eating and Swallowing Strategies</li>\r\n	<li>Speech Articulation Exercise</li>\r\n	<li>Aural Rehabilitation</li>\r\n	<li>Cognitive Skills Evaluation</li>\r\n	<li>Comprehension Skills Assessment</li>\r\n	<li>Sensory Skills Assessment</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', '<h2 class=\"text-uppercase mt-0\">Physical, Occupational and Speech Therapy <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our therapists can provide assessment and solutions to our patients. They will be with you to make sure you get the right treatment. Our highly experienced therapists will work around the clock to be certain that all your needs are attended.</p>\r\n\r\n<p>Our Physical Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain Management</li>\r\n	<li>Post Surgery Care</li>\r\n	<li>Pre Surgery Care</li>\r\n	<li>Education and Training in the use of Assistive Devices</li>\r\n	<li>Orthopedics</li>\r\n	<li>Pediatrics</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Improving Range Of Motion</li>\r\n	<li>Muscle Re-Education</li>\r\n	<li>Regaining Mobility</li>\r\n	<li>Relearning Daily Living Skills And Self-Care Skills</li>\r\n	<li>Strength Training</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Occupational Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Health Assessment</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Basic Skills Evaluation</li>\r\n	<li>Basic Level Skills Education and Training</li>\r\n	<li>Device Assistance Training</li>\r\n	<li>Pain Management</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Therapeutic Programs</li>\r\n	<li>Strength Enhancement</li>\r\n	<li>Balance Restoration</li>\r\n	<li>Sensory Functions Restoration</li>\r\n	<li>Energy Conservation and Management</li>\r\n	<li>Muscle Control Restoration and Enhancement</li>\r\n	<li>Mobility Enhancement</li>\r\n</ul>\r\n\r\n<p>Our Speech Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Home Safety</li>\r\n	<li>Speech</li>\r\n	<li>Language</li>\r\n	<li>Dysphagia (Swallowing)</li>\r\n	<li>Cognition</li>\r\n	<li>Adaptive Speech Devices</li>\r\n	<li>Aural (Hearing) Rehabilitation</li>\r\n	<li>Non-oral Communication</li>\r\n	<li>Home Speech and Language Exercise Program</li>\r\n	<li>Patient Education</li>\r\n	<li>Communication Options/Alternatives</li>\r\n	<li>Eating and Swallowing Strategies</li>\r\n	<li>Speech Articulation Exercise</li>\r\n	<li>Aural Rehabilitation</li>\r\n	<li>Cognitive Skills Evaluation</li>\r\n	<li>Comprehension Skills Assessment</li>\r\n	<li>Sensory Skills Assessment</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', '<h2 class=\"text-uppercase mt-0\">Physical, Occupational and Speech Therapy <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>Our therapists can provide assessment and solutions to our patients. They will be with you to make sure you get the right treatment. Our highly experienced therapists will work around the clock to be certain that all your needs are attended.</p>\r\n\r\n<p>Our Physical Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain Management</li>\r\n	<li>Post Surgery Care</li>\r\n	<li>Pre Surgery Care</li>\r\n	<li>Education and Training in the use of Assistive Devices</li>\r\n	<li>Orthopedics</li>\r\n	<li>Pediatrics</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Improving Range Of Motion</li>\r\n	<li>Muscle Re-Education</li>\r\n	<li>Regaining Mobility</li>\r\n	<li>Relearning Daily Living Skills And Self-Care Skills</li>\r\n	<li>Strength Training</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Our Occupational Therapy Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Health Assessment</li>\r\n	<li>Body Mechanics</li>\r\n	<li>Basic Skills Evaluation</li>\r\n	<li>Basic Level Skills Education and Training</li>\r\n	<li>Device Assistance Training</li>\r\n	<li>Pain Management</li>\r\n	<li>Exercise Programs</li>\r\n	<li>Therapeutic Programs</li>\r\n	<li>Strength Enhancement</li>\r\n	<li>Balance Restoration</li>\r\n	<li>Sensory Functions Restoration</li>\r\n	<li>Energy Conservation and Management</li>\r\n	<li>Muscle Control Restoration and Enhancement</li>\r\n	<li>Mobility Enhancement</li>\r\n</ul>\r\n\r\n<p>Our Speech Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Home Safety</li>\r\n	<li>Speech</li>\r\n	<li>Language</li>\r\n	<li>Dysphagia (Swallowing)</li>\r\n	<li>Cognition</li>\r\n	<li>Adaptive Speech Devices</li>\r\n	<li>Aural (Hearing) Rehabilitation</li>\r\n	<li>Non-oral Communication</li>\r\n	<li>Home Speech and Language Exercise Program</li>\r\n	<li>Patient Education</li>\r\n	<li>Communication Options/Alternatives</li>\r\n	<li>Eating and Swallowing Strategies</li>\r\n	<li>Speech Articulation Exercise</li>\r\n	<li>Aural Rehabilitation</li>\r\n	<li>Cognitive Skills Evaluation</li>\r\n	<li>Comprehension Skills Assessment</li>\r\n	<li>Sensory Skills Assessment</li>\r\n</ul>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', 'active', '2020-12-29 12:01:35', '2020-12-15 11:58:11'),
(10, 'REVIVAL UNIVERSITY', 0, 'revival-university', 0, 'REVIVAL UNIVERSITY', 'REVIVAL UNIVERSITY', 'fFmtoRo7LaKpqPc8Qo4G1Y2PMqyqlg0pb3GjvUmq.png', 1, '<h2 class=\"text-uppercase mt-0\">Revival <span class=\"text-theme-color-2\">University</span></h2>\r\n\r\n<h3>Our Events</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Joint Replacement Flyer</a></p>\r\n\r\n<p>Continuing education hours: this course has been approved for 20 CEUs by DC, VA and MD physical therapy boards.</p>\r\n\r\n<p>Presenter: Dr. M. El Mohandess, PT, DPT, MBA, CSCS, CCE</p>\r\n\r\n<h3>Our Brochures</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Management of Chronic Diseases and Wounds</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Quality Care In the Comfort of Your Own Home</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Osteoarthritis/ Hip Fracture</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">COPD Chronic Obstructive Pulmonary Disease and Stroke</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Dementia / Fall Prevention Risk Factors &amp; Improving the Quality of Life</a></p>\r\n\r\n<p>*disclaimer: please disregard our outdated contact information on these brochures and look under Contact Us for updated information</p>', '<h2 class=\"text-uppercase mt-0\">Revival <span class=\"text-theme-color-2\">University</span></h2>\r\n\r\n<h3>Our Events</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Joint Replacement Flyer</a></p>\r\n\r\n<p>Continuing education hours: this course has been approved for 20 CEUs by DC, VA and MD physical therapy boards.</p>\r\n\r\n<p>Presenter: Dr. M. El Mohandess, PT, DPT, MBA, CSCS, CCE</p>\r\n\r\n<h3>Our Brochures</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Management of Chronic Diseases and Wounds</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Quality Care In the Comfort of Your Own Home</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Osteoarthritis/ Hip Fracture</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">COPD Chronic Obstructive Pulmonary Disease and Stroke</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Dementia / Fall Prevention Risk Factors &amp; Improving the Quality of Life</a></p>\r\n\r\n<p>*disclaimer: please disregard our outdated contact information on these brochures and look under Contact Us for updated information</p>', '<h2 class=\"text-uppercase mt-0\">Revival <span class=\"text-theme-color-2\">University</span></h2>\r\n\r\n<h3>Our Events</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Joint Replacement Flyer</a></p>\r\n\r\n<p>Continuing education hours: this course has been approved for 20 CEUs by DC, VA and MD physical therapy boards.</p>\r\n\r\n<p>Presenter: Dr. M. El Mohandess, PT, DPT, MBA, CSCS, CCE</p>\r\n\r\n<h3>Our Brochures</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Management of Chronic Diseases and Wounds</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Quality Care In the Comfort of Your Own Home</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Osteoarthritis/ Hip Fracture</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">COPD Chronic Obstructive Pulmonary Disease and Stroke</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Dementia / Fall Prevention Risk Factors &amp; Improving the Quality of Life</a></p>\r\n\r\n<p>*disclaimer: please disregard our outdated contact information on these brochures and look under Contact Us for updated information</p>', '<h2 class=\"text-uppercase mt-0\">Revival <span class=\"text-theme-color-2\">University</span></h2>\r\n\r\n<h3>Our Events</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Joint Replacement Flyer</a></p>\r\n\r\n<p>Continuing education hours: this course has been approved for 20 CEUs by DC, VA and MD physical therapy boards.</p>\r\n\r\n<p>Presenter: Dr. M. El Mohandess, PT, DPT, MBA, CSCS, CCE</p>\r\n\r\n<h3>Our Brochures</h3>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Management of Chronic Diseases and Wounds</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Quality Care In the Comfort of Your Own Home</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Osteoarthritis/ Hip Fracture</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">COPD Chronic Obstructive Pulmonary Disease and Stroke</a></p>\r\n\r\n<p><a href=\"\" style=\"color:#0075ae\">Dementia / Fall Prevention Risk Factors &amp; Improving the Quality of Life</a></p>\r\n\r\n<p>*disclaimer: please disregard our outdated contact information on these brochures and look under Contact Us for updated information</p>', 'active', '2020-12-29 10:32:31', '2020-12-15 12:07:58'),
(11, 'WAIVER PROGRAM', 0, 'waiver-program', 0, 'WAIVER PROGRAM', 'WAIVER PROGRAM', 'BsIUxFJSHVMS4cog549D7KVqlgX2AkYncW4lA3MP.png', 1, '<h2 class=\"text-uppercase mt-0\">Waiver <span class=\"text-theme-color-2\">Program</span></h2>\r\n\r\n<p>Here is an overview of the Waiver Program</p>\r\n\r\n<p><a href=\"https://www.dmas.virginia.gov/#/index\" hreh=\"http://www.dmas.virginia.gov/Content_pgs/ltc-home.aspx\" style=\"color:#0075ae\" target=\"_blank\">https://www.dmas.virginia.gov/#/index</a></p>\r\n\r\n<p>Revival Homecare Agency only works with ECDC waiver</p>\r\n\r\n<p><a href=\"https://www.dmas.virginia.gov/files/links/632/EDCD%20Waiver%20(Elderly%20or%20Disabled%20with%20Consumer%20Direction%20-%20Currently%20known%20as%20CCC%20Plus%20Waiver).pdf\" style=\"color:#0075ae\" target=\"_blank\">https://www.dmas.virginia.gov/files/links/632/EDCD%20Waiver%20(Elderly%20or%20Disabled%20with%20Consumer%20Direction%20-%20Currently%20known%20as%20CCC%20Plus%20Waiver).pdf</a></p>', '<h2 class=\"text-uppercase mt-0\">Waiver <span class=\"text-theme-color-2\">Program</span></h2>  \r\n              <p>Here is an overview of the Waiver Program</p>\r\n              <p><a style=\"color:#0075ae\" hreh=\"http://www.dmas.virginia.gov/Content_pgs/ltc-home.aspx\">http://www.dmas.virginia.gov/Content_pgs/ltc-home.aspx</a></p>\r\n\r\n            <p>Revival Homecare Agency only works with ECDC waiver</p>\r\n          <p><a style=\"color:#0075ae\" href=\"http://www.dmas.virginia.gov/Content_atchs/ltc/ltc-omfs6.pdf\">http://www.dmas.virginia.gov/Content_atchs/ltc/ltc-omfs6.pdf</a></p>', '<h2 class=\"text-uppercase mt-0\">Waiver <span class=\"text-theme-color-2\">Program</span></h2>\r\n\r\n<p>Here is an overview of the Waiver Program</p>\r\n\r\n<p><a href=\"https://www.dmas.virginia.gov/#/index\" hreh=\"http://www.dmas.virginia.gov/Content_pgs/ltc-home.aspx\" style=\"color:#0075ae\" target=\"_blank\">https://www.dmas.virginia.gov/#/index</a></p>\r\n\r\n<p>Revival Homecare Agency only works with ECDC waiver</p>\r\n\r\n<p><a href=\"https://www.dmas.virginia.gov/files/links/632/EDCD%20Waiver%20(Elderly%20or%20Disabled%20with%20Consumer%20Direction%20-%20Currently%20known%20as%20CCC%20Plus%20Waiver).pdf\" style=\"color:#0075ae\" target=\"_blank\">https://www.dmas.virginia.gov/files/links/632/EDCD%20Waiver%20(Elderly%20or%20Disabled%20with%20Consumer%20Direction%20-%20Currently%20known%20as%20CCC%20Plus%20Waiver).pdf</a></p>\r\n\r\n<p>&nbsp;</p>', '<h2 class=\"text-uppercase mt-0\">Waiver <span class=\"text-theme-color-2\">Program</span></h2>\r\n\r\n<p>Here is an overview of the Waiver Program</p>\r\n\r\n<p><a href=\"https://www.dmas.virginia.gov/#/index\" hreh=\"http://www.dmas.virginia.gov/Content_pgs/ltc-home.aspx\" style=\"color:#0075ae\" target=\"_blank\">https://www.dmas.virginia.gov/#/index</a></p>\r\n\r\n<p>Revival Homecare Agency only works with ECDC waiver</p>\r\n\r\n<p><a href=\"https://www.dmas.virginia.gov/files/links/632/EDCD%20Waiver%20(Elderly%20or%20Disabled%20with%20Consumer%20Direction%20-%20Currently%20known%20as%20CCC%20Plus%20Waiver).pdf\" style=\"color:#0075ae\" target=\"_blank\">https://www.dmas.virginia.gov/files/links/632/EDCD%20Waiver%20(Elderly%20or%20Disabled%20with%20Consumer%20Direction%20-%20Currently%20known%20as%20CCC%20Plus%20Waiver).pdf</a></p>\r\n\r\n<p>&nbsp;</p>', 'active', '2020-12-30 12:17:50', '2020-12-15 12:10:10'),
(12, 'NURSING SERVICES', 0, 'nursing-services', 0, 'NURSING SERVICES', 'NURSING SERVICES', 'IUGzSAf24E0il1O3JU2f05JnrB4Vos0FbWyA8rB3.png', 1, '<h2 class=\"text-uppercase mt-0\">Nursing <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>In Nursing Services, our registered nurse works with the patient to prevent them from catching any diseases and to promote good health. We provide comfort and relaxation for our client. Our services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Diabetic Training</li>\r\n	<li>Drawing Blood and Lab Work</li>\r\n	<li>Dressing Changes</li>\r\n	<li>Family-Patient Health Teaching</li>\r\n	<li>IV Treatments</li>\r\n	<li>Respiratory Care</li>\r\n	<li>Rehabilitative Care</li>\r\n	<li>Supervision of Medications</li>\r\n	<li>Treatments and Injections</li>\r\n	<li>Wound Care</li>\r\n</ul>\r\n\r\n<h3 class=\"text-uppercase mt-0\">Drugs and Pain Relief and Symptom Management</h3>\r\n\r\n<p>Illness, diseases and post surgery recovery can bring pain to people. At <b>REVIVAL HOMECARE AGENCY</b>, one of our goals is to treat pain and bring relief to our patients. Our competent medical practitioners will provide drugs and pain relief and management to help your loved one get better. Our Drugs and Pain Relief and Symptom Management Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain consultation</li>\r\n	<li>Assessment of pain due to injury, illness or surgery</li>\r\n	<li>Identification of obstacles to recovery</li>\r\n	<li>Pain treatment using approaches, such as medications and rehabilitation counseling</li>\r\n	<li>Long-term pain relief and prevention</li>\r\n	<li>Patient education</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', '<h2 class=\"text-uppercase mt-0\">Nursing <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>In Nursing Services, our registered nurse works with the patient to prevent them from catching any diseases and to promote good health. We provide comfort and relaxation for our client. Our services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Diabetic Training</li>\r\n	<li>Drawing Blood and Lab Work</li>\r\n	<li>Dressing Changes</li>\r\n	<li>Family-Patient Health Teaching</li>\r\n	<li>IV Treatments</li>\r\n	<li>Respiratory Care</li>\r\n	<li>Rehabilitative Care</li>\r\n	<li>Supervision of Medications</li>\r\n	<li>Treatments and Injections</li>\r\n	<li>Wound Care</li>\r\n</ul>\r\n\r\n<h3 class=\"text-uppercase mt-0\">Drugs and Pain Relief and Symptom Management</h3>\r\n\r\n<p>Illness, diseases and post surgery recovery can bring pain to people. At <b>REVIVAL HOMECARE AGENCY</b>, one of our goals is to treat pain and bring relief to our patients. Our competent medical practitioners will provide drugs and pain relief and management to help your loved one get better. Our Drugs and Pain Relief and Symptom Management Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain consultation</li>\r\n	<li>Assessment of pain due to injury, illness or surgery</li>\r\n	<li>Identification of obstacles to recovery</li>\r\n	<li>Pain treatment using approaches, such as medications and rehabilitation counseling</li>\r\n	<li>Long-term pain relief and prevention</li>\r\n	<li>Patient education</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', '<h2 class=\"text-uppercase mt-0\">Nursing <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>In Nursing Services, our registered nurse works with the patient to prevent them from catching any diseases and to promote good health. We provide comfort and relaxation for our client. Our services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Diabetic Training</li>\r\n	<li>Drawing Blood and Lab Work</li>\r\n	<li>Dressing Changes</li>\r\n	<li>Family-Patient Health Teaching</li>\r\n	<li>IV Treatments</li>\r\n	<li>Respiratory Care</li>\r\n	<li>Rehabilitative Care</li>\r\n	<li>Supervision of Medications</li>\r\n	<li>Treatments and Injections</li>\r\n	<li>Wound Care</li>\r\n</ul>\r\n\r\n<h3 class=\"text-uppercase mt-0\">Drugs and Pain Relief and Symptom Management</h3>\r\n\r\n<p>Illness, diseases and post surgery recovery can bring pain to people. At <b>REVIVAL HOMECARE AGENCY</b>, one of our goals is to treat pain and bring relief to our patients. Our competent medical practitioners will provide drugs and pain relief and management to help your loved one get better. Our Drugs and Pain Relief and Symptom Management Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain consultation</li>\r\n	<li>Assessment of pain due to injury, illness or surgery</li>\r\n	<li>Identification of obstacles to recovery</li>\r\n	<li>Pain treatment using approaches, such as medications and rehabilitation counseling</li>\r\n	<li>Long-term pain relief and prevention</li>\r\n	<li>Patient education</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', '<h2 class=\"text-uppercase mt-0\">Nursing <span class=\"text-theme-color-2\">Services</span></h2>\r\n\r\n<p>In Nursing Services, our registered nurse works with the patient to prevent them from catching any diseases and to promote good health. We provide comfort and relaxation for our client. Our services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Diabetic Training</li>\r\n	<li>Drawing Blood and Lab Work</li>\r\n	<li>Dressing Changes</li>\r\n	<li>Family-Patient Health Teaching</li>\r\n	<li>IV Treatments</li>\r\n	<li>Respiratory Care</li>\r\n	<li>Rehabilitative Care</li>\r\n	<li>Supervision of Medications</li>\r\n	<li>Treatments and Injections</li>\r\n	<li>Wound Care</li>\r\n</ul>\r\n\r\n<h3 class=\"text-uppercase mt-0\">Drugs and Pain Relief and Symptom Management</h3>\r\n\r\n<p>Illness, diseases and post surgery recovery can bring pain to people. At <b>REVIVAL HOMECARE AGENCY</b>, one of our goals is to treat pain and bring relief to our patients. Our competent medical practitioners will provide drugs and pain relief and management to help your loved one get better. Our Drugs and Pain Relief and Symptom Management Services include:</p>\r\n\r\n<ul class=\"list-img\">\r\n	<li>Pain consultation</li>\r\n	<li>Assessment of pain due to injury, illness or surgery</li>\r\n	<li>Identification of obstacles to recovery</li>\r\n	<li>Pain treatment using approaches, such as medications and rehabilitation counseling</li>\r\n	<li>Long-term pain relief and prevention</li>\r\n	<li>Patient education</li>\r\n</ul>\r\n\r\n<p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>', 'active', '2020-12-28 19:16:05', '2020-12-15 12:12:39'),
(13, 'CLIENT\'S TESTIMONIALS', 8, 'testimonials', 0, 'CLIENT\'S TESTIMONIALS', 'CLIENT\'S TESTIMONIALS', 'jmcSQ3GhVjq9D9do76FUenn8qQLO9UTQxFpztrxp.png', 1, '<h2 class=\"text-uppercase mt-0\"><span class=\"text-theme-color-2\">Client&#39;s testimonials</span></h2>\r\n\r\n<p class=\"rev-p\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<h2 class=\"text-uppercase mt-0\"><span class=\"text-theme-color-2\">Client&#39;s testimonials</span></h2>\r\n\r\n<p class=\"rev-p\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<h2 class=\"text-uppercase mt-0\"><span class=\"text-theme-color-2\">Client&#39;s testimonials</span></h2>\r\n\r\n<p class=\"rev-p\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<h2 class=\"text-uppercase mt-0\"><span class=\"text-theme-color-2\">Client&#39;s testimonials</span></h2>\r\n\r\n<p class=\"rev-p\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', 'active', '2021-01-06 03:57:03', '2020-12-16 06:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('jfgh@wwe.com', 'c8ac89e2839e852526419ae8939c195e43b4a5ee69af4407f889e26bdf4299f4', '2020-11-04 14:54:44'),
('fghdg@dd.com', '85e6e9389174f71b13409fca59545dadf2e2f02942c9f67846fce578effd1e0e', '2020-11-04 17:22:01');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `module_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'full_roles', 'web', 1, 'active', '2020-10-26 21:26:39', '2020-10-26 21:26:39'),
(2, 'view_roles', 'web', 1, 'active', '2020-10-26 21:26:39', '2020-10-26 21:26:39'),
(3, 'add_roles', 'web', 1, 'active', '2020-10-26 21:26:39', '2020-10-26 21:26:39'),
(4, 'assign_roles', 'web', 1, 'inactive', '2020-10-26 21:26:40', '2020-10-26 21:26:40'),
(5, 'edit_roles', 'web', 1, 'active', '2020-10-26 21:26:40', '2020-10-26 21:26:40'),
(6, 'edit_others_roles', 'web', 1, 'inactive', '2020-10-26 21:26:40', '2020-10-26 21:26:40'),
(7, 'delete_roles', 'web', 1, 'active', '2020-10-26 21:26:40', '2020-10-26 21:26:40'),
(8, 'delete_others_roles', 'web', 1, 'inactive', '2020-10-26 21:26:40', '2020-10-26 21:26:40'),
(9, 'approval_roles', 'web', 1, 'inactive', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(10, 'full_users', 'web', 2, 'active', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(11, 'view_users', 'web', 2, 'active', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(12, 'add_users', 'web', 2, 'active', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(13, 'assign_users', 'web', 2, 'inactive', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(14, 'edit_users', 'web', 2, 'active', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(15, 'edit_others_users', 'web', 2, 'inactive', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(16, 'delete_users', 'web', 2, 'active', '2020-10-26 21:26:41', '2020-10-26 21:26:41'),
(17, 'delete_others_users', 'web', 2, 'inactive', '2020-10-26 21:26:42', '2020-10-26 21:26:42'),
(18, 'approval_users', 'web', 2, 'inactive', '2020-10-26 21:26:42', '2020-10-26 21:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `status`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'web', 'active', 0, '2020-10-26 21:26:42', '2020-10-26 21:26:42', NULL),
(2, 'User', 'web', 'active', 0, '2020-10-26 21:26:45', '2020-10-26 21:26:45', NULL),
(3, 'User', 'web', 'active', 0, '2020-10-26 21:28:16', '2020-10-26 21:28:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(7, 3),
(8, 1),
(8, 2),
(8, 3),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(10, 2),
(10, 3),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 2),
(13, 3),
(14, 1),
(14, 2),
(14, 3),
(15, 1),
(15, 2),
(15, 3),
(16, 1),
(16, 2),
(16, 3),
(17, 1),
(17, 2),
(17, 3),
(18, 1),
(18, 2),
(18, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Home Slider', 'E07T3snR2ykI3PXy0yikDwiNBgfAL8dBBTnhcNRH.png', 'active', '2020-12-15 12:29:49', '2020-12-19 03:20:54'),
(7, 'Revial BG', 'U92LQEcDfRrRTkoWj5SJy11J7W4Nf0ZwO220QpKO.png', 'active', '2020-12-15 12:45:50', '2020-12-29 11:46:05'),
(8, 'Slider 3', 'DlD0ragJjXEjstkPgixAItERtHqff7fdFrPNXF5K.png', 'active', '2020-12-15 12:48:32', '2020-12-29 11:54:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `change_email_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `changed_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `login` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `designation`, `team`, `department`, `email`, `email_verified_at`, `password`, `remember_token`, `image`, `mobile`, `change_email`, `change_email_token`, `changed_at`, `status`, `login`, `last_login_at`, `last_login_ip`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Revival', 'Admin', NULL, NULL, NULL, 'admin@gmail.com', NULL, '$2y$10$u.G3JTmBuNNy7UrEcNJW8eBq0OUJq9vm7TEsmv2FmEg18VOnelOAa', NULL, '1boXG36mFwBzoOFMG2uZlIMf1mQCHfcBBSOxSQxz.png', '23423423422', NULL, NULL, NULL, 'active', 'no', '2024-04-10 01:49:17', '127.0.0.1', '2020-10-26 21:28:18', '2024-04-09 20:19:52', NULL),
(3, 'Ayyanar', 'Dev', NULL, NULL, NULL, 'inr@gmail.com', NULL, '$2y$10$JX8SYtZdC/4g7AOZ0Yt1w.h9XVWc7aOJPaD4cYjwrDZx16.wyYZI2', NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'no', NULL, NULL, '2020-10-26 21:28:19', '2020-10-26 21:28:19', NULL),
(4, 'jgfhj', 'fghj', NULL, NULL, NULL, 'jfgh@wwe.com', NULL, '$2y$10$Xw5zG8QTtAqj5WT3CQdaAuc7W0Un../C4weTaZJfFhFFftNt7PhaC', NULL, NULL, '4534534534', NULL, NULL, NULL, 'active', 'no', NULL, NULL, '2020-11-04 14:54:42', '2020-11-04 14:54:42', NULL),
(5, 'hdf', 'ghdfgh', NULL, NULL, NULL, 'fghdg@dd.com', NULL, '$2y$10$OQQ4IlZv8iql80yleOxxX.p9KvZer5B5jVpl0G702r.AuKr9Q/6Gm', NULL, NULL, '453453454', NULL, NULL, NULL, 'active', 'no', NULL, NULL, '2020-11-04 17:22:00', '2020-11-04 17:22:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_menu` (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
