CREATE TABLE `rank` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `highest` int(11) DEFAULT NULL,
  `lowest` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL,
  `movement` int(11) NOT NULL,
  `image` varchar(1024) DEFAULT NULL,
  `detail` varchar(1024) DEFAULT NULL
);