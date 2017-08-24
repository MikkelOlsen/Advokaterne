-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 24. 08 2017 kl. 13:20:47
-- Serverversion: 5.6.24
-- PHP-version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `advokaterne`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `blogcategory`
--

CREATE TABLE IF NOT EXISTS `blogcategory` (
  `id` int(11) NOT NULL,
  `categoryName` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `blogcategory`
--

INSERT INTO `blogcategory` (`id`, `categoryName`) VALUES
(4, 'Nyheder'),
(5, 'retard');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `blogpost`
--

CREATE TABLE IF NOT EXISTS `blogpost` (
  `id` int(11) NOT NULL,
  `postTitle` varchar(25) DEFAULT NULL,
  `postText` text,
  `fk_img` int(11) DEFAULT NULL,
  `fk_user` int(11) DEFAULT NULL,
  `fk_cat` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `blogpost`
--

INSERT INTO `blogpost` (`id`, `postTitle`, `postText`, `fk_img`, `fk_user`, `fk_cat`, `date`) VALUES
(22, 'Blog V2', 'Dette er min fÃ¸rste rigtige post, sÃ¥ lad os da se om der kan redigeres i den. Man har vel lov at hÃ¥be', 17, 1, 4, '2017-06-13 14:35:28'),
(23, 'Yus', 'Min tard er din tard&#13;&#10;', 18, 1, 5, '2017-08-18 12:44:55');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `information`
--

CREATE TABLE IF NOT EXISTS `information` (
  `id` int(11) NOT NULL,
  `history` text,
  `purpose` text,
  `motto` text,
  `fk_img` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `information`
--

INSERT INTO `information` (`id`, `history`, `purpose`, `motto`, `fk_img`) VALUES
(1, 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus suscipit quae, dolor commodi est dolorem possimus expedita officiis id ex voluptatem perspiciatis enim similique obcaecati asperiores? Distinctio labore sapiente recusandae?&#13;&#10;', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus suscipit quae, dolor commodi est dolorem possimus expedita officiis id ex voluptatem perspiciatis enim similique obcaecati asperiores? Distinctio labore sapiente recusandae?&#13;&#10;', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus suscipit quae, dolor commodi est dolorem possimus expedita officiis id ex voluptatem perspiciatis enim similique obcaecati asperiores? Distinctio labore sapiente recusandae?&#13;&#10;', 17);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `type` varchar(90) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `media`
--

INSERT INTO `media` (`id`, `path`, `type`) VALUES
(17, '1503556228_people.jpg', 'image/jpeg'),
(18, '1503556146_work.jpg', 'image/png'),
(21, '1503556244_agent.jpg', 'image/jpeg'),
(22, '1503556253_agent.jpg', 'image/jpeg'),
(23, '1503556271_agent.jpg', 'image/jpeg'),
(24, '1503556305_agent.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `senderName` varchar(45) NOT NULL,
  `senderEmail` varchar(65) NOT NULL,
  `senderMsg` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `messages`
--

INSERT INTO `messages` (`id`, `senderName`, `senderEmail`, `senderMsg`) VALUES
(2, 'Min arm', 'ender@idit.dk', 'rÃ¸vhul lige nu');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `newsletter`
--

CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(65) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(2, 'mikkel@gmail.com');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL,
  `serviceName` varchar(25) DEFAULT NULL,
  `serviceText` text,
  `fk_img` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `services`
--

INSERT INTO `services` (`id`, `serviceName`, `serviceText`, `fk_img`) VALUES
(2, 'Uhm', 'virke', 21),
(3, 'Billede', 'test', 22),
(4, 'Law V2', 'This is the law! obey the law!', 23),
(5, 'Rebels', 'DENIED ACCESS!', 24);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `sitesettings`
--

CREATE TABLE IF NOT EXISTS `sitesettings` (
  `id` int(11) NOT NULL,
  `copyright` varchar(45) DEFAULT NULL,
  `facebook` varchar(65) DEFAULT NULL,
  `twitter` varchar(65) DEFAULT NULL,
  `googlePlus` varchar(65) DEFAULT NULL,
  `siteName` varchar(45) DEFAULT NULL,
  `siteCity` varchar(45) DEFAULT NULL,
  `siteAdress` varchar(45) DEFAULT NULL,
  `siteEmail` varchar(45) DEFAULT NULL,
  `siteZip` varchar(45) DEFAULT NULL,
  `sitePhone` int(15) NOT NULL,
  `contactMsg` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `sitesettings`
--

INSERT INTO `sitesettings` (`id`, `copyright`, `facebook`, `twitter`, `googlePlus`, `siteName`, `siteCity`, `siteAdress`, `siteEmail`, `siteZip`, `sitePhone`, `contactMsg`) VALUES
(1, 'Copyright 2012. All rights reserved', 'http://facebook.com', 'http://twitter.com', 'http://google.com', 'ADVOKADOERNE', 'Test Byen', 'En rigtig adresse 32', 'min@mail.com', '4500', 50102030, 'Herunder kan du finde vores kontakt oplysninger');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(65) DEFAULT NULL,
  `story` text,
  `rating` int(5) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `story`, `rating`, `date`) VALUES
(1, 'En glad kunde', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus suscipit quae, dolor commodi est dolorem possimus expedita officiis id ex voluptatem perspiciatis enim similique obcaecati asperiores? Distinctio labore sapiente recusandae?&#13;&#10;', NULL, '2017-08-24 08:32:10'),
(2, 'En tilfreds kunde', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus suscipit quae, dolor commodi est dolorem possimus expedita officiis id ex voluptatem perspiciatis enim similique obcaecati asperiores? Distinctio labore sapiente recusandae?&#13;&#10;', NULL, '2017-08-24 08:32:18'),
(3, 'Superb', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus suscipit quae, dolor commodi est dolorem possimus expedita officiis id ex voluptatem perspiciatis enim similique obcaecati asperiores? Distinctio labore sapiente recusandae?&#13;&#10;', NULL, '2017-08-24 08:32:33');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `userroles`
--

CREATE TABLE IF NOT EXISTS `userroles` (
  `id` int(11) NOT NULL,
  `navn` varchar(10) DEFAULT NULL,
  `niveau` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `userroles`
--

INSERT INTO `userroles` (`id`, `navn`, `niveau`) VALUES
(1, 'Superadmin', 99),
(2, 'Admin', 90),
(3, 'Medarb', 50);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `navn` varchar(65) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(70) DEFAULT NULL,
  `fk_userrole` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`id`, `navn`, `email`, `password`, `fk_userrole`) VALUES
(1, 'Retardo Gert', 'robot@ninja.com', '$2y$12$j/tIF/4vuIDddsKRww4jqubibYq3TKp/k9VfrTA1S0AuVv51s5f8G', 1),
(4, 'Fucktard', 'retard@bob.com', '$2y$12$yAWTVKlF6ScVcu4wiLMVpeyGUgwdrVnmJ4MEl9zEeL3njVC9PxQMu', 3);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `blogcategory`
--
ALTER TABLE `blogcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `blogpost`
--
ALTER TABLE `blogpost`
  ADD PRIMARY KEY (`id`), ADD KEY `blogImg_idx` (`fk_img`), ADD KEY `blogUser_idx` (`fk_user`), ADD KEY `blogCat_idx` (`fk_cat`);

--
-- Indeks for tabel `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`), ADD KEY `infoImg_idx` (`fk_img`);

--
-- Indeks for tabel `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`), ADD KEY `serviceImg_idx` (`fk_img`);

--
-- Indeks for tabel `sitesettings`
--
ALTER TABLE `sitesettings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD KEY `userRole_idx` (`fk_userrole`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `blogcategory`
--
ALTER TABLE `blogcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `blogpost`
--
ALTER TABLE `blogpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- Tilføj AUTO_INCREMENT i tabel `information`
--
ALTER TABLE `information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Tilføj AUTO_INCREMENT i tabel `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- Tilføj AUTO_INCREMENT i tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Tilføj AUTO_INCREMENT i tabel `sitesettings`
--
ALTER TABLE `sitesettings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Tilføj AUTO_INCREMENT i tabel `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `userroles`
--
ALTER TABLE `userroles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Tilføj AUTO_INCREMENT i tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `blogpost`
--
ALTER TABLE `blogpost`
ADD CONSTRAINT `blogCat` FOREIGN KEY (`fk_cat`) REFERENCES `blogcategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `blogImg` FOREIGN KEY (`fk_img`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `blogUser` FOREIGN KEY (`fk_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `information`
--
ALTER TABLE `information`
ADD CONSTRAINT `infoImg` FOREIGN KEY (`fk_img`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `services`
--
ALTER TABLE `services`
ADD CONSTRAINT `serviceImg` FOREIGN KEY (`fk_img`) REFERENCES `media` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
ADD CONSTRAINT `userRole` FOREIGN KEY (`fk_userrole`) REFERENCES `userroles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
