-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 02:12 PM
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
-- Database: `online_vs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$SQdGaeGoBEq8SkS9PWSG3uUM9aOvDC1/rHbhVOrGhlRTVFyzEE3bK');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `candidate_name` varchar(255) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `party_logo` varchar(255) NOT NULL,
  `party_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `candidate_name`, `mobile_no`, `dob`, `gender`, `party_logo`, `party_name`) VALUES
(13, 'Suraj', '9878713060', '2005-05-09', 'Male', 'logo2.jpg', 'CSF'),
(14, 'Lakshay', '8456327445', '2004-10-10', 'Male', 'NSUI.png', 'NSUI'),
(15, 'Vikas', '8872506579', '2003-12-01', 'Male', 'logo1.jpg', 'SOI');

-- --------------------------------------------------------

--
-- Table structure for table `citizens`
--

CREATE TABLE `citizens` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `mobile_no` varchar(10) NOT NULL,
  `aadhar_no` varchar(12) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizens`
--

INSERT INTO `citizens` (`id`, `name`, `mobile_no`, `aadhar_no`, `dob`, `gender`, `password`) VALUES
(15, 'Akarsh Malhotra', '7359823554', '626001655154', '1982-06-05', 'Male', '$2y$10$dQxWW5rVxCZM6G2DEsyw8OLRMUQxZtjKoxfHtqaXCNeRhAtBI2WE.'),
(16, 'Ivana Dalal', '2784920632', '529367580125', '1991-01-20', 'Male', '$2y$10$rTyvb8nJNEuHbYgJ/bDYVOEjIC6F78cOJVnNGVeDmbeQJ1Z5.h72K'),
(18, 'Mamooty Mani', '1753820565', '187543412933', '1968-07-12', 'Male', '$2y$10$knTh6NXHFeYPlPOFWVak.ec5YgguCZinb41VDfEYYRBFo/5IoRtVG'),
(19, 'Riaan Shankar', '5084979981', '211613415882', '1959-07-14', 'Other', '$2y$10$d7BpIyM/4fJo6MrrpjKYWuekM/Jvc4KqEzv.nSjwmW2CjjDFFmxX2');

-- --------------------------------------------------------

--
-- Table structure for table `citizen_votes`
--

CREATE TABLE `citizen_votes` (
  `id` int(11) NOT NULL,
  `citizen_id` int(11) NOT NULL,
  `has_voted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `citizen_votes`
--

INSERT INTO `citizen_votes` (`id`, `citizen_id`, `has_voted`) VALUES
(14, 15, 1),
(15, 16, 1),
(16, 18, 1);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `party_logo` varchar(255) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `founded_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `party_logo`, `party_name`, `founded_year`) VALUES
(6, 'uploads/67f3e21587e6a.jpg', 'CSF', '2005'),
(7, 'uploads/67f3e22283832.png', 'NSUI', '2006'),
(8, 'uploads/67f3e32b7ab76.jpg', 'SOI', '2004');

-- --------------------------------------------------------

--
-- Table structure for table `pre_approved_citizens`
--

CREATE TABLE `pre_approved_citizens` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `aadhar_no` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `is_registered` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre_approved_citizens`
--

INSERT INTO `pre_approved_citizens` (`id`, `name`, `mobile_no`, `aadhar_no`, `dob`, `gender`, `is_registered`) VALUES
(1, 'Akarsh Malhotra', '7359823554', '626001655154', '1982-06-05', 'Male', 1),
(2, 'Ivana Dalal', '2784920632', '529367580125', '1991-01-20', 'Female', 1),
(3, 'Mohanlal Subramanian', '8988378740', '558991907825', '1958-11-09', 'Other', 1),
(4, 'Mamooty Mani', '1753820565', '187543412933', '1968-07-12', 'Male', 1),
(5, 'Riaan Shankar', '5084979981', '211613415882', '1959-07-14', 'Other', 1),
(6, 'Ivan Varghese', '3769643669', '444587461671', '1971-03-22', 'Female', 0),
(7, 'Piya Goda', '8865939370', '908834037871', '2005-07-08', 'Other', 0),
(8, 'Raghav Chakrabarti', '7185410954', '959088169261', '2004-12-25', 'Other', 0),
(9, 'Sana Sastry', '6683557078', '803047739586', '2000-11-10', 'Other', 0),
(10, 'Emir Dugar', '1815700732', '723419825033', '1959-03-24', 'Female', 0),
(11, 'Divyansh Ghose', '0055927532', '027151222610', '1970-06-02', 'Male', 0),
(12, 'Riaan Kalla', '5349852437', '160194324140', '2002-10-25', 'Female', 0),
(13, 'Romil Banerjee', '3585206232', '600936031698', '1966-03-15', 'Female', 0),
(14, 'Yashvi Sekhon', '5445605332', '731587982839', '1979-01-04', 'Female', 0),
(15, 'Sahil Dara', '1399302883', '240233407367', '1984-05-12', 'Other', 0),
(16, 'Nirvaan Khatri', '1288575292', '356237234422', '1973-06-27', 'Other', 0),
(17, 'Piya Dutt', '6709171891', '464507693957', '1981-08-10', 'Male', 0),
(18, 'Aarush Malhotra', '8885854667', '366552108813', '1979-04-10', 'Male', 0),
(19, 'Vivaan Dayal', '3281973607', '298983590299', '1947-05-15', 'Male', 0),
(20, 'Stuvan Sinha', '3487060196', '941102348405', '1991-02-08', 'Other', 0),
(21, 'Eva Gopal', '5513743907', '643217449783', '1974-07-05', 'Female', 0),
(22, 'Inaaya  Bhatnagar', '5354419941', '004762854732', '1981-02-12', 'Female', 0),
(23, 'Tanya Barad', '2548550527', '564350717827', '1956-06-13', 'Male', 0),
(24, 'Taimur Agarwal', '7834196682', '764131368085', '1981-06-13', 'Male', 0),
(25, 'Advik Ghose', '0696146593', '164892451009', '1993-01-26', 'Female', 0),
(26, 'Ahana  Badal', '2102771384', '655854362366', '1956-12-01', 'Female', 0),
(27, 'Ivan Sarkar', '1460897028', '104806129111', '2007-03-18', 'Other', 0),
(28, 'Mohanlal Jaggi', '6213795495', '881506174460', '1947-07-14', 'Other', 0),
(29, 'Kismat Kalita', '2092858405', '199060208892', '1998-12-09', 'Other', 0),
(30, 'Rati Seth', '4824967188', '221649535700', '1976-03-11', 'Female', 0),
(31, 'Neelofar Bali', '1307642337', '724209772571', '1977-02-22', 'Male', 0),
(32, 'Lakshit Kara', '9084267447', '249622360826', '1989-08-05', 'Male', 0),
(33, 'Kiara Wagle', '2413870693', '553465401303', '1987-03-08', 'Female', 0),
(34, 'Parinaaz Saran', '0906375017', '123571118047', '1946-04-05', 'Female', 0),
(35, 'Amira Tella', '6612043563', '480736116732', '1989-02-15', 'Male', 0),
(36, 'Rasha Garde', '1941753129', '389010912082', '1957-08-09', 'Other', 0),
(37, 'Aayush Ramakrishnan', '4441040222', '935780090744', '1962-02-27', 'Male', 0),
(38, 'Ishita Kakar', '6583807720', '440328896453', '1970-10-18', 'Male', 0),
(39, 'Hridaan Banerjee', '3325740916', '775721120049', '1993-09-29', 'Other', 0),
(40, 'Shaan Khalsa', '3237157128', '729406415275', '1974-09-27', 'Other', 0),
(41, 'Aradhya Guha', '2321880813', '450765413255', '1999-08-07', 'Male', 0),
(42, 'Vardaniya Iyer', '2249754762', '022747283645', '1963-08-13', 'Other', 0),
(43, 'Sahil Dube', '2507099549', '342968380253', '1995-04-04', 'Other', 0),
(44, 'Anahi Bhatti', '8112207362', '420535033038', '1989-08-13', 'Male', 0),
(45, 'Krish Ramanathan', '7441752670', '640082346864', '1976-11-08', 'Other', 0),
(46, 'Nakul Tella', '0950806132', '022477061277', '1985-03-06', 'Other', 0),
(47, 'Zain Aggarwal', '2956470623', '451251560936', '1978-08-05', 'Male', 0),
(48, 'Mishti Kibe', '1614433171', '191782044928', '1966-07-30', 'Other', 0),
(49, 'Krish Sekhon', '6400092150', '007801248826', '2005-10-06', 'Other', 0),
(50, 'Vidur Goel', '4886519719', '473003599414', '1988-07-12', 'Female', 0),
(51, 'Jivin Majumdar', '6797593808', '535128424495', '1977-08-12', 'Male', 0),
(52, 'Shalv Sahota', '3256222891', '504788740295', '1994-01-27', 'Female', 0),
(53, 'Romil Kakar', '5389587563', '210866007290', '2005-09-02', 'Male', 0),
(54, 'Lakshit Lala', '1888524243', '782462878661', '1977-08-23', 'Female', 0),
(55, 'Shamik Handa', '2613963263', '870304678604', '1995-07-12', 'Male', 0),
(56, 'Zoya Kapoor', '7348338414', '005685703848', '1999-10-13', 'Female', 0),
(57, 'Arnav Balay', '9642523608', '826390877077', '1976-11-20', 'Other', 0),
(58, 'Veer Handa', '4380221696', '987157628609', '1998-03-06', 'Other', 0),
(59, 'Mohanlal Bahl', '6282310344', '768558064695', '1978-02-10', 'Male', 0),
(60, 'Anahi Sundaram', '4354554524', '996710983593', '1988-09-06', 'Male', 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `voting_end_date` date NOT NULL,
  `result_announcement_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `voting_end_date`, `result_announcement_date`) VALUES
(1, '2025-04-08', '2025-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `total_votes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `candidate_id`, `total_votes`) VALUES
(16, 13, 0),
(17, 14, 2),
(18, 15, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile_no` (`mobile_no`);

--
-- Indexes for table `citizens`
--
ALTER TABLE `citizens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile_no` (`mobile_no`),
  ADD UNIQUE KEY `aadhar_no` (`aadhar_no`);

--
-- Indexes for table `citizen_votes`
--
ALTER TABLE `citizen_votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citizen_id` (`citizen_id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_approved_citizens`
--
ALTER TABLE `pre_approved_citizens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `citizens`
--
ALTER TABLE `citizens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `citizen_votes`
--
ALTER TABLE `citizen_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pre_approved_citizens`
--
ALTER TABLE `pre_approved_citizens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citizen_votes`
--
ALTER TABLE `citizen_votes`
  ADD CONSTRAINT `citizen_votes_ibfk_1` FOREIGN KEY (`citizen_id`) REFERENCES `citizens` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
