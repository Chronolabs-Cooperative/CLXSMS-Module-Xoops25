<?php
/**
 * CLXsms Class to 
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Cooperative http://sourceforge.net/projects/chronolabs/
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         CLXSMS
 * @since           1.0.2
 * @author          Simon Roberts
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

/**
 * The class name is always based on the filename as you can see as the file is called example.php
 * the classname also reflects this in it last cased constant as Example in CLXsmsPluginExample
 * 
 * @subpackage plugins
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsPluginExample 
{
	
	/**
	 * Supported Functions Array for the Plugin
	 * 
	 * @var array
	 */
	var $types = array();
	
	function __construct()
	{
		/**
		 * This variable below this comment is an array, you define this array on construction of the class too outline the
		 * support actions of the plugin to the CLXSMS Module. This would have to be uncommented and contain the same or similar
		 * data based on the "Plugin Actions Constants" as outlined in /modules/clxsms/include/constants.php
		 */
		//$this->types = array('user.number', 'received.message', 'received.notice', 'queued.message', 'sent.message');
	}
	
	/**
	 * Required function to return the types of actions the plugin supports as an associative array
	 * @return array
	 */
	function getTypes()
	{
		return $this->types;
	}
	
	/**
	 * This function is used to determine in a plugin a UID of a user that belongs to the number listed
	 * in the CLXsmsNumbers Object that is passed to this plugin function. 
	 * 
	 * Must return array('uid'=>0).
	 *  
	 * @param CLXsmsNumbers $obj
	 * @param boolean $firstonly
	 * @return array:
	 */
	function actionUserNumber(CLXsmsNumbers $obj, $firstonly = false)
	{
		return array('uid' => 0);	
	}
	

	/**
	 * This function is used to pass a received sms to be parse by other modules by this plugin
	 * it is passed a complete CLXsmsReceived Object on its first creation.
	 *
	 * Reserved Variables to return is 'id' (integer) and 'key' (varchar[44]) these should be 
	 * returned in all possible instances but any other variable apart from these two is accessable.
	 *
	 * @param CLXsmsReceived $obj
	 * @param boolean $firstonly
	 * @return array:
	 */
	function actionReceivedMessage(CLXsmsReceived $obj, $firstonly = false)
	{
		return array('id' => 0, 'key' => sha1(NULL));
	}
	
	
	/**
	 * This function is used to pass a delievery notice to be parse by other modules by this plugin
	 * it is passed a complete CLXsmsDelievery Object on its first creation.
	 *
	 * @param CLXsmsDelievery $obj
	 * @param boolean $firstonly
	 * @return boolean:
	 */
	function actionReceivedNotice(CLXsmsDelievery $obj, $firstonly = false)
	{
		return false;
	}
	

	/**
	 * This function is used to pass a queued sms to be parse by other modules by this plugin
	 * it is passed a complete CLXsmsSent Object on its first creation.
	 *
	 * Reserved Variables to return is 'id' (integer) and 'key' (varchar[44]) these should be
	 * returned in all possible instances but any other variable apart from these two is accessable.
	 *
	 * @param CLXsmsSent $obj
	 * @param boolean $firstonly
	 * @return array:
	 */
	function actionQueuedMessage(CLXsmsSent $obj, $firstonly = false)
	{
		return array('id' => 0, 'key' => sha1(NULL));
	}


	/**
	 * This function is used to pass an sms that has just been sent to be parse by other modules
	 * by this plugin it is passed a complete CLXsmsSent Object on its first creation.
	 *
	 * Reserved Variables to return is 'id' (integer) and 'key' (varchar[44]) these should be
	 * returned in all possible instances but any other variable apart from these two is accessable.
	 *
	 * @param CLXsmsSent $obj
	 * @param boolean $firstonly
	 * @return array:
	 */
	function actionSentMessage(CLXsmsSent $obj, $firstonly = false)
	{
		return array('id' => 0, 'key' => sha1(NULL));
	}
	
}