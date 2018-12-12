-- Adminer 4.6.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `challenge`;
CREATE TABLE `challenge` (
  `challengeID` int(11) NOT NULL AUTO_INCREMENT,
  `userIDSend` int(15) NOT NULL,
  `userIDRec` int(15) NOT NULL,
  `acceptedYN` tinyint(4) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`challengeID`),
  KEY `userIDSend` (`userIDSend`),
  KEY `userIDRec` (`userIDRec`),
  CONSTRAINT `challenge_ibfk_1` FOREIGN KEY (`userIDSend`) REFERENCES `user` (`userID`),
  CONSTRAINT `challenge_ibfk_2` FOREIGN KEY (`userIDRec`) REFERENCES `user` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `messageID` int(15) NOT NULL AUTO_INCREMENT,
  `userID` int(15) NOT NULL,
  `roomID` int(15) NOT NULL,
  `messageText` varchar(140) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`messageID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `gameDeckCards`;
CREATE TABLE `gameDeckCards` (
  `lobbyID` int(11) NOT NULL,
  `cardName` varchar(20) NOT NULL,
  KEY `lobbyID` (`lobbyID`),
  CONSTRAINT `gameDeckCards_ibfk_3` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`) ON DELETE CASCADE,
  CONSTRAINT `gameDeckCards_ibfk_2` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `gameLobby`;
CREATE TABLE `gameLobby` (
  `lobbyID` int(11) NOT NULL AUTO_INCREMENT,
  `playerOneID` int(11) NOT NULL,
  `playerTwoID` int(11) NOT NULL,
  PRIMARY KEY (`lobbyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `gameTopCard`;
CREATE TABLE `gameTopCard` (
  `lobbyID` int(11) NOT NULL,
  `topCardName` varchar(20) NOT NULL,
  KEY `lobbyID` (`lobbyID`),
  CONSTRAINT `gameTopCard_ibfk_2` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`) ON DELETE CASCADE,
  CONSTRAINT `gameTopCard_ibfk_1` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(15) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(60) NOT NULL,
  `gamesWon` int(10) NOT NULL,
  `onlineYN` tinyint(2) NOT NULL,
  `inGameYN` tinyint(2) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `userGameState`;
CREATE TABLE `userGameState` (
  `lobbyID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `card1` varchar(20) NOT NULL,
  `card2` varchar(20) NOT NULL,
  `card3` varchar(20) NOT NULL,
  `pickedUpCard` varchar(20) DEFAULT 'NULL',
  `turnYN` tinyint(2) NOT NULL,
  `knockYN` tinyint(2) NOT NULL DEFAULT '0',
  KEY `lobbyID` (`lobbyID`),
  CONSTRAINT `userGameState_ibfk_5` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`) ON DELETE CASCADE,
  CONSTRAINT `userGameState_ibfk_1` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`),
  CONSTRAINT `userGameState_ibfk_2` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`),
  CONSTRAINT `userGameState_ibfk_3` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`) ON DELETE CASCADE,
  CONSTRAINT `userGameState_ibfk_4` FOREIGN KEY (`lobbyID`) REFERENCES `gameLobby` (`lobbyID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2018-12-12 02:56:17
