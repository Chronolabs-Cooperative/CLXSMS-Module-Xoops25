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
class CLXsmsDelievery extends XoopsObject
{
    function __construct()
    {
        $this->initVar('delievery_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('sent_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('msgid', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('source', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('destination', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('status', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('errorcode', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('datetime', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('userref', XOBJ_DTYPE_TXTBOX, '', 50);
        $this->initVar('created', XOBJ_DTYPE_INT);
        $this->initVar('deleted', XOBJ_DTYPE_INT);
    }

}

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsDelieveryHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsDelieveryHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_delievery", "CLXsmsDelievery", "delievery_id", 'msgid');
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
    		$obj->setVar('deleted', time() + getCLXSMSConfig('sms_deleted'));
    		$sent_handler = xoops_getmodulehandler('sent', 'clxsms');
    		$criteria = new Criteria('msgid', $obj->getVar('msgid'));
    		$objs = $sent_handler->getObjects($criteria, false);
    		if (is_object($objs[0])) {
    			$obj->setVar('sent_id', $objs[0]->getVar('sent_id'));
    			$obj = parent::get(parent::insert($obj, $force));
    			$objs[0]->setVar('delivery_id', $obj->getVar('delievery_id'));
    			$sent_handler->insert($objs[0], true);
    		}
    		firePlugins($obj, _CLXSMS_PLUGINS_ReceiveDNOTICE, false);
    		$statistics_handler = xoops_getmodulehandler('statistics', 'clxsms');
    		$statistics_handler->AddCountStatistic('delievered');
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