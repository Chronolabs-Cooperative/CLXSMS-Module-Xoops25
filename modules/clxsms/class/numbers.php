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
class CLXsmsNumbers extends XoopsObject
{
    function __construct()
    {
        $this->initVar('number_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('number', XOBJ_DTYPE_INT, null, false);
        $this->initVar('number_queued', XOBJ_DTYPE_INT, null, false);
        $this->initVar('number_sent', XOBJ_DTYPE_INT, null, false);
        $this->initVar('number_received', XOBJ_DTYPE_INT, null, false);
        $this->initVar('last_queued_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('last_sent_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('last_received_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('last_queued', XOBJ_DTYPE_INT, null, false);
        $this->initVar('last_sent', XOBJ_DTYPE_INT, null, false);
        $this->initVar('last_received', XOBJ_DTYPE_INT, null, false);
        $this->initVar('banned', XOBJ_DTYPE_ENUM, 'No', false, false, false, array('Yes', 'No'));
    }

}

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsNumbersHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsNumbersHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_numbers", "CLXsmsNumbers", "number_id", 'number');
    }
    
    /**
     * 
     * @param string $number
     * @param string $type
     */
    public function getNumberArray($number = '', $type = 'sent')
    {
    	$ret = array();
    	$criteria = new Criteria('number', $number);
    	if ($this->count($criteria)>0)
    	{
    		$objs = $this->getObjects($criteria, false);
    		if (is_object($objs[0])) {
    			$ret = firePlugins($objs[0], _CLXSMS_PLUGINS_USERNUMBER, true);
    			if ($objs[0]->getVar('banned')=='No') {
    				switch($type) {
    					case "queue":
    					case "queued":
    						$objs[0]->setVar('last_queued', time());
    						break;
    					case "send":
    					case "sent":
    						$objs[0]->setVar('last_sent', time());
    						break;
    					case "received":
    					case "receive":
    						$objs[0]->setVar('last_received', time());
    						break;
    				}
    				$this->insert($objs[0], true);
    				$ret['number_id'] = $objs[0]->getVar('number_id');
		    		$ret['number_id'] = $this->insert($obj, true);;
		    		$ret['number_queued'] = $obj->getVar('number_queued');
		    		$ret['number_sent'] = $obj->getVar('number_sent');
		    		$ret['number_received'] = $obj->getVar('number_received');
		    		$ret['last_queued_id'] = $obj->getVar('last_queued_id');
		    		$ret['last_sent_id'] = $obj->getVar('last_sent_id');
		    		$ret['last_received_id'] = $obj->getVar('last_received_id'); 		
		    		$ret['last_queued'] = $obj->getVar('last_queued');
		    		$ret['last_sent'] = $obj->getVar('last_sent');
		    		$ret['last_received'] = $obj->getVar('last_received');
    				$ret['banned'] = false;
    			} else {
    				$ret['number_id'] = $objs[0]->getVar('number_id');
		    		$ret['number_id'] = $this->insert($obj, true);;
		    		$ret['number_queued'] = $obj->getVar('number_queued');
		    		$ret['number_sent'] = $obj->getVar('number_sent');
		    		$ret['number_received'] = $obj->getVar('number_received');
		    		$ret['last_queued_id'] = $obj->getVar('last_queued_id');
		    		$ret['last_sent_id'] = $obj->getVar('last_sent_id');
		    		$ret['last_received_id'] = $obj->getVar('last_received_id'); 		
		    		$ret['last_queued'] = $obj->getVar('last_queued');
		    		$ret['last_sent'] = $obj->getVar('last_sent');
		    		$ret['last_received'] = $obj->getVar('last_received');
    				$ret['banned'] = true;
    			}
    		}
    	}
    	
    	if (is_array($ret) && count($ret) == 0) 
    	{
    		$obj = $this->create();
    		$obj->setVar('number', $number);
    		$obj->setVar('banned', false);
    		switch($type) {
    			case "queue":
    			case "queued":
    				$obj->setVar('last_queued', time());
    				break;
    			case "send":
    			case "sent":
    				$obj->setVar('last_sent', time());
    				break;
    			case "received":
    			case "receive":
    				$obj->setVar('last_received', time());
    				break;
    		}
    		$ret['number_id'] = $this->insert($obj, true);;
    		$ret['number_queued'] = $obj->getVar('number_queued');
    		$ret['number_sent'] = $obj->getVar('number_sent');
    		$ret['number_received'] = $obj->getVar('number_received');
    		$ret['last_queued_id'] = $obj->getVar('last_queued_id');
    		$ret['last_sent_id'] = $obj->getVar('last_sent_id');
    		$ret['last_received_id'] = $obj->getVar('last_received_id'); 		
    		$ret['last_queued'] = $obj->getVar('last_queued');
    		$ret['last_sent'] = $obj->getVar('last_sent');
    		$ret['last_received'] = $obj->getVar('last_received');
    		$ret['banned'] = false;
    		$ret = array_merge($ret, firePlugins($this->get($ret['number_id']), _CLXSMS_PLUGINS_USERNUMBER, true));
    	}
    	return (is_array($ret) && count($ret) == 0)?false:$ret;
    }
}
?>