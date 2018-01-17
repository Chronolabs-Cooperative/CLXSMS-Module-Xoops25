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

$explicit = array();
foreach($GLOBALS['_CLXSMS_LEVEL_ORDER'] as $priority) {
	if (in_array($priority, getCLXSMSConfig('sms_levels_anyway'))) {
		$explicit[$priority] = $priority;
	}
}

$implicit = array();
foreach($GLOBALS['_CLXSMS_LEVEL_ORDER'] as $priority) {
	if (!in_array($priority, $explicit)) {
		$implicit[$priority] = $priority;
	}
}
	
$days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

$retrieve = getURLRetriever();
$sent_handler = xoops_getmodulehandler('sent', 'clxsms');
$statistics_handler = xoops_getmodulehandler('statistics', 'clxsms');

$messages = array();
$messages['explicit'] = $sent_handler->getSMSToSend($explicit);
$messages['implicit'] = $sent_handler->getSMSToSend($implicit);

foreach($messages as $state => $values) {
	foreach($values as $sent_id => $sms) {
		$send = false;
		switch($state) {
			case 'explicit':
				$send = true;
				break;
			case 'implicit':
				if ($statistics_handler->SumCountStatistic('send', strtotime(date('Y-m-1 0:0:01')), strtotime(date('Y-m-'.$days.' 23:59:59')))<getCLXSMSConfig('max_sms_per_month')||getCLXSMSConfig('max_sms_per_month')==0) {
					if ($statistics_handler->SumCountStatistic('send', strtotime(date('Y-m-d 0:0:01')), strtotime(date('Y-m-d 23:59:59')))<getCLXSMSConfig('max_sms_per_day')||getCLXSMSConfig('max_sms_per_day')==0) {
						$send = true;
					}
				}
				break;
		}
		
		$get = array();
		$post = array();
		$headers = array();

		// Sets GET method variables
		$get['S']='H';
		$get['UN']=getCLXSMSConfig('username');
		$get['P']=getCLXSMSConfig('password');
		$get['DA']=$sms->to()->getVar('number');
		$get['SA']=$sms->from()->getVar('number');
		$get['M']=$sms->message()->getVar('content');
		$get['ST']=is_numeric($get['SA'])?1:5;
		$get['DC']=1;
		$get['DR']=1;
		$get['UR']=$sent_id;
		$get['V']=3600*3.75;
		
		$result = $retrieve->get(getAPIRURL(), $get, $post, $headers);
		
		if ($result['code'] == 400) {
			$sms->setVar('retry', time() + getCLXSMSConfig('retry_seconds'));
			$sent_handler->insert($sms, true);
			$statistics_handler->AddErrorStatistic('send');
		} elseif ($result['code'] == 401) {
			xoops_load('XoopsCache');
			if (!$ret = XoopsCache::read('clxsms_bad_credentials')) {
				$xoopsMailer =& xoops_getMailer();
				$xoopsMailer->reset();
				$xoopsMailer->useMail();
				$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/clxsms/language/english/mail_templates/'));
				$xoopsMailer->setTemplate('badcredentials.tpl');
				$xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->assign('ADMINMAIL', $GLOBALS['xoopsConfig']['adminmail']);
				$xoopsMailer->assign('SITEURL', XOOPS_URL."/");
				$xoopsMailer->setToGroups(getCLXSMSConfig('no_credit_notify'));
				$xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
				$xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->setSubject($GLOBALS['xoopsConfig']['sitename'] . ' - Username or Password is wrong for SMS Gateway!');
				@$xoopsMailer->send(true);
				XoopsCache::write('clxsms_bad_credentials', array('when'=>microtime(true)), (3600 * 1.32));
			}
			$statistics_handler->AddErrorStatistic('send');
		} elseif ($result['code'] == 402) {
			xoops_load('XoopsCache');
			if (!$ret = XoopsCache::read('clxsms_out_of_credit')) {
				$xoopsMailer =& xoops_getMailer();
				$xoopsMailer->reset();
				$xoopsMailer->useMail();
				$xoopsMailer->setTemplateDir($GLOBALS['xoops']->path('/modules/clxsms/language/english/mail_templates/'));
				$xoopsMailer->setTemplate('nocredits.tpl');
				$xoopsMailer->assign('SITENAME', $GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->assign('ADMINMAIL', $GLOBALS['xoopsConfig']['adminmail']);
				$xoopsMailer->assign('SITEURL', XOOPS_URL."/");
				$xoopsMailer->setToGroups(getCLXSMSConfig('no_credit_notify'));
				$xoopsMailer->setFromEmail($GLOBALS['xoopsConfig']['adminmail']);
				$xoopsMailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
				$xoopsMailer->setSubject($GLOBALS['xoopsConfig']['sitename'] . ' - Is out of SMS Credits!');
				@$xoopsMailer->send(true);
				XoopsCache::write('clxsms_out_of_credit', array('when'=>microtime(true)), strtotime('Y-m-d 23:59:59') - time() + (3600 * 1.32));
			}
			$statistics_handler->AddNoCreditStatistic('send');
		} elseif ($result['code'] == 503) {
			$statistics_handler->AddErrorStatistic('send');
			$sms->setVar('canceled', time());
			$sent_handler->insert($sms, true);
		} elseif ($result['code'] == 500) {
			$sms->setVar('retry', time() + getCLXSMSConfig('retry_seconds'));
			$sent_handler->insert($sms, true);
		} elseif ($result['code'] == 200) {
			$parts = explode(' ', $result['response']);
			if ($parts[0]=='OK') {
				if ($parts[1]=='-15') {
					$statistics_handler->AddErrorStatistic('send');
					$sms->setVar('canceled', time());
					$sent_handler->insert($sms, true);
				} elseif ($parts[1]=='-20') {
					$sms->setVar('retry', time() + getCLXSMSConfig('retry_seconds'));
					$sent_handler->insert($sms, true);
				} elseif (intval($parts[1])>0) {
					$sms->setVar('response_id', $result['response_id']);
					$sms->setVar('msgid', $parts[1]);
					$sms->setVar('sent', time());
				}
			} else {
				$sms->setVar('retry', time() + getCLXSMSConfig('retry_seconds'));
				$sent_handler->insert($sms, true);
			}
		}
	
	}
	
}

?>