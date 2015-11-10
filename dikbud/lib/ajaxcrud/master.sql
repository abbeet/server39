CREATE TABLE IF NOT EXISTS `master_department` (
  `ID` int(5) NOT NULL auto_increment,
  `DepartmentName` varchar(50) NOT NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `master_department`
--

INSERT INTO `master_department` (`ID`, `DepartmentName`) VALUES
(1, 'Programmer'),
(2, 'Designer'),
(3, 'HRD'),
(4, 'Finance'),
(5, 'Manager'),
(6, 'Director');

-- --------------------------------------------------------

--
-- Table structure for table `master_pegawai`
--

CREATE TABLE IF NOT EXISTS `master_pegawai` (
  `ID` int(5) NOT NULL auto_increment,
  `NIP` char(5) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Department` int(5) NOT NULL,
  PRIMARY KEY  (`ID`),
  UNIQUE KEY `NIP` (`NIP`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `master_pegawai`
--

INSERT INTO `master_pegawai` (`ID`, `NIP`, `Name`, `Address`, `Department`) VALUES
(4, 'P01', 'Chandra Jatnika', 'test', 1),
(5, 'P02', 'Cruzi Oldolin', '', 2),
(6, 'P03', 'Suke Ponesix', 'xxxxxxxxx uuuuuuu', 6),
(7, 'P04', 'Domisini Postinour', 'juk', 5);
