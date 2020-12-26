CREATE TABLE `apiaccess` (
  `userID` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `status` (
  `statusID` int(11) NOT NULL,
  `statusName` varchar(255) NOT NULL,
  `statusAccess` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `status` (`statusID`, `statusName`, `statusAccess`) VALUES
(1, 'Basic', '{\r\n  "apiAccess": "1"\r\n}'),
(2, 'Admin', '{\r\n  "apiAccess": "999"\r\n}');


CREATE TABLE `urls` (
  `urlID` varchar(10) NOT NULL,
  `userID` int(11) NOT NULL,
  `urlPointing` text NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `statusID` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `status`
  ADD PRIMARY KEY (`statusID`);


ALTER TABLE `urls`
  ADD UNIQUE KEY `urlID` (`urlID`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);


ALTER TABLE `status`
  MODIFY `statusID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
