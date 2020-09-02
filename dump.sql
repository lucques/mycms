-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 20, 2011 at 11:33 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mycmsfoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `mycms_categories`
--

DROP TABLE IF EXISTS `mycms_categories`;
CREATE TABLE IF NOT EXISTS `mycms_categories` (
  `id` varchar(256) NOT NULL,
  `title` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mycms_categories`
--

INSERT INTO `mycms_categories` (`id`, `title`) VALUES
('unkategorisiert', 'Unkategorisiert');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_comments`
--

DROP TABLE IF EXISTS `mycms_comments`;
CREATE TABLE IF NOT EXISTS `mycms_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nick` text NOT NULL,
  `email` text NOT NULL,
  `website` text NOT NULL,
  `content` text NOT NULL,
  `post_id` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mycms_comments`
--

INSERT INTO `mycms_comments` (`id`, `timestamp`, `nick`, `email`, `website`, `content`, `post_id`) VALUES
(1, '2010-07-16 12:29:08', 'Mr. Mycms', 'mycms@example.com', '', 'Dies ist ein Kommentar. Du kannst ihn bearbeiten oder löschen.', 'hello-world');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_posts`
--

DROP TABLE IF EXISTS `mycms_posts`;
CREATE TABLE IF NOT EXISTS `mycms_posts` (
  `id` varchar(256) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `author_id` text NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `show_comments` tinyint(1) NOT NULL,
  `allow_comments` tinyint(1) NOT NULL,
  `show_link` tinyint(1) NOT NULL,
  `show_timestamp` tinyint(1) NOT NULL,
  `show_author` tinyint(1) NOT NULL,
  `is_static` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mycms_posts`
--

INSERT INTO `mycms_posts` (`id`, `timestamp`, `author_id`, `title`, `content`, `show_comments`, `allow_comments`, `show_link`, `show_timestamp`, `show_author`, `is_static`) VALUES
('hello-world', '2010-07-14 11:12:00', 'admin', 'Hello, world!', '<p>\r\nDies ist der erste Post in deinem Weblog. Du kannst ihn nun bearbeiten oder löschen!\r\n</p> \r\n\r\n\r\n', 1, 1, 1, 1, 1, 0),
('about', '2010-07-14 11:19:00', 'admin', 'About', '<p>\r\nDies ist ein statischer Post, das heißt, er wird nicht auf der Startseite und in den Monatsarchiven angezeigt. Du kannst ihn bearbeiten oder löschen.\r\n</p>', 0, 0, 0, 0, 0, 1),
('notfound', '2008-06-08 11:36:15', 'admin', 'Nicht gefunden', '<p>\r\nDie gesuchte Seite kann leider nicht gefunden werden.\r\n</p>', 0, 0, 0, 0, 0, 1),
('unauthorized', '2008-11-16 17:43:46', 'admin', 'Zugriff verweigert', '<p>\r\nDer Zugriff zu dieser Seite ist dir leider nicht gestattet!\r\n</p>', 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mycms_posts2categories`
--

DROP TABLE IF EXISTS `mycms_posts2categories`;
CREATE TABLE IF NOT EXISTS `mycms_posts2categories` (
  `post_id` varchar(256) NOT NULL,
  `category_id` varchar(256) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mycms_posts2categories`
--

INSERT INTO `mycms_posts2categories` (`post_id`, `category_id`) VALUES
('hello-world', 'unkategorisiert');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_roles`
--

DROP TABLE IF EXISTS `mycms_roles`;
CREATE TABLE IF NOT EXISTS `mycms_roles` (
  `id` varchar(256) NOT NULL,
  `title` text NOT NULL,
  `privileges` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mycms_roles`
--

INSERT INTO `mycms_roles` (`id`, `title`, `privileges`) VALUES
('administrator', 'Administrator', 'controllers.dashboard,controllers.addPost,controllers.editPost,controllers.deletePost,controllers.statisticsWidget,controllers.deleteComment,controllers.editComment,controllers.deleteCategory,controllers.editCategory,controllers.addCategory,controllers.editSettings,controllers.editUser'),
('guest', 'Guest', '');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_settings`
--

DROP TABLE IF EXISTS `mycms_settings`;
CREATE TABLE IF NOT EXISTS `mycms_settings` (
  `name` varchar(256) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mycms_settings`
--

INSERT INTO `mycms_settings` (`name`, `value`) VALUES
('meta.title', 'mycms'),
('meta.description', 'Ein weiteres mit mycms betriebenes Weblog'),
('controllers.showPost.commentAnchor', '#comment-%id%'),
('controllers.notFound.postId', 'notfound'),
('controllers.showPost.destination', '%id%/'),
('controllers.deleteComment.destination', 'admin/deletecomment/%id%/'),
('controllers.categoryArchive.destination', 'archives/%id%/'),
('controllers.yearMonthArchive.destination', 'archives/%year%/%month%/'),
('controllers.editComment.destination', 'admin/editcomment/%id%/'),
('controllers.recentPosts.destination', ''),
('controllers.editComment.templateDestination', 'templates/simple-de/'),
('controllers.deleteComment.templateDestination', 'templates/simple-de/'),
('controllers.unauthorized.postId', 'unauthorized'),
('controllers.showPost.templateDestination', 'templates/simple-de/'),
('controllers.showUser.templateDestination', 'templates/simple-de/'),
('controllers.categoryArchive.templateDestination', 'templates/simple-de/'),
('controllers.yearMonthArchive.templateDestination', 'templates/simple-de/'),
('controllers.dashboard.templateDestination', 'templates/simple-de/'),
('controllers.login.templateDestination', 'templates/simple-de/'),
('controllers.recentPosts.templateDestination', 'templates/simple-de/'),
('controllers.categoryArchive.postsPerPage', '10'),
('controllers.recentPostsFeed.templateDestination', 'templates/rss/'),
('controllers.addPost.templateDestination', 'templates/simple-de/'),
('controllers.deletePost.destination', 'admin/deletepost/%id%/'),
('controllers.yearMonthArchive.postsPerPage', '10'),
('controllers.recentPostsFeed.postsPerPage', '10'),
('controllers.recentPosts.postsPerPage', '10'),
('controllers.categoryArchive.destinationWithPage', 'archives/%id%/pages/%page%/'),
('controllers.yearMonthArchive.destinationWithPage', 'archives/%year%/%month%/pages/%page%/'),
('controllers.recentPosts.destinationWithPage', '%page%/'),
('datatypes.comment.website.required', '0'),
('datatypes.comment.email.required', '1'),
('datatypes.comment.nick.required', '1'),
('datatypes.comment.website.pattern', '(https?:\\/\\/.+){1,400}'),
('datatypes.comment.email.pattern', '(.+@.+){1,200}'),
('datatypes.user.email.pattern', '(.+@.+){1,200}'),
('datatypes.user.website.pattern', '(https?:\\/\\/.+){1,400}'),
('controllers.showPost.captcha.enabled', '1'),
('meta.language', 'de'),
('session.defaultUser', 'guest'),
('controllers.editPost.templateDestination', 'templates/simple-de/'),
('controllers.editPost.destination', 'admin/editpost/%id%/'),
('controllers.recentCommentsWidget.number', '10'),
('meta.footer', 'Angetrieben durch mycms'),
('controllers.deletePost.templateDestination', 'templates/simple-de/'),
('meta.timeZoneOffset', '+01:00'),
('meta.timeZoneOffsetInDST', '+02:00'),
('host', 'http://dev.mycms.de'),
('root', '/'),
('controllers.deleteCategory.templateDestination', 'templates/simple-de/'),
('controllers.deleteCategory.destination', 'admin/deletecategory/%id%/'),
('controllers.editCategory.templateDestination', 'templates/simple-de/'),
('controllers.editCategory.destination', 'admin/editcategory/%id%/'),
('controllers.addCategory.templateDestination', 'templates/simple-de/'),
('controllers.addCategory.destination', 'admin/addcategory/'),
('controllers.customPage.pages', ''),
('controllers.editSettings.templateDestination', 'templates/simple-de/'),
('controllers.editSettings.destination', 'admin/editsettings/'),
('controllers.customPage.templateDestination', 'templates/simple-de/'),
('controllers.dashboard.destination', 'admin/dashboard/'),
('controllers.addPost.destination', 'admin/addpost/'),
('controllers.logout.destination', 'admin/logout/'),
('controllers.editUser.destination', 'admin/edituser/%id%/'),
('controllers.editUser.templateDestination', 'templates/simple-de/'),
('datatypes.category.id.pattern', '[a-z0-9-]{1,200}'),
('datatypes.category.title.pattern', '.{1,200}'),
('datatypes.post.id.pattern', '[a-z0-9-]{1,200}'),
('datatypes.post.title.pattern', '.{1,200}'),
('datatypes.post.content.pattern', '.{1,16000}'),
('datatypes.comment.nick.pattern', '.{1,100}'),
('datatypes.comment.content.pattern', '.{1,4000}'),
('datatypes.setting.value.pattern', '.{0,500}'),
('datatypes.user.nick.pattern', '.{1,100}'),
('datatypes.user.password.pattern', '.{8,100}'),
('datatypes.user.id.pattern', '[a-z0-9-]{1,200}'),
('datatypes.customPage.pattern', '[a-z0-9-]{1,200}');

-- --------------------------------------------------------

--
-- Table structure for table `mycms_users`
--

DROP TABLE IF EXISTS `mycms_users`;
CREATE TABLE IF NOT EXISTS `mycms_users` (
  `id` varchar(256) NOT NULL,
  `role_id` varchar(256) NOT NULL,
  `nick` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `website` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mycms_users`
--

INSERT INTO `mycms_users` (`id`, `role_id`, `nick`, `password`, `email`, `website`) VALUES
('admin', 'administrator', 'Admin', '98bff8314c8ebeb9a8713d4387c80ef0', 'admin@example.com', 'http://www.example.de'),
('guest', 'guest', 'Guest', 'a684dd572b1887661782981659331eed', 'guest@example.com', 'http://example.com');
