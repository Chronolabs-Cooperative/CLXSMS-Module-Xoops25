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
 * @subpackage data
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsGet
{
	/**
	 * Contains Module configs
	 * @var array
	 */
	var $configs = array();
	
	/**
	 * 
	 */
	function __construct() {
		if (is_object($GLOBALS['xoopsModule'])) {
			if ($GLOBALS['xoopsModule']->getVar('dirname')=='clxsms') {
				$this->configs = $GLOBALS['xoopsModuleConfig'];	
			}
		}
		if (count($this->configs)==0||empty($this->configs)) {
			$module_handler = xoops_gethandler('module');
			$config_handler = xoops_gethandler('config');
			$modCLXsms = $module_handler->getByDirname('clxsms');
			$this->configs = $config_handler->getConfigList($modCLXsms->getVar('mid'));
		}
			
	}
	
	/**
	 * 
	 * @param string $url
	 * @param unknown $get
	 * @param unknown $post
	 * @param unknown $headers
	 * @param string $method
	 * @return unknown|multitype:number string unknown |multitype:number string multitype:boolean string
	 */
	function get($url='', $get=array(), $post=array(), $headers=array(), $method = '')
	{
		if (empty($method))
			$method = $this->configs['api_method'];
		if (!ini_get('allow_furl_open')&&$method='furl')
			$method = 'curl';
		if (!extension_loaded('curl')&&$method = 'curl'&&ini_get('allow_furl_open'))
			$method = 'furl';
		include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . $method . '.php';
		$class_name = 'CLXsmsGet'.ucfirst($method);
		if (class_exists($class_name)) {
			$obj = new $class_name();
			$ret = $obj->retrieve($url, $get, $post, $headers);
			$response_handler = xoops_getmodulehandler('response', 'clxsms');
			$response = $response_handler->create();
			if (!isset($ret['error'])) {
				$response->setVar('code', $ret['code']);
				$response->setVar('url', $url);
				$response->setVar('method', $method);
				$response->setVar('response', $ret['response']);
				$response->setVar('data', array_merge($ret['data'], array('parameters'=>array('get'=>$get, 'post' => $post))));
				$response_id = $response_handler->insert($response);
				return array_merge($ret, array('response_id'=>$response_id));
			}
			$response->setVar('code', 401);
			$response->setVar('url', $url);
			$response->setVar('method', $method);
			$response->setVar('response', '');
			$response->setVar('data', array('parameters'=>array('get'=>$get, 'post' => $post)));
			$response_id = $response_handler->insert($response);
			return array('code'=>401, 'response'=>'', 'data'=>$ret, 'response_id'=>$response_id);
		}
		trigger_error('Class "'.$class_name.'" not functioning or not found!', E_WARNING);
		return array('code'=>401, 'response'=>'', 'data'=>array('error'=>true, 'message'=>'Class "'.$class_name.'" not functioning or not found!'));
	}
}
