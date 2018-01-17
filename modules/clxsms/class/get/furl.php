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
class CLXsmsGetFurl extends CLXsmsGet
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
		if (!strpos($url, "?"))
			$url = $url . "?" . http_build_query($get);
		else 
			$url = $url . "&" . http_build_query($get);
		
		if (!empty($headers)&&is_array($headers)&&count($headers)>0) {
			$headerTxt = '';
			foreach($headers as $key => $value) {
				if (!is_array($value))
					$headerTxt .= $key . ": " . $value . "\n";
			}
			if (strlen($headerTxt)>0) {
				$opts = array(
						'http'=>array(
								'method'=>"GET",
								'header'=>$headerTxt
						)
				);
				
			}
		}
		
		if (!empty($post)&&is_array($post)&&count($post)>0) {
			if (isset($opt)&&is_array($opts)) {
				$opt['http']['method'] = 'POST';
				$opt['http']['header'] .= "\n\rContent-type: application/x-www-form-urlencoded";
				$opt['http']['content'] = http_build_query($post);
			} else {
				$opts = array('http' =>
						array(
								'method'  => 'POST',
								'header'  => 'Content-type: application/x-www-form-urlencoded',
								'content' => http_build_query($post)
						)
				);
			}
		}
		
		if (isset($opt)&&is_array($opts)) {
			$context  = stream_context_create($opts);
		}
		
		if (isset($context))
			$response = file_get_contents($url, false, $context);		
		else 
			$response = file_get_contents($url, false);
		return array('code'=>(strlen($response)>0?200:401), 'response'=>$response, 'data'=>array());
	}
}
