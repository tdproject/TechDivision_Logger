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

require_once "TechDivision/Properties/Properties.php";
require_once "TechDivision/Logger/Interfaces/Logger.php";
require_once "TechDivision/Logger/System.php";
require_once "TechDivision/Logger/Exceptions/InvalidLogTypeException.php";

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
class TechDivision_Logger_Logger {

	/**
	 * System is unusable.
	 * @var integer
	 */
	const LOG_EMERG = 0;

	/**
	 * Immediate action required.
	 * @var integer
	 */
	const LOG_ALERT = 1;

	/**
	 * Critical conditions.
	 * @var integer
	 */
	const LOG_CRIT = 2;

	/**
	 * Error conditions.
	 * @var integer
	 */
	const LOG_ERR = 3;

	/**
	 * Warning conditions.
	 * @var integer
	 */
	const LOG_WARNING = 4;

	/**
	 * Normal but significant.
	 * @var integer
	 */
	const LOG_NOTICE = 5;

	/**
	 * Informational.
	 * @var integer
	 */
	const LOG_INFO = 6;

	/**
	 * Debug-level messages.
	 * @var integer
	 */
	const LOG_DEBUG = 7;

	/**
	 * The log type to use.
	 * @var string
	 */
	const LOG_TYPE = 'log_type';

	 /**
	  * Holds the logger instance if singleton is requested
	  * @var Logger
	  */
	public static $instance = null;

	/**
	 * Private constructor to make this class static class.
	 *
	 * @return void
	 */
	private function __construct()
	{
		// Marks this class as util
	}

	/**
	 * Returns the logger instance as singleton.
	 *
	 * @param string $classname Holds the class for logging purposes
	 * @param string $confFile Holds the path to the configuration file
	 * @return TechDivision_Logger_Interfaces_Logger The instance
	 */
	public static function forClass($classname, $confFile = '')
	{
		// return a new instance
		return TechDivision_Logger_Logger::_create(
		    $classname,
		    TechDivision_Logger_Logger::_initializeProperties($confFile)
		);
	}
	/**
	 * Returns a new logger for the passed object.
	 *
	 * @param string $classname Holds the class for logging purposes
	 * @param string $confFile Holds the path to the configuration file
	 * @return TechDivision_Logger_Interfaces_Logger The instance
	 */
	public static function forObject($object, $confFile = '')
	{
		// get the classname
		$obj = new ReflectionObject($object);
		// return a new logger instance
		return TechDivision_Logger_Logger::forClass(
		    $obj->getName(),
		    $confFile
		);
	}

	/**
	 * This method initializes the passed property file or
	 * initializes a new one with default values.
	 *
	 * @param string $confFile Holds the path to the configuration file
	 * @return TechDivision_Properties_Properties The initialized properties
	 */
	protected static function _initializeProperties($confFile)
	{
        // initialize a new properties instance
        $properties = TechDivision_Properties_Properties::create();
        // check if a configuration file was passed
	    if (!empty($confFile)) {
    		// if yes, load the properties from the configuration file
    		return $properties->load(
    		    $confFile
    		);
	    }
	    // if not, define new default properties
        $properties->setProperty(
            TechDivision_Logger_Logger::LOG_TYPE,
            TechDivision_Logger_System::LOG_TYPE_SYSTEM
        );
        $properties->setProperty(
            TechDivision_Logger_Abstract::LOG_LEVEL,
            TechDivision_Logger_Logger::LOG_ERR
        );
        // return the default properties
        return $properties;
	}

	/**
	 * This method returns the logger depending on the type
	 * specified in the configuration file.
	 *
	 * @param string $classname Holds the classname for the log message
	 * @param TechDivision_Properties_Properties $properties
	 * 		Holds the properties for initialization purposes
	 * @return TechDivision_Logger_Interfaces_Logger The instance
	 * @throws TechDivision_Logger_Exceptions_InvalidLogTypeException
	 * 		Is thrown if an invalid log type is requested
	 */
	protected static function _create(
	    $classname,
	    TechDivision_Properties_Properties $properties) {
		// get the type of the logger to return
		$type = (integer) $properties->getProperty(
		    TechDivision_Logger_Logger::LOG_TYPE
		);
		// initialize the logger
		$logger = null;
		// get an instance of the requested type
		switch ($type) {
			case TechDivision_Logger_Interfaces_Logger::LOG_TYPE_SYSTEM:
				$logger = new TechDivision_Logger_System(
				    $classname,
				    $properties
				);
				break;
			case TechDivision_Logger_Interfaces_Logger::LOG_TYPE_MAIL:
                require_once "TechDivision/Logger/Mail.php";
				$logger = new TechDivision_Logger_Mail(
				    $classname,
				    $properties
				);
				break;
			case TechDivision_Logger_Interfaces_Logger::LOG_TYPE_CUSTOM_FILE:
                require_once "TechDivision/Logger/CustomFile.php";
				$logger = new TechDivision_Logger_CustomFile(
				    $classname,
				    $properties
				);
				break;
			case TechDivision_Logger_Interfaces_Logger::LOG_TYPE_CONSOLE:
                require_once "TechDivision/Logger/Console.php";
				$logger = new TechDivision_Logger_Console(
				    $classname,
				    $properties
				);
				break;
			case TechDivision_Logger_Interfaces_Logger::LOG_TYPE_DB:
                require_once "TechDivision/Logger/Database.php";
				$logger = new TechDivision_Logger_Database(
				    $classname,
				    $properties
				);
				break;
			case TechDivision_Logger_Interfaces_Logger::LOG_TYPE_FIRE_PHP:
                require_once "TechDivision/Logger/FirePHP.php";
				$logger = new TechDivision_Logger_FirePHP(
				    $classname,
				    $properties
				);
				break;
			default:
				throw new
				    TechDivision_Logger_Exceptions_InvalidLogTypeException(
						'Log type ' . $type .
						' defined in property file is not valid'
			        );
		}
		// return the instance
		return $logger;
	}
}