-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2022 at 01:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ics499_animals`
--

-- --------------------------------------------------------

--
-- Table structure for table `custom_words`
--

CREATE TABLE `custom_words` (
  `Id` int(50) NOT NULL,
  `word` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `total_plays` int(10) NOT NULL,
  `winning_plays` int(10) NOT NULL,
  `clue` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custom_words`
--

INSERT INTO `custom_words` (`Id`, `word`, `Email`, `total_plays`, `winning_plays`, `clue`) VALUES
(1, 'test', 'marc.wedo@gmail.com', 0, 0, 'May induce stress in students'),
(2, 'exam', 'john.doe@gmail.com', 0, 0, 'An event that may be proctored'),
(3, 'final', 'marc.wedo@gmail.com', 1, 1, 'Could be a test or sporting event. Either way, there is a lot at stake.'),
(4, 'hello', 'marc.wedo@gmail.com', 1, 1 'A common greeting'),
(5, 'mule', 'marc.wedo@gmail.com', 0, 0, 'A beast of burden'),
(6, 'మండోదరి', 'marc.wedo@gmail.com', 0, 0, 'ఓ పురాణ పాత్ర');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `preference_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(10) DEFAULT NULL,
  `value` varchar(100) NOT NULL,
  `comments` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `puzzle_words`
--

CREATE TABLE `puzzle_words` (
  `word` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `total_plays` int(10) NOT NULL,
  `winning_plays` int(10) NOT NULL,
  `clue` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `puzzle_words`
--

INSERT INTO `puzzle_words` (`word`, `date`, `time`, `total_plays`, `winning_plays`, `clue`) VALUES
('ankle', '2022-07-06', '08:00:00', 0, 0, NULL),
('ant', '2022-07-10', '08:00:00', 0, 0, NULL),
('bad', '2022-07-04', '08:00:00', 0, 0, NULL),
('blind', '2022-07-09', '08:00:00', 0, 0, NULL),
('block', '2022-07-12', '08:00:00', 0, 0, NULL),
('cold', '2022-07-17', '08:00:00', 0, 0, NULL),
('cut', '2022-07-28', '08:00:00', 0, 0, NULL),
('dog', '2022-07-13', '08:00:00', 0, 0, NULL),
('duck', '2022-09-27', '08:00:00', 0, 0, NULL),
('eye', '2022-07-31', '08:00:00', 0, 0, NULL),
('fine', '2022-07-05', '08:00:00', 0, 0, NULL),
('fix', '2022-07-25', '08:00:00', 0, 0, NULL),
('flex', '2022-07-20', '08:00:00', 0, 0, NULL),
('flu', '2022-07-16', '08:00:00', 0, 0, NULL),
('fuss', '2022-07-29', '08:00:00', 0, 0, NULL),
('get', '2022-07-07', '08:00:00', 0, 0, NULL),
('half', '2022-07-23', '08:00:00', 0, 0, NULL),
('hay', '2022-07-19', '08:00:00', 0, 0, NULL),
('index', '2022-07-24', '08:00:00', 5, 4, NULL),
('late', '2022-07-08', '08:00:00', 0, 0, NULL),
('mole', '2022-08-01', '08:00:00', 0, 0, 'Name a small mammal'),
('muggy', '2022-08-02', '08:00:00', 0, 0, 'Slang word for humid'),
('open', '2022-07-26', '08:00:00', 9, 8, NULL),
('pitch', '2022-07-21', '08:00:00', 3, 2, NULL),
('quota', '2022-07-30', '08:00:00', 0, 0, NULL),
('reign', '2022-07-27', '08:00:00', 0, 0, NULL),
('relax', '2022-07-18', '08:00:00', 0, 0, NULL),
('south', '2022-07-15', '08:00:00', 0, 0, NULL),
('sun', '2022-07-22', '08:00:00', 0, 0, NULL),
('wrap', '2022-07-14', '08:00:00', 0, 0, NULL),
('అత్తయ్య', '2022-07-10', '20:00:00', 0, 0, NULL),
('అనాసపండు', '2022-07-15', '20:00:00', 0, 0, NULL),
('అప్పచ్చి', '2022-07-04', '20:00:00', 0, 0, NULL),
('ఆనందమయి', '2022-07-18', '20:00:00', 0, 0, NULL),
('ఆనందము', '2022-08-01', '20:00:00', 0, 0, NULL),
('కలువ', '2022-07-07', '20:00:00', 0, 0, NULL),
('గణపతి', '2022-07-08', '20:00:00', 0, 0, NULL),
('గుంటూరు', '2022-07-16', '20:00:00', 0, 0, NULL),
('చాడీకత్తె', '2022-07-17', '20:00:00', 0, 0, NULL),
('song', '2022-08-02', '20:00:00', 0, 0, 'Another name for a musical composition'),
('జాస్తిశివయ్య', '2022-07-21', '20:00:00', 0, 0, NULL),
('తింగరోడు', '2022-07-11', '20:00:00', 0, 0, NULL),
('దమ్ముబిర్యాని', '2022-07-24', '20:00:00', 9, 8, NULL),
('దొండకాయ', '2022-07-05', '20:00:00', 0, 0, NULL),
('నాడీకేంద్రం', '2022-07-20', '20:00:00', 0, 0, NULL),
('పాడుగోల', '2022-07-23', '20:00:00', 0, 0, NULL),
('పుల్లయ్య', '2022-07-13', '20:00:00', 0, 0, NULL),
('పూతరేకులు', '2022-07-30', '20:00:00', 0, 0, NULL),
('పైత్యకారి', '2022-07-29', '20:00:00', 0, 0, NULL),
('బెల్లంగవ్వలు', '2022-07-27', '20:00:00', 0, 0, NULL),
('మద్రాసు', '2022-07-28', '20:00:00', 0, 0, NULL),
('మిరపకాయ', '2022-07-06', '20:00:00', 0, 0, NULL),
('మునగ', '2022-07-19', '20:00:00', 0, 0, NULL),
('మురుకు', '2022-07-22', '20:00:00', 0, 0, NULL),
('మొండిసంత', '2022-07-26', '20:00:00', 0, 0, NULL),
('వాణిశ్రీ', '2022-07-25', '20:00:00', 0, 0, NULL),
('వార్తలు', '2022-07-31', '20:00:00', 0, 0, NULL),
('విశాఖపట్నం', '2022-07-09', '20:00:00', 0, 0, NULL),
('సుప్పనాతి', '2022-07-14', '20:00:00', 0, 0, NULL),
('హైదరాబాద్', '2022-07-12', '20:00:00', 0, 0, NULL),
('hip', '2022-08-03', '08:00:00', 0, 0, 'Name a body part'),
('fan', '2022-08-06', '08:00:00', 0, 0, 'Sports enthusiast'),
('ego', '2022-08-09', '08:00:00', 0, 0, 'Bruises easily'),
('can', '2022-08-12', '08:00:00', 0, 0, 'Name a small liquid container'),
('egg', '2022-08-15', '08:00:00', 0, 0, 'Name a food item which may or may not have come first'),
('vat', '2022-08-18', '08:00:00', 0, 0, 'Name a large liquid container'),
('rub', '2022-08-21', '08:00:00', 0, 0, NULL),
('lip', '2022-08-24', '08:00:00', 0, 0, 'Name a body part'),
('owe', '2022-08-27', '08:00:00', 0, 0, NULL),
('pig', '2022-08-30', '08:00:00', 0, 0, 'Name a farm animal'),
('fun', '2022-09-02', '08:00:00', 0, 0, NULL),
('few', '2022-09-05', '08:00:00', 0, 0, 'As opposed to having many...'),
('old', '2022-09-08', '08:00:00', 0, 0, 'More experienced'),
('fur', '2022-09-11', '08:00:00', 0, 0, 'Mammals often have this'),
('bus', '2022-09-14', '08:00:00', 0, 0, 'Name a type of vehicle'),
('lie', '2022-09-17', '08:00:00', 0, 0, NULL),
('bat', '2022-09-20', '08:00:00', 0, 0, 'Name a small winged animal'),
('pie', '2022-09-23', '08:00:00', 0, 0, 'The most mathematical of all food items'),
('see', '2022-09-26', '08:00:00', 0, 0, NULL),
('pin', '2022-09-29', '08:00:00', 0, 0, 'Name a sewing implement'),
('able', '2022-08-04', '08:00:00', 0, 0, NULL),
('solo', '2022-08-07', '08:00:00', 0, 0, 'Preference of introverts'),
('safe', '2022-08-10', '08:00:00', 0, 0, 'secure storage'),
('duty', '2022-08-13', '08:00:00', 0, 0, NULL),
('item', '2022-08-16', '08:00:00', 0, 0, NULL),
('park', '2022-08-19', '08:00:00', 0, 0, 'An outdoor gathering place'),
('wild', '2022-08-22', '08:00:00', 0, 0, 'An uncontrolled being or place'),
('clue', '2022-08-25', '08:00:00', 0, 0, 'Sherlock loved these'),
('dump', '2022-08-28', '08:00:00', 0, 0, 'Repository of unwanted items'),
('debt', '2022-08-31', '08:00:00', 0, 0, NULL),
('drag', '2022-09-03', '08:00:00', 0, 0, NULL),
('coma', '2022-09-06', '08:00:00', 0, 0, 'Name a medical condition'),
('fire', '2022-09-09', '08:00:00', 0, 0, 'Avoid this in a forest'),
('goal', '2022-09-12', '08:00:00', 0, 0, 'Name something to be attained'),
('lack', '2022-09-15', '08:00:00', 0, 0, NULL),
('area', '2022-09-18', '08:00:00', 0, 0, 'Squares and circles both have this'),
('vein', '2022-09-21', '08:00:00', 0, 0, 'A path that leads to the heart'),
('jump', '2022-09-24', '08:00:00', 0, 0, NULL),
('spit', '2022-09-27', '08:00:00', 0, 0, NULL),
('tell', '2022-09-30', '08:00:00', 0, 0, NULL),
('leash', '2022-08-05', '08:00:00', 0, 0, 'Dogs never leave home without it'),
('claim', '2022-08-08', '08:00:00', 0, 0, NULL),
('green', '2022-08-11', '08:00:00', 0, 0, 'The shade of envy'),
('exile', '2022-08-14', '08:00:00', 0, 0, 'An outcast'),
('guilt', '2022-08-17', '08:00:00', 0, 0, 'This could be determined by a group of your peers'),
('fairy', '2022-08-20', '08:00:00', 0, 0, 'Name a fantasy creature'),
('check', '2022-08-23', '08:00:00', 0, 0, NULL),
('jewel', '2022-08-26', '08:00:00', 0, 0, 'A precious object. Or a folk singer from Alaska'),
('watch', '2022-08-29', '08:00:00', 0, 0, NULL),
('water', '2022-09-01', '08:00:00', 0, 0, 'Earth has a lot of this'),
('slump', '2022-09-04', '08:00:00', 0, 0, 'When you just cannot win'),
('coast', '2022-09-07', '08:00:00', 0, 0, 'A geographical feature'),
('choke', '2022-09-10', '08:00:00', 0, 0, 'Athletes can do this, but so can restaurant patrons'),
('other', '2022-09-13', '08:00:00', 0, 0, NULL),
('groan', '2022-09-16', '08:00:00', 0, 0, 'An utterance from the mouth'),
('robot', '2022-09-19', '08:00:00', 0, 0, NULL),
('chord', '2022-09-22', '08:00:00', 0, 0, 'Name a musical term'),
('smile', '2022-09-25', '08:00:00', 0, 0, 'They say it takes less muscles to do this'),
('chase', '2022-09-27', '08:00:00', 0, 0, 'Movies love a good one. Police officers?  Not so much.'),
('feast', '2022-10-01', '08:00:00', 0, 0, 'Abundance of food'),
('అడవి', '2022-08-03', '20:00:00', 0, 0, NULL),
('ఆకలి', '2022-08-06', '20:00:00', 0, 0, NULL),
('పర్వతం', '2022-08-09', '20:00:00', 0, 0, NULL),
('సహనం', '2022-08-12', '20:00:00', 0, 0, NULL),
('ఓపిక', '2022-08-15', '20:00:00', 0, 0, NULL),
('ఖరీదు', '2022-08-18', '20:00:00', 0, 0, NULL),
('చదువు', '2022-08-21', '20:00:00', 0, 0, NULL),
('తలుపు', '2022-08-24', '20:00:00', 0, 0, NULL),
('సగము', '2022-08-27', '20:00:00', 0, 0, NULL),
('సాయంత్రం', '2022-08-30', '20:00:00', 0, 0, NULL),
('పోలిక', '2022-09-02', '20:00:00', 0, 0, NULL),
('బరువు', '2022-09-05', '20:00:00', 0, 0, NULL),
('ఏర్పాట్లు', '2022-09-08', '20:00:00', 0, 0, NULL),
('మధ్యస్థ', '2022-09-11', '20:00:00', 0, 0, NULL),
('అద్భుత', '2022-09-14', '20:00:00', 9, 8, NULL),
('ఉపాయం', '2022-09-17', '20:00:00', 0, 0, NULL),
('ముసుగు', '2022-09-20', '20:00:00', 0, 0, NULL),
('కాలుష్యం', '2022-09-23', '20:00:00', 0, 0, NULL),
('బటన్', '2022-09-26', '20:00:00', 0, 0, NULL),
('నగరం', '2022-09-29', '20:00:00', 0, 0, NULL),
('ఉదయము', '2022-08-04', '20:00:00', 0, 0, NULL),
('ఎగతాళి', '2022-08-07', '20:00:00', 0, 0, NULL),
('నిముషము', '2022-08-10', '20:00:00', 0, 0, NULL),
('సోమవారం', '2022-08-13', '20:00:00', 0, 0, NULL),
('భయంకరం', '2022-08-16', '20:00:00', 0, 0, NULL),
('దృఢమైన', '2022-08-19', '20:00:00', 0, 0, NULL),
('విచారణ', '2022-08-22', '20:00:00', 0, 0, NULL),
('గజిబిజి', '2022-08-25', '20:00:00', 0, 0, NULL),
('వ్యవహారం', '2022-08-28', '20:00:00', 0, 0, NULL),
('పరిణామం', '2022-08-31', '20:00:00', 0, 0, NULL),
('రచయిత', '2022-09-03', '20:00:00', 0, 0, NULL),
('థియేటర్', '2022-09-06', '20:00:00', 0, 0, NULL),
('సోదరుడు', '2022-09-09', '20:00:00', 0, 0, NULL),
('స్నేహితుడు', '2022-09-12', '20:00:00', 0, 0, NULL),
('సొరచేప', '2022-09-15', '20:00:00', 9, 8, NULL),
('అర్ధరాత్రి', '2022-09-18', '20:00:00', 0, 0, NULL),
('కంప్యూటర్', '2022-09-21', '20:00:00', 0, 0, NULL),
('పాఠశాల', '2022-09-24', '20:00:00', 0, 0, NULL),
('ప్రొఫెసర్', '2022-09-27', '20:00:00', 0, 0, NULL),
('కార్యదర్శి', '2022-09-30', '20:00:00', 0, 0, NULL),
('ఆదివారము', '2022-08-05', '20:00:00', 0, 0, NULL),
('కృతజ్ఞతతో', '2022-08-08', '20:00:00', 0, 0, NULL),
('క్రమశిక్షణ', '2022-08-11', '20:00:00', 0, 0, NULL),
('కిలోమీటరు', '2022-08-14', '20:00:00', 0, 0, NULL),
('బంగాళదుంప', '2022-08-17', '20:00:00', 0, 0, NULL),
('నిర్వాహకుడు', '2022-08-20', '20:00:00', 0, 0, NULL),
('ప్రయాణీకుడు', '2022-08-23', '20:00:00', 0, 0, NULL),
('వార్తాపత్రిక', '2022-08-26', '20:00:00', 0, 0, NULL),
('అతిథి', '2022-08-29', '20:00:00', 0, 0, NULL),
('హోటల్', '2022-09-01', '20:00:00', 0, 0, NULL),
('డీలర్', '2022-09-04', '20:00:00', 0, 0, NULL),
('గురువు', '2022-09-07', '20:00:00', 0, 0, NULL),
('సముద్ర', '2022-09-10', '20:00:00', 0, 0, NULL),
('కస్టమర్', '2022-09-13', '20:00:00', 0, 0, NULL),
('పైలట్', '2022-09-16', '20:00:00', 9, 8, NULL),
('పుస్తకం', '2022-09-19', '20:00:00', 0, 0, NULL),
('మనిషి', '2022-09-22', '20:00:00', 0, 0, NULL),
('చంద్రుడు', '2022-09-25', '20:00:00', 0, 0, NULL),
('సైకిల్', '2022-09-28', '20:00:00', 0, 0, NULL),
('వైద్యుడు', '2022-10-01', '20:00:00', 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `custom_words`
--
ALTER TABLE `custom_words`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`preference_id`);

--
-- Indexes for table `puzzle_words`
--
ALTER TABLE `puzzle_words`
  ADD PRIMARY KEY (`word`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_words`
--
ALTER TABLE `custom_words`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
