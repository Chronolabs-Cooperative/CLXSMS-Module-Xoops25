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
class CLXsmsStatistics extends XoopsObject
{
    function __construct()
    {
        $this->initVar('statistic_id', XOBJ_DTYPE_INT, null, true);
        $this->initVar('type', XOBJ_DTYPE_ENUM, 'system', false, false, false, array('send','receive','delievered','queued','system'));
        $this->initVar('day', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('month', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('year', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('hour', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('from', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('to', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('count', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('errors', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('nocredit', XOBJ_DTYPE_INT, 0, false);

    }

}

/**
 * @subpackage class
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsStatisticsHandler extends XoopsPersistableObjectHandler
{
    function CLXsmsStatisticsHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "clxsms_statistics", "CLXsmsStatistics", "statistic_id", 'type');
    }
    
    function doesStatisticExist($type = 'system')
    {
    	$criteria = new CriteriaCompo(new Criteria('type', $type));
    	$criteria->add(new Criteria('day', date('d')));
    	$criteria->add(new Criteria('month', date('m')));
    	$criteria->add(new Criteria('year', date('Y')));
    	$criteria->add(new Criteria('hour', date('H')));
    	if ($this->getCount($criteria)>0)
    		return true;
    	return false;
    }

    /**
     * 
     * @param string $type
     * @param number $from
     * @param number $to
     * @return unknown
     */
    function SumCountStatistic($type='system', $from = 0, $to = 0)
    {
    	if ($from==0||$to==0) {
    		$from = strtotime(date('Y-m-d 0:0:01'));
    		$to = strtotime(date('Y-m-d 23:59:59'));
    	}
    	if (is_array($type))
    		$type = "`type` IN ('" . implode("', '", $type) . "')";
    	else 
    		$type = "`type` = '" . $type . "'";
    	$sql = "SELECT count(*) as count FROM `" . $this->table . "` WHERE `from` >= '" . $from . "' AND `to` <= '" . $to . "' AND $type";
    	$result = $this->db->queryF($sql);
    	list($count) = $this->db->fetchRow($result);
    	return $count;
    }

    /**
     * 
     * @param string $type
     * @param number $number
     */
    function AddCountStatistic($type='system', $number=1) 
    {
    	if (!$this->doesStatisticExist($type)) {
    		$sql = "INSERT INTO `" . $this->table . "` (`type`, `day`, `month`, `year`, `hour`, `from`, `to`, `count`) VALUES ('" . $type . "','" . date('d') . "','" . date('m') . "','" . date('Y') . "','" . date('H') . "','" . strtotime(date('Y-m-d H:0:0')) . "','" . strtotime(date('Y-m-d H:59:59')) . "','" . $number . "')"; 
    	} else {
    		$sql = "UPDATE `" . $this->table . " SET `count` = `count` + '" . $number . "' WHERE `from` >= '" . time() . "' AND `to` <= '" . time() . "'";
    	}
    	return $this->db->queryF($sql);
    }
    
    /**
     * 
     * @param string $type
     * @param number $number
     */
    function AddErrorStatistic($type='system', $number=1)
    {
    	if (!$this->doesStatisticExist($type)) {
    		$sql = "INSERT INTO `" . $this->table . "` (`type`, `day`, `month`, `year`, `hour`, `from`, `to`, `errors`) VALUES ('" . $type . "','" . date('d') . "','" . date('m') . "','" . date('Y') . "','" . date('H') . "','" . strtotime(date('Y-m-d H:0:0')) . "','" . strtotime(date('Y-m-d H:59:59')) . "','" . $number . "')";
    	} else {
    		$sql = "UPDATE `" . $this->table . " SET `errors` = `errors` + '" . $number . "' WHERE `from` >= '" . time() . "' AND `to` <= '" . time() . "'";
    	}
    	return $this->db->queryF($sql);
    }

    /**
     * 
     * @param string $type
     * @param number $number
     */
    function AddNoCreditStatistic($type='system', $number=1)
    {
    	if (!$this->doesStatisticExist($type)) {
    		$sql = "INSERT INTO `" . $this->table . "` (`type`, `day`, `month`, `year`, `hour`, `from`, `to`, `nocredit`) VALUES ('" . $type . "','" . date('d') . "','" . date('m') . "','" . date('Y') . "','" . date('H') . "','" . strtotime(date('Y-m-d H:0:0')) . "','" . strtotime(date('Y-m-d H:59:59')) . "','" . $number . "')";
    	} else {
    		$sql = "UPDATE `" . $this->table . " SET `nocredit` = `nocredit` + '" . $number . "' WHERE `from` >= '" . time() . "' AND `to` <= '" . time() . "'";
    	}
    	return $this->db->queryF($sql);
    }
    
}
?>