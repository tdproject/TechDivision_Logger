<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2009 TechDivision GmbH.  All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This file is part of TechDivision GmbH - Connect.
 *
 * TechDivision_Logger is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * TechDivision_Logger is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 * USA.
 *
 * @package TechDivision_Logger
 */

require_once 'TechDivision/Logger/Logger.php';
require_once 'TechDivision/Logger/Abstract.php';
require_once 'TechDivision/Logger/Exceptions/LoggerException.php';
require_once 'TechDivision/Properties/Properties.php';

/**
 * This class is a logger implementation for PHP and sends all log
 * messages as mail to the receipient defined in the log4php.properties
 * configuration file.
 *
 * @package TechDivision_Logger
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Logger_Mail extends TechDivision_Logger_Abstract
{

	/**
	 * Holds the constant for the property value that holds the
	 * email address to send the log message to.
	 * @var string
	 */
	const LOG_MAIL_TO = "log_mail_to";

	/**
	 * Holds the constant for the property value that holds the
	 * email address with the message sender.
	 * @var string
	 */
	const LOG_MAIL_FROM = "log_mail_from";

	/**
	 * Holds the mail address to send messages to
	 * @var string
	 */
	private $_logMailTo = null;

	/**
	 * Holds the mail address with the sender mail address
	 * @var string
	 */
	private $_logMailFrom = null;

	/**
	 * The constructor initialize the logger instance with the
	 * classname and the properties from the configuraion file.
	 *
	 * @param string $classname Holds the classname for log message
	 * @param TechDivision_Properties_Properties $properties
	 * 		Holds the properties to use
	 * @return void
	 */
	public function __construct(
	    $classname,
	    TechDivision_Properties_Properties $properties) {
		// initialize the superclass
		TechDivision_Logger_Abstract::__construct($classname, $properties);
		// get the receipient and and the sender mails from
		// the configuration file
		$this->_logMailTo = $this->getPropertyValue(
		    TechDivision_Logger_Mail::LOG_MAIL_TO
		);
		$this->_logMailFrom = $this->getPropertyValue(
		    TechDivision_Logger_Mail::LOG_MAIL_FROM
		);
	}

	/**
	 * This method logs the passed message with the
	 * also passed log level to the logging target.
	 *
	 * @param string $message Holds the message to log
	 * @param integer $level Holds the log level that should be used
	 * @param integer $line Holds the line where the message was logged
	 * @param string $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @throws TechDivision_Logger_Exceptions_LoggerException
	 * 		Is thrown if the log message can not be sent as mail
	 */
	public function log($message, $level = 3, $line = null, $method = null) {
		// if the passed log level is equal or smaller
		if ($level <= $this->getLogLevel()) {
			// initialize the log time
			$time = time();
			// build the header for the mail
			$header =
				"Subject: New Log-Message from " . $_SERVER["SERVER_ADDR"] .
				" with state " . TechDivision_Logger_Abstract::$levels[$level] .
				PHP_EOL . "From: " . $this->_logMailFrom . PHP_EOL;
			// log the message passed as parameter
			$result = error_log(
			    $this->message($message, $level, $line, $method, $time),
			    MailLogger::LOG_TYPE_MAIL,
			    $this->_logMailTo,
			    $header
			);
			// check if the log message was successfully written
			if ($written === false) {
				throw new TechDivision_Logger_Exceptions_LoggerException(
					'Error while sending log message as mail'
				);
			}
			// return the timestamp when the message was logged
			return $time;
		}
	}
}