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

require_once 'MDB2.php';
require_once 'TechDivision/Logger/Logger.php';
require_once 'TechDivision/Logger/Abstract.php';
require_once 'TechDivision/Logger/Exceptions/LoggerException.php';
require_once 'TechDivision/Properties/Properties.php';

/**
 * This class is a logger implementation for PHP and sends all log
 * messages to the database specified in the configuration file.
 *
 * Properties for the database connection are:
 *
 *	 db.connect.driver               = mysqli
 *	 db.connect.user                 = loggerUser
 *	 db.connect.password             = loggerPassword
 * 	 db.connect.database             = logger
 * 	 db.connect.host                 = localhost
 * 	 db.connect.port                 = 3306
 * 	 db.connect.options              =
 * 	 db.sql.table                    = logger
 * 	 db.sql.val.column               = val
 *
 * @package TechDivision_Logger
 * @author Tim Wagner <t.wagner@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Logger_Database extends TechDivision_Logger_Abstract
{

	/**
	 * Holds the name of the database table where the log
	 * messages should be stored.
	 * @var string
	 */
	const DB_SQL_TABLE = 'db.sql.table';

	/**
	 * Holds the name of the column with the value stored.
	 * @var string
	 */
	const DB_SQL_VAL_COLUMN = 'db.sql.val.column';

	/**
	 * Holds the prepared statement for saving the log message in the database.
	 * @var MDB2_Statement_Common
	 */
	private $_statement = null;

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
		// initialize the superclass
		TechDivision_Logger_Abstract::__construct($classname, $properties);
        // initialize the data source
		$cn = TechDivision_Util_DataSource::create($this->getProperties());
		// initialize the database connection
		if (PEAR::isError($db = MDB2::factory($cn->getConnectionString()))) {
			throw new TechDivision_Logger_Exceptions_LoggerException(
			    $db->getMessage()
			);
		}
    	// prepare the statement to attach the resources
    	$this->setStatement(
    	    $db->prepare(
        		"INSERT INTO " . $this->getPropertyValue(
        	        TechDivision_Logger_Database::DB_SQL_TABLE
        	    ) . " (" .  $this->getPropertyValue(
        	        TechDivision_Logger_Database::DB_SQL_VAL_COLUMN
        	    ) . ") VALUES (?)",
        	    array("text")
        	)
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
	 * @throws TechDivision_Logger_Exception_LoggerException
	 * 		Is thrown if the log message can not be written to the database
	 */
	public function log($message, $level = 3, $line = null, $method = null) {
		// if the passed log level is equal or smaller
		if ($level <= $this->getLogLevel()) {
			// initialize the log time
			$time = time();
			// insert the log message into the database
			$affectedRows = $this->getStatement()->execute(
			    array(
			        $this->message(
			            $message,
			            $level,
			            $line,
			            $method,
			            $time
			        )
			    )
			);
			// check if an error occured
			if (PEAR::isError($affectedRows)) {
			    // if yes, throw an exception
				throw new TechDivision_Logger_Exceptions_LoggerException(
				    $affectedRows->getMessage()
				);
			}
			// return the timestamp when the message was logged
			return $time;
		}
	}

	/**
	 * The SQL statement used for logging.
	 *
	 * @param string $statement The SQL statement
	 * @return TechDivision_Logger_Interfaces_Logger
	 * 		The Logger instance itself
	 */
	public function setStatement($statement)
	{
	    $this->_statement = $statement;
	    return $this;
	}

	/**
	 * Returns the SQL statement used for logging.
	 *
	 * @return string The SQL statement
	 */
	public function getStatement()
	{
	    return $this->_statement;
	}
}