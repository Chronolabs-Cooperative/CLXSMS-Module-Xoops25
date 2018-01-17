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

require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'mainfile.php';
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';

if (getCLXSMSConfig('receive_method')=='callback') {
	exit(0);
}

$received_handler = xoops_getmodulehandler('received', 'clxsms');
$delievery_handler = xoops_getmodulehandler('delievery', 'clxsms');
$content_handler = xoops_getmodulehandler('content', 'clxsms');

$result = $retrieve->get('http://sms1.cardboardclx.com:9001/ClientDR/ClientDR', array('UN'=>getCLXSMSConfig('username'), 'P'=>getCLXSMSConfig('password')), array(), array());

if ($result['code']=='200') {
	$responses = processIncoming($result['response']);
	foreach($responses as $response) {
		if ($response[0] == "-1") {
			$from = getNumberArray($response[1]);
			$to = getNumberArray($response[2]);
			$content = $content_handler->create();
			$content->setVar('content', pack("H*", $response[7]));
			$content->setVar('method', 'received');
			$content = $content_handler->get($content_handler->insert($content, true));
			$sms = $received_handler->create();
			$sms->setVar('from_uid', $from['uid']);
			$sms->setVar('from_number_id', $from['number_id']);
			$sms->setVar('to_number_id', $to['number_id']);
			$sms->setVar('sms_content_id', $content->getVar('content_id'));
			$sms->setVar('response_id', $result['response_id']);
			$sms->setVar('method', 'polled');
			$received_handler->insert($sms, true);
		} else {
			$sms = $received_handler->create();
			foreach(array('msgid'=>0, 'source'=>1, 'destination'=>2, 'status'=>3, 'errorcode'=>4, 'datetime'=>5, 'userref'=>6) as $variable => $key)
				$sms->setVar($variable, substr($response[$key], 50, 0));
			$delievery_handler->insert($sms, true);
		}
		
	}
}
?>
