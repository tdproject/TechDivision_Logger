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


require_once 'TechDivision/Logger/FirePHP.php';

/**
* This is a mock/wrapper-class of the firePHP-logger to make testing of the logger-possible.
*
* @package TechDivision_Logger
* @author Markus Berwanger <m.berwanger@techdivision.com>
* @copyright TechDivision GmbH
* @link http://www.techdivision.com
* @license GPL
*/
class TechDivision_Logger_FirePHP_MockWrapper extends FirePHP {

	/**
	 * Holds an array os Strings to store the data.
	 * @var String[]
	 */
	protected $_messages = array();

	/**
	 * Testing-implementation of the original fb()-function.
	 * Is only pushing the given message to the storage.
	 * @param String $message
	 * @return void
	 */
	public function fb($message)
	{
		$this->_messages[] = $message;
	}

	/**
	 * Returns all stored messages.
	 * @return String[]
	 */
	public function getMessages()
	{
		return $this->_messages;
	}
	
	/**
	 * Deletes all stored messages.
	 * @return void
	 */
	public function reset(){
		$this->_messages = array();
	}
}