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

/**
 * This is the test for the system logger.
 *
 * @package TechDivision_Logger
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Logger_SystemTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Holds the Logger instance to test.
	 * @var TechDivision_Logger_System
	 */
	private $logger = null;

    /**
     * This method initializes the Locale with
     * a value to start the tests with.
     *
     * @return void
     */
	function setUp()
	{
		// initialize the Logger instance
		$this->logger = TechDivision_Logger_Logger::forObject($this);
	}

    /**
     * This method deletes the Locale and
     * frees the memory.
     *
     * @return void
     */
	function tearDown() {
		// @TODO Nothing to do here
	}

	/**
	 * This tests the emergency() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogEmergency()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->emergency($message, $line);
	}

	/**
	 * This tests the alert() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogAlert()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->alert($message, $line);
	}

	/**
	 * This tests the critical() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogCritical()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->critical($message, $line);
	}

	/**
	 * This tests the error() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogError()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->error($message, $line);
	}

	/**
	 * This tests the warning() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogWarning()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->warning($message, $line);
	}

	/**
	 * This tests the notice() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogNotice()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->notice($message, $line);
	}

	/**
	 * This tests the info() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogInfo()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->info($message, $line);
	}

	/**
	 * This tests the debug() method of the
	 * DBLogger instance.
	 *
	 * @return void
	 */
	function testLogDebug()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the mail system
		$this->logger->debug($message, $line);
	}
}