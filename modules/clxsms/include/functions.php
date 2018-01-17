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

// Includes the constants definition file
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . "constants.php";


/**
 * This function allows for any application calling it to send an SMS via the queue from anywhere within XOOPS
 * 
 * @param string $from The number the SMS is being sent from
 * @param string $to The number the SMS is being sent to
 * @param string $message The message being sent (Maximum 360 chars)
 * @param string $piority Message level/piority as outline in constants.php
 * @param integer $after Unix time that the message is to be sent after
 * @param integer $before Unix time that the messahe is to be sent before or ignored unless piority/level = 'required'
 * @param string $module XOOPS module dirname sending the SMS
 * @param integer $identity The XOOPS Module identity number for the item (Normally Database Identity)
 * @param string $key A key or Hash that can be used to identify the SMS
 * @param string $class The class calling the function normally specified by __CLASS__
 * @param string $function The function calling the function normally specified by __FUNCTION__
 * 
 * @return integer
 */
function sendSMS($from = '', $to = '', $message = '', $priority = '', $after = 0, $before = 0, $module = '', $identity = 0, $key = '', $class = '', $function = '')
{
	if ((empty($from) && empty($to)) || empty($message))
		return false;

	if (empty($priority))
		$priority = _CLXSMS_NORMAL;

	if (empty($module) && is_object($GLOBALS['xoopsModule']))
		$module = $GLOBALS['xoopsModule']->getVar('dirname');

	if ($after>$before) {
		$diff = $before - $after;
		$after = time();
		$before = $after + $diff;
	} elseif($before<time() && $after>0) {
		$diff = $after - $before;
		$after = time();
		$before = $after + $diff;
	}

	$content_handler = xoops_getmodulehandler('content', 'clxsms');
	$sent_handler = xoops_getmodulehandler('sent', 'clxsms');

	$from_array = getNumberArray($from, 'queue');
	$to_array = getNumberArray($to, 'queue');

	$content = $content_handler->create();
	$content->setVar('content', substr($message, 360, 0));
	$content->setVar('method', 'sent');
	$content_id = $content_handler->insert($content, true);

	$sms = $sent_handler->create();
	$sms->setVar('from_number_id', $from_array['number_id']);
	$sms->setVar('from_uid', $from_array['uid']);
	$sms->setVar('to_number_id', $to_array['number_id']);
	$sms->setVar('to_uid', $to_array['uid']);
	$sms->setVar('sms_level', $priority);
	$sms->setVar('sms_sent_after', $after);
	$sms->setVar('sms_sent_before', $before);
	$sms->setVar('sms_day_number', 0);
	$sms->setVar('sms_content_id', $content_id);
	$sms->setVar('module', $module);
	$sms->setVar('class', $class);
	$sms->setVar('function', $function);
	$sms->setVar('identity', $identity);
	$sms->setVar('key', $key);

	return $sent_handler->insert($sms, true);

}

/**
 * 
 * @return Object <CLXsmsGet>
 */
function getURLRetriever() {
	static $object = NULL;
	if (!is_object($object)) {
		include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'get' . DIRECTORY_SEPARATOR . 'get.php';
		$object = new CLXsmsGet();
	}
	return $object;
}

/**
 * 
 * @param array $responses
 * @return string
 */
function determineType ($responses = array()) {
	// Functions constants
	if (!defined('_CLXSMS_NONE'))
		define('_CLXSMS_NONE', 'none');
	if (!defined('_CLXSMS_SMS'))
		define('_CLXSMS_SMS', 'sms');
	if (!defined('_CLXSMS_RECIEPT'))
		define('_CLXSMS_RECIEPT', 'reciept');
	
	// Function Routines
	if (!is_array($responses)) {
		return _CLXSMS_NONE;
	}
	if (count($responses) > 0) {
		if (isset($response[-1])) {
			return _CLXSMS_SMS;
		} else {
			return _CLXSMS_RECIEPT;
		}
	}
}

/**
 * 
 * @param string $input
 * @return array|multitype:
 */
function processIncoming ($input) {
	if ($input == "0#") {
		return true;
	}
	$receipts = explode("#", $input);

	array_shift($receipts);

	$to_return = array();

	foreach ($receipts as $receipt) {
		if ($receipt == "") {
			continue;
		}
		$field = explode(":", $receipt);
		array_push($to_return, $field);
	}
	return $to_return;
}

/**
 * 
 * @param string $config
 * @return mixed
 */
function getCLXSMSConfig($config = '') 
{
	static $configs = array();
	if (empty($configs)&&count($configs)==0) {
		if (is_object($GLOBALS['xoopsModule'])) {
			if ($GLOBALS['xoopsModule']->getVar('dirname')=='clxsms') {
				$configs = $GLOBALS['xoopsModuleConfig'];
			}
		}
		if (count($configs)==0||empty($configs)) {
			$module_handler = xoops_gethandler('module');
			$config_handler = xoops_gethandler('config');
			$modCLXsms = $module_handler->getByDirname('clxsms');
			$configs = $config_handler->getConfigList($modCLXsms->getVar('mid'));
		}
	}
	return (isset($configs[$config])?(defined($configs[$config])?constant($configs[$config]):$configs[$config]):false);
}

/*
 * @return string
 */
function getAPIRURL() {
	return getCLXSMSConfig('sms_node_'.getCLXSMSConfig('sms_node_recommended'));
}

/**
 * 
 * @param string $number
 * @param string $type
 * @return array
 */
function getNumberArray($number = '', $type = 'sent') 
{
	$numbers_handler = xoops_getmodulehandler('numbers', 'clxsms');
	return $numbers_handler->getNumberArray($number, $type);
}

/**
 * 
 * @param object $obj
 * @param string $type
 * @param string $firstonly
 * @return multitype:|Ambigous <array, boolean>
 */
function firePlugins($obj, $type = '', $firstonly = false) 
{
	/**
	 * 
	 */
	static $plugins = array();
	
	if (is_array($plugins) && count($plugins) == 0)
	{
		xoops_load('XoopsLists');
		$files = XoopsLists::getFileListAsArray(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'plugins');
		foreach($files as $file) {
			if (substr($file, 3, strlen($file)-3)=='php') {
				$namespace = substr($file, 3, strlen($file)-3);
				include_once (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $file);
				$class_name = "CLXsmsPlugin" . ucfirst($namespace);
				if (class_exists($class_name)) {
					$plugins[$namespace]['object'] = new $class_name();
					$plugins[$namespace]['types'] = $plugins[$namespace]['object']->getTypes();
				}
 			}
		}
	}

	$result = array();
	$function = 'action';
	foreach(explode('.', $type) as $ity)
		$function .= ucfirst($ity);
	foreach($plugins as $namespace => $plugin)
	{
		$ret = array();
		if (in_array($type, $plugin['types'])) {
			try {
				$ret = $plugin['object']->$function($obj, $firstonly);
			}
			catch (Exception $e) { trigger_error('Plugin Failed: '.$e, E_WARNING); }	
		}
		if (count($ret)>0 && $firstonly == true)
			return $ret;
		elseif (count($ret)>0 && $firstonly == false) {
			$result[$namespace] = $ret;
			$result['plugins'][$plugin] = $plugin;
			if (isset($ret['key']))
				$result['keys'][$plugin] = $ret['key'];
			if (isset($ret['id']))
				$result['identities'][$plugin] = $ret['id'];
			unset($ret);
		}
			
	}
	return (count($results)>0?$results:false);
}

?>
