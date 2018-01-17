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
class CLXsmsContent extends XoopsObject
{
    function __construct()
    {
        $this->initVar('content_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('content', XOBJ_DTYPE_TXTBOX, '', 360);
        $this->initVar('method', XOBJ_DTYPE_ENUM, 'unknown', 0, false, false, array('sent','received','unknown'));
        $this->initVar('actioned', XOBJ_DTYPE_INT);
        $this->initVar('deleted', XOBJ_DTYPE_INT);
    }

}

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsContentHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsContentHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_content", "CLXsmsContent", "content_id", 'content');
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
    		$obj->setVar('actioned', time());
    		$obj->setVar('deleted', time() + getCLXSMSConfig('sms_deleted'));
    	}
    	return parent::insert($obj, $force);
    }
    
    function maintenance()
    {
    	$sql = "DELETE FROM `" . $this->table . "` WHERE `deleted` <= '" . time() . "'";
    	return $this->db->queryF($sql);
    }
}
?>