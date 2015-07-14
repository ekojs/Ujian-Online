-- phpMyAdmin SQL Dump
-- version 3.4.11deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 15, 2013 at 08:48 PM
-- Server version: 5.5.24
-- PHP Version: 5.4.4-4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `simple_tes`
--

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `admin` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `detail_kelas` (
  `nis` varchar(20) NOT NULL,
  `id_kelas` mediumint(9) NOT NULL,
  UNIQUE KEY `nis` (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `guru` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` mediumint(9) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(50) NOT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


CREATE TABLE IF NOT EXISTS `mapel` (
  `id_mp` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nama_mp` varchar(50) NOT NULL,
  PRIMARY KEY (`id_mp`),
  UNIQUE KEY `nama_mp` (`nama_mp`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

CREATE TABLE IF NOT EXISTS `mengajar` (
  `id_mp` int(3) NOT NULL,
  `id_kelas` mediumint(9) NOT NULL,
  `id_guru` varchar(20) NOT NULL,
  PRIMARY KEY (`id_mp`,`id_kelas`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `nilai` (
  `id_nilai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` varchar(30) NOT NULL,
  `id_ujian` varchar(20) NOT NULL,
  `nilai` float NOT NULL,
  `detail_jawaban` text,
  `jml_benar` tinyint(4) NOT NULL,
  `jml_salah` tinyint(4) NOT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;


CREATE TABLE IF NOT EXISTS `pil_jawaban` (
  `id_jawaban` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_soal` varchar(10) NOT NULL,
  `jawaban` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jawaban`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=311 ;


CREATE TABLE IF NOT EXISTS `siswa` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`nis`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `soal` (
  `id_soal` varchar(10) NOT NULL,
  `id_ujian` varchar(8) NOT NULL,
  `isi_soal` text NOT NULL,
  PRIMARY KEY (`id_soal`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `ujian` (
  `id_ujian` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_ujian` varchar(50) NOT NULL,
  `id_mp` varchar(10) NOT NULL,
  `id_kelas` mediumint(9) NOT NULL,
  `tanggal` datetime NOT NULL,
  `waktu` varchar(8) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_ujian`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `level` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

