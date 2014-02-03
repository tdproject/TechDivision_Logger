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

require_once 'FirePHPCore/FirePHP.class.php';


/**
 * This class is a logger implementation for PHP and sends all log
 * messages to the firePHP firefox-plugin (www.firephp.org).
 *
 * @package TechDivision_Logger
 * @author Markus Berwanger <m.berwanger@techdivision.com>
 * @copyright TechDivision GmbH
 * @link http://www.techdivision.com
 * @license GPL
 */
class TechDivision_Logger_FirePHP extends TechDivision_Logger_Abstract {

    /**
     * Holds the firePHP-instance.
     * @var firePHP-instance
     */
    protected $_instance;

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
        TechDivision_Properties_Properties $properties)
    {
        // initialize the superclass
        TechDivision_Logger_Abstract::__construct($classname, $properties);
        //initializes the firePHP logger-instance
        $instance = FirePHP::getInstance(true);
        //disable firebug's internal line number reports
        $options = array('includeLineNumbers' => false);
        $instance->setOptions($options);
        //start output buffering
        ob_start();
        //set the internal firePHP-instance
        $this->setInstance($instance);
    }

    /**
     * Sets the instance to be used.
     * @param firePHP-instance $instance
     */
    public function setInstance($instance)
    {
        $this->_instance = $instance;
    }

    /**
     * Returns the stored instance.
     * @return firePHP-instance
     */
    public function getInstance()
    {
        return $this->_instance;
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
     */
    public function log($message, $level = 3, $line = null, $method = null) {
        // if the passed log level is equal or smaller
        if ($level <= $this->getLogLevel()) {
            // initialize the log time
            $time = time();
            //use error-logging for emergencies(0), alerts(1), criticals(2) and errors(3)
            if ($level <= 3){
                $this->getInstance()->error($this->message($message, $level, $line, $method, $time));
            }
            //use warning-logging for warnings(4)
            else if ($level == 4){
                $this->getInstance()->warn($this->message($message, $level, $line, $method, $time));
            }
            //use info-logging for normal but significant messages(5) and information(6)
            else if (5 <= $level && $level <= 6) {
                $this->getInstance()->info($this->message($message, $level, $line, $method, $time));
            }
            //use normal logging for log-debugs(7) and others
            else{
                $this->getInstance()->log($this->message($message, $level, $line, $method, $time));
            }
            return $time;
        }
    }
}

