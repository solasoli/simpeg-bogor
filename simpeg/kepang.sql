-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 22, 2011 at 06:58 
-- Server version: 5.5.8
-- PHP Version: 5.3.5

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
-- Table structure for table `berkas`
--

CREATE TABLE IF NOT EXISTS `berkas` (
  `id_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_kat` int(11) NOT NULL,
  `nm_berkas` varchar(50) NOT NULL,
  `ket_berkas` varchar(250) NOT NULL,
  `tgl_upload` date NOT NULL,
  `byk_hal` int(11) NOT NULL,
  `tgl_berkas` date NOT NULL,
  PRIMARY KEY (`id_berkas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `berkas`
--


-- --------------------------------------------------------

--
-- Table structure for table `isi_berkas`
--

CREATE TABLE IF NOT EXISTS `isi_berkas` (
  `id_berkas` int(11) NOT NULL,
  `id_isi_berkas` int(11) NOT NULL AUTO_INCREMENT,
  `hal_ke` int(11) NOT NULL,
  `ket` varchar(250) NOT NULL,
  `URL` text,
  PRIMARY KEY (`id_isi_berkas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `isi_berkas`
--


-- --------------------------------------------------------

--
-- Table structure for table `syarat_mutasi`
--

CREATE TABLE IF NOT EXISTS `syarat_mutasi` (
  `id_syarat` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `id_proses` int(11) NOT NULL,
  `id_berkas_skcpns` int(11) NOT NULL,
  `cek_cpns` int(11) NOT NULL DEFAULT '0',
  `id_berkas_sttpl` int(11) NOT NULL,
  `cek_sttpl` int(11) NOT NULL DEFAULT '0',
  `id_berkas_sknaikpangkat` int(11) NOT NULL,
  `cek_sknaikpangkat` int(11) NOT NULL DEFAULT '0',
  `id_berkas_ijazah` int(11) NOT NULL,
  `cek_jjazah` int(11) NOT NULL DEFAULT '0',
  `id_berkas_dp31` int(11) NOT NULL,
  `cek_dp31` int(11) NOT NULL DEFAULT '0',
  `id_berkas_dp32` int(11) NOT NULL,
  `cek_dp32` int(11) NOT NULL,
  `id_berkas_alihtugas` int(11) NOT NULL,
  `cek_alihtugas` int(11) NOT NULL DEFAULT '0',
  `id_berkas_uraiantugas` int(11) NOT NULL,
  `cek_uraiantuugas` int(11) NOT NULL DEFAULT '0',
  `id_berkas_mutasijabatan` int(11) NOT NULL,
  `cek_mutasijabatan` int(11) NOT NULL DEFAULT '0',
  `id_berkas_skpns` int(11) NOT NULL,
  `cek_skpns` int(11) NOT NULL DEFAULT '0',
  `id_berkas_karpeg` int(11) NOT NULL,
  `cek_karpeg` int(11) NOT NULL DEFAULT '0',
  `id_berkas_udin` int(11) NOT NULL,
  `cek_udin` int(11) NOT NULL DEFAULT '0',
  `id_berkas_pi` int(11) NOT NULL,
  `cek_pi` int(11) NOT NULL DEFAULT '0',
  `tglpengajuan` date NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_syarat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `syarat_mutasi`
--

