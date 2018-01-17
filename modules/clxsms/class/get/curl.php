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

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'get.php';

/**
 * @subpackage data
 * @copyright copyright &copy; 2014 chrono.labs.coop
 */
class CLXsmsGetCurl extends CLXsmsGet
{	
	/**
	 * @var object
	 */
	var $curl_client = NULL;
	
	/**
	 * 
	 */
	function __construct() {
			
	}

	/**
	 *
	 * @param string $url
	 * @param unknown $get
	 * @param unknown $post
	 * @param unknown $headers
	 * @return multitype:multitype: number string
	 */
	function retrieve($url='', $get=array(), $post=array(), $headers=array())
	{
		$cookies = XOOPS_VAR_PATH.'/cache/xoops_cache/clxsms_'.md5($url).'.cookie';
		
		if (!strpos($url, "?"))
			$url = $url . "?" . http_build_query($get);
		else 
			$url = $url . "&" . http_build_query($get);
		
		if (!$this->curl_client = curl_init($url)) {
			trigger_error('Could not intialise CURL', E_WARNING);
			return array('error'=>true, 'message'=>'Could not intialise CURL');
		}
		
		if (!empty($post)&&is_array($post)&&count($post)>0) {
			curl_setopt($this->curl_client,CURLOPT_POST, true);
			curl_setopt($this->curl_client,CURLOPT_POSTFIELDS, http_build_query($post));
		} else {
			curl_setopt($this->curl_client,CURLOPT_POST, false);
		}
		
		if (!empty($headers)&&is_array($headers)&&count($headers)>0) {
			$headerTxt = '';
			foreach($headers as $key => $value) {
				if (!is_array($value))
					$headerTxt .= $key . ": " . $value . "\n";
			}
			if (strlen($headerTxt)>0) {
				curl_setopt($this->curl_client, CURLOPT_HTTPHEADER, array($headerTxt));
			}
		} 
		curl_setopt($this->curl_client, CURLOPT_CONNECTTIMEOUT, $this->configs['curl_connecttimeout']);
		curl_setopt($this->curl_client, CURLOPT_TIMEOUT, $this->configs['curl_timeout']);
		curl_setopt($this->curl_client, CURLOPT_COOKIEJAR, $cookies);
		curl_setopt($this->curl_client, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->curl_client, CURLOPT_HEADER, 1);
		curl_setopt($this->curl_client, CURLOPT_USERAGENT, $this->configs['curl_user_agent']);
		
		$resp = curl_exec($this->curl_client);	
		list($headers, $response) = explode("\r\n\r\n", $resp, 2);
		$headers = explode("\n", $headers);
		$info = curl_getinfo($this->curl_client);
		return array('code'=>$info['http_code'], 'response'=>$response, 'data'=>array_merge($info, array('headers'=>$headers)));
	}
}
