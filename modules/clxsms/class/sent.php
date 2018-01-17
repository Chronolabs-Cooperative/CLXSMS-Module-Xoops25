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
class CLXsmsSent extends XoopsObject
{
    function __construct($data = array())
    {
        $this->initVar('sent_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('delievery_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('msgid', XOBJ_DTYPE_TXTBOX, '', false, 50);
        $this->initVar('from_uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('to_uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('from_number_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('to_number_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sms_level', XOBJ_DTYPE_ENUM, 'normal', false, false, false, array('required','important','normal','low'));
        $this->initVar('sms_sent_after', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sms_sent_before', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sms_day_number', XOBJ_DTYPE_INT, null, false);
        $this->initVar('sms_content_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('module', XOBJ_DTYPE_TXTBOX, 'clxsms', false, 50);
        $this->initVar('class', XOBJ_DTYPE_TXTBOX, 'sent', false, 50);
        $this->initVar('function', XOBJ_DTYPE_TXTBOX, 'sent', false, 50);
        $this->initVar('identity', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('key', XOBJ_DTYPE_TXTBOX, sha1(NULL), false, 44);
        $this->initVar('plugins', XOBJ_DTYPE_ARRAY);
        $this->initVar('keys', XOBJ_DTYPE_ARRAY);
        $this->initVar('identities', XOBJ_DTYPE_ARRAY);
        $this->initVar('created', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('sent', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('retry', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('canceled', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('deleted', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('response_id', XOBJ_DTYPE_INT, 0, false);
        
        if (!empty($data))
        	$this->assignVars($data);
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
class CLXsmsSentHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsSentHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_sent", "CLXsmsSent", "", '');
    }
    
	/**
	 * 
	 * @param mixed $priorities
	 * @param number $after
	 * @param number $before
	 * @return multitype:CLXsmsSent
	 */
    function getSMSToSend($priorities = array(), $after = 0, $before = 0)
    {
    	if ($after==0||$before==0) {
    		$after = time()-1;
    		$before = time()+1;
    	}
    	
    	if (is_array($priorities)) {
    		$sms_level = " AND `sms_level` IN ('" . implode("', '", $priorities) . "')";
    	} elseif (is_string($priorities)) {
    		$sms_level = " AND `sms_level` = '" . $priorities . "'";
    	}
    	
    	$sql = "SELECT * FROM `" . $this->table . "` WHERE (`sent` = '0' AND (`retry` = '0' OR `retry` <= '" . time() ."') AND `canceled` = '0') AND ((`sms_sent_after` = '0' OR `sms_sent_after` <= '" . $after . "') AND ((`sms_sent_before` = '0' OR `sms_sent_before` >= '" . $before . "') OR `sms_level` = 'required')) $sms_level";
    	
    	$results = $this->db->queryF($sql);
    	$ret = array();
    	while($row = $this->db->fetchArray($results)) {
    		$ret[$row['sent_id']] = new CLXsmsSent($row);
    	}
    	return $ret;
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
    		$obj->setVar('created', time());
    		$obj->setVar('deleted', (time() + getCLXSMSConfig('sms_deleted')>$obj->getVar('sms_sent_before')?time() + getCLXSMSConfig('sms_deleted'):$obj->getVar('sms_sent_before') + getCLXSMSConfig('sms_deleted')));
    		$obj = parent::get(parent::insert($obj, $force));
    		$ret = firePlugins($obj, _CLXSMS_PLUGINS_QUEUEDMESSAGE, false);
    		$obj->setVar('plugins', array('queued'=>$ret['plugins']));
    		$obj->setVar('keys', array('queued'=>$ret['keys']));
    		$obj->setVar('identities', array('queued'=>$ret['identities']));
    		$numbers_handler = xoops_getmodulehandler('numbers', 'clxsms');
    		if ($obj->getVar('from_number_id')>0) {
    			$number = $numbers_handler->get($obj->getVar('from_number_id'));
    			$number->setVar('number_queued', $number->getVar('number_queued')+1);
    			$number->setVar('last_queued', time());
    			$number->setVar('last_queued_id', $obj->getVar('sent_id'));
    			$numbers_handler->insert($number, true);
    			unset($number);
    		}
    		if ($obj->getVar('to_number_id')>0) {
    			$number = $numbers_handler->get($obj->getVar('to_number_id'));
    			$number->setVar('number_queued', $number->getVar('number_queued')+1);
    			$number->setVar('last_queued', time());
    			$number->setVar('last_queued_id', $obj->getVar('sent_id'));
    			$numbers_handler->insert($number, true);
    			unset($number);
    		}
    		$statistics_handler = xoops_getmodulehandler('statistics', 'clxsms');
    		$statistics_handler->AddCountStatistic('queued');
    	} else {
    		if ($obj->vars['sent']['changed']==true && $obj->getVar('sent') > 0) {
    			$ret = firePlugins($obj, _CLXSMS_PLUGINS_SENTMESSAGE, false);
    			$obj->setVar('plugins', array_merge(array('sent'=>$ret['plugins']), $obj->getVar('plugins')));
    			$obj->setVar('keys', array_merge(array('sent'=>$ret['keys']), $obj->getVar('keys')));
    			$obj->setVar('identities', array_merge(array('sent'=>$ret['identities']), $obj->getVar('identities')));
    			$statistics_handler = xoops_getmodulehandler('statistics', 'clxsms');
	    		$statistics_handler->AddCountStatistic('send');
	    		$obj->setVar('sms_day_number', $statistics_handler->SumCountStatistic('send'));
	    		$numbers_handler = xoops_getmodulehandler('numbers', 'clxsms');
	    		if ($obj->getVar('from_number_id')>0) {
	    			$number = $numbers_handler->get($obj->getVar('from_number_id'));
	    			$number->setVar('number_sent', $number->getVar('number_sent')+1);
	    			$number->setVar('last_sent', time());
	    			$number->setVar('last_sent_id', $obj->getVar('sent_id'));
	    			$numbers_handler->insert($number, true);
	    			unset($number);
	    		}
	    		if ($obj->getVar('to_number_id')>0) {
	    			$number = $numbers_handler->get($obj->getVar('to_number_id'));
	    			$number->setVar('number_sent', $number->getVar('number_sent')+1);
	    			$number->setVar('last_sent', time());
	    			$number->setVar('last_sent_id', $obj->getVar('sent_id'));
	    			$numbers_handler->insert($number, true);
	    			unset($number);
	    		}
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