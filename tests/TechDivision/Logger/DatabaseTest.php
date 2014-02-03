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

require_once 'TechDivision/Util/DataSource.php';
require_once 'TechDivision/Logger/Logger.php';

/**
 * This is the test for the database logger.
 *
 * @package TechDivision_Logger
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Logger_DatabaseTest extends PHPUnit_Framework_TestCase
{

	/**
	 * Holds the database connection
	 * @var MDB2
	 */
	private $_db = null;

	/**
	 * Holds the Logger instance to test.
	 * @var TechDivision_Logger_Database
	 */
	private $_logger = null;

    /**
     * This method initializes the Locale with
     * a value to start the tests with.
     *
     * @return void
     */
	function setUp()
	{
		// initialize the Logger instance
		$this->_logger = TechDivision_Logger_Logger::forObject(
		    $this, "TechDivision/Logger/database.properties"
		);
		// initialize the properties
		$properties = TechDivision_Properties_Properties::create()
		    ->load("TechDivision/Logger/database.properties");
        // initialize the data source
		$cn = TechDivision_Util_DataSource::create($properties);
		// initialize the database connection
		$this->_db = MDB2::factory($cn->getConnectionString());
		if(PEAR::isError($this->_db)) {
			$this->fail($this->_db->getMessage());
		}
	}

    /**
     * This method deletes the Locale and
     * frees the memory.
     *
     * @return void
     */
	function tearDown()
	{
	    // check if a database connection exists
	    if (!empty($this->_db)) {
    		// delete all log entries
    		$this->_db->query('DELETE FROM logger');
    		// disconnect from the database
    		$this->_db->disconnect();
	    }
	}

	/**
	 * This tests the emergency() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogEmergency()
	{
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->emergency($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_EMERG,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the alert() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogAlert() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->alert($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_ALERT,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the critical() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogCritical() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->critical($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_CRIT,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the error() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogError() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->error($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_ERR,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the warning() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogWarning() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->warning($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_WARNING,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the notice() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogNotice() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->notice($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_NOTICE,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the info() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogInfo() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = 'Test entry';
		// log a message to the database
		$time = $this->_logger->info($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_INFO,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}

	/**
	 * This tests the debug() method of the
	 * database logger instance.
	 *
	 * @return void
	 */
	function testLogDebug() {
		// initialize the log time
		$line = __LINE__;
		// initialize the message to log
		$message = "Test entry";
		// log a message to the database
		$time = $this->_logger->debug($message, $line);
		// load the logged message
		$result = $this->_db->query('SELECT val FROM logger');
		if (PEAR::isError($result)) {
			$this->fail($result->getMessage());
		}
		// check the number of found rows
		$this->assertEquals(
		    1,
		    $result->numRows()
		);
		// assert the log message from the database with the one created above
		while ($row = $result->fetchRow(MDB2_FETCHMODE_OBJECT)) {
			$this->assertEquals(
			    $this->_logger->message(
			        $message,
			        TechDivision_Logger_Logger::LOG_DEBUG,
			        $line,
			        $time
			    ),
			    $row->val
			);
		}
	}
}