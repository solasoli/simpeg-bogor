-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 27, 2010 at 09:53 
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simpeg`
--

-- --------------------------------------------------------

--
-- Table structure for table `sk`
--

CREATE TABLE IF NOT EXISTS `sk` (
  `id_sk` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) unsigned NOT NULL,
  `id_kategori_sk` int(11) unsigned NOT NULL,
  `no_sk` varchar(55) NOT NULL,
  `tgl_sk` date NOT NULL,
  `pemberi_sk` varchar(255) NOT NULL,
  `pengesah_sk` varchar(255) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  `tmt` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id_sk`),
  KEY `FK_sk_pegawai` (`id_pegawai`),
  KEY `FK_sk_kategori` (`id_kategori_sk`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=176927 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
