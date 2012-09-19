-- phpMyAdmin SQL Dump
-- version 3.3.7deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 19, 2012 at 06:25 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_format_nomor`
--

CREATE TABLE IF NOT EXISTS `akses_format_nomor` (
  `aAkses_format_nomorid` int(100) NOT NULL AUTO_INCREMENT,
  `aIDformat_nomor` int(20) NOT NULL,
  `aIDdepartement` int(20) NOT NULL,
  PRIMARY KEY (`aAkses_format_nomorid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;



-- --------------------------------------------------------

--
-- Table structure for table `announce`
--

CREATE TABLE IF NOT EXISTS `announce` (
  `aAnnounceid` int(1) NOT NULL,
  `aAnnounce_content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announce`
--

INSERT INTO `announce` (`aAnnounceid`, `aAnnounce_content`) VALUES
(1, 'ini konten announce');

-- --------------------------------------------------------

--
-- Table structure for table `departement`
--

CREATE TABLE IF NOT EXISTS `departement` (
  `dDepartementid` int(20) NOT NULL AUTO_INCREMENT,
  `dCode_departement` varchar(100) NOT NULL,
  `dKeterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`dDepartementid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `departement`
--

INSERT INTO `departement` (`dDepartementid`, `dCode_departement`, `dKeterangan`) VALUES
(3, 'MAN', 'Manager'),
(2, 'IT', 'IT'),
(1, 'ADMIN', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `format_nomor`
--

CREATE TABLE IF NOT EXISTS `format_nomor` (
  `fFormat_nomorid` int(20) NOT NULL AUTO_INCREMENT,
  `fDeskripsi` varchar(100) NOT NULL,
  `fJenis_surat` varchar(100) NOT NULL,
  PRIMARY KEY (`fFormat_nomorid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


--
-- Table structure for table `hak_akses`
--

CREATE TABLE IF NOT EXISTS `hak_akses` (
  `uHak_askesid` int(20) NOT NULL AUTO_INCREMENT,
  `uIDuser` int(20) NOT NULL,
  `uUser` varchar(20) NOT NULL,
  `uPassword` varchar(20) NOT NULL,
  `uFormat_surat` varchar(20) NOT NULL,
  `uSurat_keluar` varchar(20) NOT NULL,
  `uLaporan` varchar(20) NOT NULL,
  PRIMARY KEY (`uHak_askesid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`uHak_askesid`, `uIDuser`, `uUser`, `uPassword`, `uFormat_surat`, `uSurat_keluar`, `uLaporan`) VALUES
(1, 1, '|n|r|e|d', '|n|r|e|d', '|n|r|e|d', '|n|r|e|d', '|r|p'),
(15, 15, '||||', '|r|e', '||||', '|n|r||', '||'),
(14, 14, '||||', '|r|e', '||||', '|n|r||', '||');

-- --------------------------------------------------------

--
-- Table structure for table `multiple_format_nomor`
--

CREATE TABLE IF NOT EXISTS `multiple_format_nomor` (
  `mMultiple_format_nomor` int(20) NOT NULL AUTO_INCREMENT,
  `mIDformat_nomor` int(20) NOT NULL,
  `mDelimiter` varchar(50) DEFAULT NULL,
  `mUrutan` int(20) NOT NULL,
  `mIsi` varchar(100) NOT NULL,
  PRIMARY KEY (`mMultiple_format_nomor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `multiple_format_nomor`
--

INSERT INTO `multiple_format_nomor` (`mMultiple_format_nomor`, `mIDformat_nomor`, `mDelimiter`, `mUrutan`, `mIsi`) VALUES
(9, 1, '/', 4, 'tahun+otomatis'),
(8, 1, '/', 3, 'bulan+otomatis'),
(7, 1, '/', 2, 'dept+otomatis'),
(6, 1, '/', 1, 'jenis+MDA'),
(10, 1, '', 5, 'start+001'),
(11, 2, '/', 1, 'jenis+SOV'),
(12, 2, '/', 2, 'dept+otomatis'),
(13, 2, '/', 4, 'bulan+otomatis'),
(14, 2, '/', 3, 'tahun+otomatis'),
(15, 2, '.', 5, 'start+0007'),
(16, 3, '/', 1, 'jenis+JKA'),
(17, 3, '/', 2, 'dept+otomatis'),
(18, 3, '/', 3, 'start+00007');

-- --------------------------------------------------------

--
-- Table structure for table `nomor_session`
--

CREATE TABLE IF NOT EXISTS `nomor_session` (
  `nNomor_sessionid` int(20) NOT NULL AUTO_INCREMENT,
  `nJenis_surat` int(20) NOT NULL,
  `nJumlah` int(20) NOT NULL,
  `nIDformat_nomor` int(20) NOT NULL,
  `nTanggal` date NOT NULL,
  `nJudul` varchar(100) NOT NULL,
  `nKepada` varchar(100) NOT NULL,
  `nDari` varchar(100) NOT NULL,
  `nKeterangan` varchar(100) NOT NULL,
  `nTembusan` varchar(100) NOT NULL,
  `nNomor_full` varchar(100) NOT NULL,
  `nIDdepartement` int(20) NOT NULL,
  `nIDuser` int(20) NOT NULL,
  PRIMARY KEY (`nNomor_sessionid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Table structure for table `session_user`
--

CREATE TABLE IF NOT EXISTS `session_user` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `surat_keluar`
--

CREATE TABLE IF NOT EXISTS `surat_keluar` (
  `sSurat_keluarid` int(20) NOT NULL AUTO_INCREMENT,
  `sJudul` varchar(100) NOT NULL,
  `sBerkas` varchar(100) NOT NULL,
  `sKeterangan` varchar(100) NOT NULL,
  `sWaktu` date NOT NULL,
  `sIDformat_nomor` int(20) NOT NULL,
  `sKepada` varchar(100) NOT NULL,
  `sDari` varchar(100) NOT NULL,
  `sTembusan` varchar(100) NOT NULL,
  `sNomorfull` varchar(100) NOT NULL,
  `sIDdepartement` int(20) NOT NULL,
  `sIDuser` int(20) NOT NULL,
  `sWaktu_pembuatan` datetime NOT NULL,
  PRIMARY KEY (`sSurat_keluarid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uUserid` int(20) NOT NULL AUTO_INCREMENT,
  `uUsername` varchar(100) NOT NULL,
  `uPassword` varchar(100) NOT NULL,
  `uNama` varchar(100) NOT NULL,
  `uIDdepartement` int(10) NOT NULL,
  `uStatus` int(20) NOT NULL,
  `uIDnomor_session` int(20) NOT NULL,
  `uSpecial` int(2) NOT NULL,
  `uPosition` int(2) NOT NULL,
  PRIMARY KEY (`uUserid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uUserid`, `uUsername`, `uPassword`, `uNama`, `uIDdepartement`, `uStatus`, `uIDnomor_session`, `uSpecial`, `uPosition`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'mada arya', 1, 0, 34, 0, 3),
(15, 'sovia', '0fa09c266963cc8e94c8e36ef20230188d991c30', 'sovia', 3, 0, 0, 0, 0),
(14, 'mada', 'a84d0af6aca8c3b116dd7e5c9fbac4ebbe0eb1bc', 'mada', 2, 0, 10, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_special`
--

CREATE TABLE IF NOT EXISTS `user_special` (
  `uUser_specialid` int(10) NOT NULL AUTO_INCREMENT,
  `uIDuser` int(20) NOT NULL,
  `uIDdepartement` int(20) NOT NULL,
  PRIMARY KEY (`uUser_specialid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_special`
--

