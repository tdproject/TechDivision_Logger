<?php

/**
 * License: GNU General Public License
 *
 * Copyright (c) 2009 TechDivision GmbH.  All rights reserved.
 * Note: Original work copyright to respective authors
 *
 * This file is part of TechDivision GmbH - Connect.
 *
 * faett.net is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * faett.net is distributed in the hope that it will be useful,
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
require_once 'TechDivision/Logger/FirePHP/MockWrapper.php';

/**
 * This is the test for the system logger.
 *
 * @package TechDivision_Logger
 * @author Markus Berwanger <m.berwanger@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Logger_FirePHPTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Holds the Logger instance to test.
	 * @var TechDivision_Logger_System
	 */
	private $logger = null;

	/**
	 * Holds array to save returned logging-messages.
	 * @var String[]
	 */
	private $loggedMessages;

	/**
	 *
	 * Holds array to save the reference-messages
	 * @var String[]
	 */
	private $referenceMessages;


	/**
	 * This method initializes the Locale with
	 * a value to start the tests with.
	 *
	 * @return void
	 */
	function setUp()
	{
		// initialize the Logger instance
		$this->logger = TechDivision_Logger_Logger::forObject($this, 'TechDivision/Logger/firephp.properties');
		$this->logger->setInstance(new TechDivision_Logger_FirePHP_MockWrapper());
	}

	/**
	 * This method deletes the Locale and
	 * frees the memory.
	 *
	 * @return void
	 */
	function tearDown() {
		//Nothing to do here


	}

	/**
	 * Logs an emergency-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logEmergency()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_EMERG;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->emergency($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}

	/**
	 * Logs an alert-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logAlert()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_ALERT;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->alert($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}

	/**
	 * Logs a critical-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logCritical()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_CRIT;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->critical($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}

	/**
	 * Logs an error-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logError()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_ERR;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->error($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}

	/**
	 * Logs a warning-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logWarning()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_WARNING;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->warning($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}

	/**
	 * Logs a notice-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logNotice()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_NOTICE;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->notice($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}

	/**
	 * Logs an info-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logInfo()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_INFO;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->info($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;


	}

	/**
	 * Logs a debug-message to the FirePHP-logger instance.
	 *
	 * @return void
	 */
	function logDebug()
	{
		// initialize the message to log
		$message = "Test entry";
		//initialize the log's level
		$level = TechDivision_Logger_Logger::LOG_DEBUG;
		// initialize the log time
		$line = __LINE__;
		//inialize the time
		$time = time();

		// log a message to the FirePHP-logger
		$this->logger->debug($message, $line);

		//initialize  and store reference-data
		$referenceMessage = $this->logger->message($message, $level, $line, $time);
		$this->referenceMessages[] = $referenceMessage;

	}


	/**
	 * Calls each log...-function.
	 *
	 * @return void
	 */
	private function callAllLoggings(){
		$this->logEmergency();
		$this->logAlert();
		$this->logCritical();
		$this->logError();
		$this->logWarning();
		$this->logNotice();
		$this->logInfo();
		$this->logDebug();
	}

	/**
	 * Sets the initial log-level to debug and calls all logging-messages to test each of them
	 * by checking the returned loggingMessages against the collected reference values.
	 *
	 * @return void
	 */
	function testLoggings(){
		//set the initial logging-level to debug (the highest possible level)
		$this->logger->setLogLevel(TechDivision_Logger_Logger::LOG_DEBUG);

		$this->callAllLoggings();

		//get logged messages
		$this->loggedMessages = $this->logger->getInstance()->getMessages();

		$this->assertEquals( $this->referenceMessages, $this->loggedMessages );
	}

	/**
	 * Tests the firePHP-logger with all possible logging-levels
	 * @return void
	 */
	function testLoggingLevels(){
		$logLevels = array(
		TechDivision_Logger_Logger::LOG_INFO,
		TechDivision_Logger_Logger::LOG_NOTICE,
		TechDivision_Logger_Logger::LOG_WARNING,
		TechDivision_Logger_Logger::LOG_ERR,
		TechDivision_Logger_Logger::LOG_CRIT,
		TechDivision_Logger_Logger::LOG_ALERT,
		TechDivision_Logger_Logger::LOG_EMERG
		);
		

		foreach ($logLevels as $logLevel) {
			//reset reference- and logged messages
			$this->referenceMessages = array();
			$this->loggedMessages = array();
			
			//reset the logger, otherwise old logging-entries are still present there
			$this->logger->getInstance()->reset();
				
			//initialize logger with the given log-level
			$this->logger->setLogLevel($logLevel);
				
			$this->callAllLoggings();
	
			//get logged messages
			$this->loggedMessages = $this->logger->getInstance()->getMessages();

			//asserts that the correct logging-message for each log-level was stored
			for ($i=0; $i < $logLevel; $i++ ){
				$this->assertEquals( $this->referenceMessages[$i], $this->loggedMessages[$i] );
			}
				
			//asserts that only the required logging-entries are contained
			$this->assertEquals ($logLevel+1, count($this->loggedMessages));

		}

	}
}