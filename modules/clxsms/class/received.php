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

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsReceived extends XoopsObject
{
    function __construct()
    {
        $this->initVar('received_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('from_uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('from_number_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('to_number_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sms_content_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('response_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('method', XOBJ_DTYPE_ENUM, 'callback', false, false, false, array('callback','polled'));
        $this->initVar('received', XOBJ_DTYPE_INT, null, false);
        $this->initVar('deleted', XOBJ_DTYPE_INT, null, false);
        $this->initVar('plugins', XOBJ_DTYPE_ARRAY);
        $this->initVar('keys', XOBJ_DTYPE_ARRAY);
        $this->initVar('identities', XOBJ_DTYPE_ARRAY);
    }

    /**
     * Return the To number as Mixed Results
     *
     * @param string $as_array
     * @return mixed
     */
    function to($as_array = false)
    {
    	$numbers_handler = xoops_getmodulehandler('numbers', 'clxsms');
    	$number = $number_handler->get($this->getVar('to_number_id'));
    	return ($as_array==false?$number:$number->toArray());
    }
    
    /**
     * Return the From number as Mixed Results
     *
     * @param string $as_array
     * @return mixed
     */
    function from($as_array = false)
    {
    	$numbers_handler = xoops_getmodulehandler('numbers', 'clxsms');
    	$number = $number_handler->get($this->getVar('from_number_id'));
    	return ($as_array==false?$number:$number->toArray());
    }
    
    /**
     * Return the SMS Message as Mixed Results
     *
     * @param string $as_array
     * @return mixed
     */
    function message($as_array = false)
    {
    	$content_handler = xoops_getmodulehandler('content', 'clxsms');
    	$content = $content_handler->get($this->getVar('sms_content_id'));
    	return ($as_array==false?$content:$content->toArray());
    }
    
}

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsReceivedHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsReceivedHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_received", "CLXsmsReceived", "received_id", 'sms_content_id');
    }
    
    /**
     *
     * @param unknown $obj
     * @param string $force
     *
     * return integer
     */
    function insert($obj, $force = true) {
    	if ($obj->isNew()) {
    		$obj->setVar('received', time());
    		$obj->setVar('deleted', time() + getCLXSMSConfig('sms_deleted'));
    		$obj = parent::get(parent::insert($obj, $force));
    		$ret = firePlugins($obj, _CLXSMS_PLUGINS_ReceiveDMESSAGE, false);
    		$obj->setVar('plugins', $ret['plugins']);
    		$obj->setVar('keys', $ret['keys']);
    		$obj->setVar('identities', $ret['identities']);
    		$statistics_handler = xoops_getmodulehandler('statistics', 'clxsms');
    		$statistics_handler->AddCountStatistic('receive');
    		$numbers_handler = xoops_getmodulehandler('numbers', 'clxsms');
    		if ($obj->getVar('from_number_id')>0) {
    			$number = $numbers_handler->get($obj->getVar('from_number_id'));
    			$number->setVar('number_received', $number->getVar('number_received')+1);
    			$number->setVar('last_received', time());
    			$number->setVar('last_received_id', $obj->getVar('received_id'));
    			$numbers_handler->insert($number, true);
    			unset($from);
    		}
    		if ($obj->getVar('to_number_id')>0) {
    			$number = $numbers_handler->get($obj->getVar('to_number_id'));
    			$number->setVar('number_received', $number->getVar('number_received')+1);
    			$number->setVar('last_received', time());
    			$number->setVar('last_received_id', $obj->getVar('received_id'));
    			$numbers_handler->insert($number, true);
    			unset($from);
    		}
    	}
    	return parent::insert($obj, $force);
    }
    
    /**
     * Function that runs maintenance on the database's table
     *
     * @return boolean
     */
    function maintenance()
    {
    	$sql = "DELETE FROM `" . $this->table . "` WHERE `deleted` <= '" . time() . "'";
    	return $this->db->queryF($sql);
    }
    
}
?>