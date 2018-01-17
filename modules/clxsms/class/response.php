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
class CLXsmsResponse extends XoopsObject
{
    function __construct()
    {
        $this->initVar('response_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('code', XOBJ_DTYPE_INT, null, false);
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, XOOPS_URL, 500);
        $this->initVar('method', XOBJ_DTYPE_ENUM, 'curl', false, false, false, array('furl','curl'));
        $this->initVar('response', XOBJ_DTYPE_OTHER);
        $this->initVar('data', XOBJ_DTYPE_ARRAY);
        $this->initVar('created', XOBJ_DTYPE_INT, null, true);
        $this->initVar('deleted', XOBJ_DTYPE_INT, null, true);
    }

}

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsResponseHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsResponseHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_responses", "CLXsmsResponse", "response_id", 'code');
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
    		$obj->setVar('deleted', time() + getCLXSMSConfig('responses_deleted'));
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