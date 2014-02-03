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

require_once "TechDivision/Logger/Logger.php";
require_once "TechDivision/Logger/Interfaces/Logger.php";
require_once 'TechDivision/Logger/Exceptions/InvalidLogLevelException.php';
require_once "TechDivision/Properties/Properties.php";

/**
 * This class is a logger implementation for
 * PHP.
 *
 * @package TechDivision_Logger
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
abstract class TechDivision_Logger_Abstract
    implements TechDivision_Logger_Interfaces_Logger {

	/**
	 * Holds the constant for the log level property value.
	 * @var string
	 */
	const LOG_LEVEL = 'log_level';

	/**
	 * Holds the classname of the class to log for.
	 * @var string
	 */
	protected $_classname = null;

	/**
	 * Holds the log level
	 * @var integer
	 */
	protected $_logLevel = null;

	/**
	 * Holds the properties from the configuration file
	 * @var TechDivision_Properties_Properties
	 */
	protected $_properties = null;

	/**
	 * Holds an array with possible log levels.
	 * @var array
	 */
	public static $levels = array(
	    TechDivision_Logger_Logger::LOG_EMERG => "emergency",
 	    TechDivision_Logger_Logger::LOG_ALERT => "alert",
  	    TechDivision_Logger_Logger::LOG_CRIT => "critical",
	    TechDivision_Logger_Logger::LOG_ERR => "error",
	    TechDivision_Logger_Logger::LOG_WARNING => "warning",
	    TechDivision_Logger_Logger::LOG_NOTICE => "notice",
	    TechDivision_Logger_Logger::LOG_INFO => "info",
	    TechDivision_Logger_Logger::LOG_DEBUG => "debug"
	);

	/**
	 * The constructor initialize the logger instance with the
	 * classname and the Properties from the configuraion file.
	 *
	 * @param string $classname Holds the classname for log message
	 * @param TechDivision_Properties_Properties $properties
	 * 		Holds the properties to use
	 * @return void
	 */
	public function __construct(
	    $classname,
	    TechDivision_Properties_Properties $properties) {
		// set the classname
		$this->setClassname($classname);
		// set the properties
		$this->setProperties($properties);
		// set the internal log level
		$this->setLogLevel(
		    (integer) $this->getPropertyValue(
    		    TechDivision_Logger_Abstract::LOG_LEVEL
    		)
		);
	}

	/**
	 * Logs an error message to the log target..
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the error occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function error($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_ERR,
		    $line,
		    $method
		);
	}

	/**
	 * Logs an emergeny message to the log target.
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the emergency message occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function emergency($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_EMERG,
		    $line,
		    $method
		);
	}

	/**
	 * Logs an alert message to the log target.
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the alert message occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function alert($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_ALERT,
		    $line,
		    $method
		);
	}

	/**
	 * Logs a critical error message to the log target..
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the critical message occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function critical($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_CRIT,
		    $line,
		    $method
		);
	}

	/**
	 * Logs a warning to the log target.
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the warning occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function warning($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_WARNING,
		    $line,
		    $method
		);
	}

	/**
	 * Logs a notice to the log target.
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the notic occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function notice($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_NOTICE,
		    $line,
		    $method
		);
	}

	/**
	 * Logs an info message to the log target.
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the info message occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function info($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_INFO,
		    $line,
		    $method
		);
	}

	/**
	 * Logs a debug message to the log target.
	 *
	 * @param $message Holds the message to log
	 * @param $line Holds the line where the debug message occurs
	 * @param $method The origin method
	 * @return integer Timestamp with the log date as UNIX timestamp
	 * @see TechDivision_Logger_Interfaces_Logger::log($message, $level)
	 */
	public final function debug($message, $line = null, $method = null)
	{
		return $this->log(
		    $message,
		    TechDivision_Logger_Logger::LOG_DEBUG,
		    $line,
		    $method
		);
	}

	/**
	 * This method builds the log message based on the passed
	 * parameters and returns it as string.
	 *
	 * @param string $message Holds the message
	 * @param integer $level Holds the actual log level
	 * @param integer $line Holds the line where the message was send from
	 * @param integer $method The origin method
	 * @param integer $time Holds the time when the message was created
	 * @return string Holds the generated log message
	 */
	public final function message(
	    $message,
	    $level,
	    $line = null,
	    $method = null,
	    $time = null) {
		// initialize the time
		if (empty($time)) {
			$time = time();
		}
		// build and return the log message
		$stream = "";
        // add the classname/method to the log message
		if (empty($method)) {
		    $stream .= $this->getClassname();
		} else {
		    $stream .= $method;
		}
        // add the log level to the log message
		$stream .= "[" . TechDivision_Logger_Abstract::$levels[$level] . "] " .
		    date("Y-m-d H:i:s", $time) . " ";
        // add the line to the log message
		if (!empty($line)) {
			$stream .= "- line " . $line . " ";
		}
		$stream .= $message;
		return $stream;
	}

	/**
	 * This method returns the property value
	 * for the property with the passed name.
	 *
	 * @param string $name Holds the name of the property value to return
	 * @return string Holds the requested property value
	 */
	public final function getPropertyValue($name)
	{
		return $this->getProperties()->getProperty($name);
	}

	/**
	 * Sets the classname.
	 *
	 * @param string $classname
	 * 		The classname to use
	 * @return TechDivision_Logger_Interfaces_Logger
	 * 		The logger instance itself
	 */
	public function setClassname($classname)
	{
	    $this->_classname = $classname;
	    return $this;
	}

	/**
	 * Returns the classname.
	 *
	 * @return string The classname to log
	 */
	public function getClassname()
	{
	    return $this->_classname;
	}

	/**
	 * Sets the passed properties with the Logger configuration.
	 *
	 * @param TechDivision_Properties_Properties $properties
	 * 		The properties to set
	 * @return TechDivision_Logger_Interfaces_Logger
	 * 		The logger instance itself
	 */
	public function setProperties(
	    TechDivision_Properties_Properties $properties) {
	    $this->_properties = $properties;
	    return $this;
	}

	/**
	 * Returns the properties with the Logger configuration.
	 *
	 * @return TechDivision_Properties_Properties
	 * 		The Logger configuration
	 */
	public function getProperties()
	{
	    return $this->_properties;
	}

	/**
	 * Checks if the passed log level is valid
	 * and sets it.
	 *
	 * @param integer $logLevel The log level to set
	 * @return TechDivision_Logger_Interfaces_Logger
	 * 		The logger instance itself
	 * @throws TechDivision_Logger_Exceptions_InvalidLogLevelException
	 * 		Is thrown if an invalid log level was passed
	 */
	public function setLogLevel($logLevel)
	{
	    // check if a valid log level was passed
	    if (!array_key_exists($logLevel, self::$levels)) {
	        throw new TechDivision_Logger_Exceptions_InvalidLogLevelException(
	        	"Found invalid log level $logLevel"
	        );
	    }
	    // set the log level and return the instance
	    $this->_logLevel = $logLevel;
	    return $this;
	}

	/**
	 * Returns the actual log level.
	 *
	 * @return integer The actual log level
	 */
	public function getLogLevel()
	{
	    return  $this->_logLevel;
	}
}