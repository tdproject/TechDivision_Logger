-- phpMyAdmin SQL Dump
-- version 3.2.2-rc1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2009 at 09:40 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Create the database `resources`
--

CREATE DATABASE `logger`;
USE `logger`;

--
-- Database: `logger`
--

-- --------------------------------------------------------

--
-- Table structure for table `logger`
--

CREATE TABLE `logger` (
	`logger_id` INT NOT NULL AUTO_INCREMENT ,
	`val` TEXT NOT NULL ,
	PRIMARY KEY ( `logger_id` )
) ENGINE = InnoDB;